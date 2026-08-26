<?php
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/conexao.php";
require_once __DIR__ . "/config_api.php";
/*
|--------------------------------------------------------------------------
| FUNÇÃO DE RESPOSTA
|--------------------------------------------------------------------------
*/
function responder(int $codigo, array $dados): void
{
    http_response_code($codigo);
    echo json_encode(
        $dados,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES |
        JSON_PRETTY_PRINT
    );
    exit;
}
/*
|--------------------------------------------------------------------------
| SOMENTE POST
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    responder(405, [
        "sucesso" => false,
        "erro" => "Método não permitido."
    ]);
}
/*
|--------------------------------------------------------------------------
| RECEBER JSON
|--------------------------------------------------------------------------
*/
$entrada = json_decode(
    file_get_contents("php://input"),
    true
);
if (!is_array($entrada)) {
    responder(400, [
        "sucesso" => false,
        "erro" => "JSON inválido."
    ]);
}
/*
|--------------------------------------------------------------------------
| DADOS DA TRIAGEM
|--------------------------------------------------------------------------
*/
$nome = trim($entrada["nome"] ?? "");
$idade = isset($entrada["idade"]) ? (int) $entrada["idade"] : null;
$sexo = trim($entrada["sexo"] ?? "");
$sintomas = trim($entrada["sintomas"] ?? "");
$pressao = trim($entrada["pressao"] ?? "");
$temperatura = trim($entrada["temperatura"] ?? "");
$saturacao = trim($entrada["saturacao"] ?? "");
$frequencia_cardiaca = trim($entrada["frequencia_cardiaca"] ?? "");
$observacoes = trim($entrada["observacoes"] ?? "");
/*
|--------------------------------------------------------------------------
| VALIDAÇÕES
|--------------------------------------------------------------------------
*/
if ($nome === "") {
    responder(422, [
        "sucesso" => false,
        "erro" => "Nome do paciente é obrigatório."
    ]);
}
if ($idade === null || $idade < 0 || $idade > 130) {
    responder(422, [
        "sucesso" => false,
        "erro" => "Idade inválida."
    ]);
}
if ($sintomas === "") {
    responder(422, [
        "sucesso" => false,
        "erro" => "Os sintomas são obrigatórios."
    ]);
}
/*
|--------------------------------------------------------------------------
| PROMPT DA IA
|--------------------------------------------------------------------------
*/
$prompt = <<<PROMPT
Você é um sistema auxiliar de classificação de risco hospitalar.
Analise os dados clínicos fornecidos e classifique a prioridade
do atendimento.
IMPORTANTE:
- Não faça diagnóstico.
- Não prescreva medicamentos.
- Não substitua um profissional de saúde.
- A classificação deve servir apenas como apoio à triagem.
- Em situações potencialmente graves, priorize a segurança do paciente.
DADOS DO PACIENTE:
Nome: {$nome}
Idade: {$idade}
Sexo: {$sexo}
Sintomas:
{$sintomas}
Pressão arterial:
{$pressao}
Temperatura:
{$temperatura}
Saturação:
{$saturacao}
Frequência cardíaca:
{$frequencia_cardiaca}
Observações:
{$observacoes}
Classifique a prioridade utilizando:
1 = Emergência
2 = Muito urgente
3 = Urgente
4 = Pouco urgente
5 = Não urgente
Retorne SOMENTE JSON válido.
PROMPT;
/*
|--------------------------------------------------------------------------
| CHAMADA À OPENAI
|--------------------------------------------------------------------------
*/
$payload = [
    "model" => OPENAI_MODEL,
    "input" => [
        [
            "role" => "system",
            "content" => [
                [
                    "type" => "input_text",
                    "text" => "Você é um sistema auxiliar de triagem hospitalar."
                ]
            ]
        ],
        [
            "role" => "user",
            "content" => [
                [
                    "type" => "input_text",
                    "text" => $prompt
                ]
            ]
        ]
    ],
    "text" => [
        "format" => [
            "type" => "json_schema",
            "name" => "triagem_hospitalar",
            "strict" => true,
            "schema" => [
                "type" => "object",
                "properties" => [
                    "classificacao" => [
                        "type" => "integer",
                        "enum" => [1, 2, 3, 4, 5]
                    ],
                    "prioridade" => [
                        "type" => "string"
                    ],
                    "justificativa" => [
                        "type" => "string"
                    ],
                    "sinais_alerta" => [
                        "type" => "array",
                        "items" => [
                            "type" => "string"
                        ]
                    ]
                ],
                "required" => [
                    "classificacao",
                    "prioridade",
                    "justificativa",
                    "sinais_alerta"
                ],
                "additionalProperties" => false
            ]
        ]
    ]
];
$ch = curl_init("https://api.openai.com/v1/responses");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . OPENAI_API_KEY
    ],
    CURLOPT_POSTFIELDS => json_encode(
        $payload,
        JSON_UNESCAPED_UNICODE
    )
]);
$resposta = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erroCurl = curl_error($ch);
curl_close($ch);
/*
|--------------------------------------------------------------------------
| ERRO DE CONEXÃO
|--------------------------------------------------------------------------
*/
if ($resposta === false) {
    responder(500, [
        "sucesso" => false,
        "erro" => "Erro ao conectar com o serviço de IA.",
        "detalhes" => $erroCurl
    ]);
}
/*
|--------------------------------------------------------------------------
| ERRO DA OPENAI
|--------------------------------------------------------------------------
*/
if ($httpCode < 200 || $httpCode >= 300) {
    $erroApi = json_decode($resposta, true);
    responder(502, [
        "sucesso" => false,
        "erro" => "Erro retornado pelo serviço de IA.",
        "detalhes" => $erroApi
    ]);
}
/*
|--------------------------------------------------------------------------
| INTERPRETAR RESPOSTA
|--------------------------------------------------------------------------
*/
$resultado = json_decode($resposta, true);
if (!is_array($resultado)) {
    responder(502, [
        "sucesso" => false,
        "erro" => "Resposta inválida da IA."
    ]);
}
/*
|--------------------------------------------------------------------------
| EXTRAIR TEXTO DA RESPONSA
|--------------------------------------------------------------------------
*/
$jsonIA = $resultado["output"][0]["content"][0]["text"] ?? null;
if (!$jsonIA) {
    responder(502, [
        "sucesso" => false,
        "erro" => "A IA não retornou uma classificação válida."
    ]);
}
$classificacao = json_decode($jsonIA, true);
if (!is_array($classificacao)) {
    responder(502, [
        "sucesso" => false,
        "erro" => "Não foi possível interpretar a classificação."
    ]);
}
/*
|--------------------------------------------------------------------------
| RESPOSTA FINAL
|--------------------------------------------------------------------------
*/
responder(200, [
    "sucesso" => true,
    "paciente" => [
        "nome" => $nome,
        "idade" => $idade,
        "sexo" => $sexo
    ],
    "triagem" => $classificacao
]);


