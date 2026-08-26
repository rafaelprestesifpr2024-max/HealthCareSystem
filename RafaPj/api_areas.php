<?php

/*
|--------------------------------------------------------------------------
| API DE ORIENTAÇÃO DE ÁREA MÉDICA
|--------------------------------------------------------------------------
| Recebe JSON via POST
| Analisa com Gemini
| Retorna JSON para o areas.php
|--------------------------------------------------------------------------
*/

header("Content-Type: application/json; charset=utf-8");

ini_set("display_errors", "0");
error_reporting(E_ALL);


/*
|--------------------------------------------------------------------------
| FUNÇÃO DE RESPOSTA
|--------------------------------------------------------------------------
*/

function responder(
    int $codigo,
    array $dados
): void {

    http_response_code($codigo);

    echo json_encode(
        $dados,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
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

        "erro" =>
            "Método não permitido. Utilize POST."

    ]);

}


/*
|--------------------------------------------------------------------------
| RECEBER JSON
|--------------------------------------------------------------------------
*/

$entrada =
    file_get_contents("php://input");


if (
    $entrada === false ||
    trim($entrada) === ""
) {

    responder(400, [

        "sucesso" => false,

        "erro" =>
            "Nenhum dado foi recebido."

    ]);

}


/*
|--------------------------------------------------------------------------
| DECODIFICAR JSON
|--------------------------------------------------------------------------
*/

$dados =
    json_decode(
        $entrada,
        true
    );


if (
    !is_array($dados)
) {

    responder(400, [

        "sucesso" => false,

        "erro" =>
            "O JSON enviado é inválido."

    ]);

}


/*
|--------------------------------------------------------------------------
| RECEBER CAMPOS
|--------------------------------------------------------------------------
*/

$nome =
    trim(
        (string) (
            $dados["nome"] ?? ""
        )
    );


$dataNascimento =
    trim(
        (string) (
            $dados["data_nascimento"] ?? ""
        )
    );


$sexo =
    trim(
        (string) (
            $dados["sexo"] ?? ""
        )
    );


$doencas =
    trim(
        (string) (
            $dados["doencas"] ?? ""
        )
    );


$sintomas =
    trim(
        (string) (
            $dados["sintomas"] ?? ""
        )
    );


$situacaoAtual =
    trim(
        (string) (
            $dados["situacao_atual"] ?? ""
        )
    );


$informacoesAdicionais =
    trim(
        (string) (
            $dados["informacoes_adicionais"] ?? ""
        )
    );


/*
|--------------------------------------------------------------------------
| VALIDAR CAMPOS OBRIGATÓRIOS
|--------------------------------------------------------------------------
*/

if ($nome === "") {

    responder(400, [

        "sucesso" => false,

        "erro" =>
            "O nome do paciente é obrigatório."

    ]);

}


if ($dataNascimento === "") {

    responder(400, [

        "sucesso" => false,

        "erro" =>
            "A data de nascimento é obrigatória."

    ]);

}


if ($sexo === "") {

    responder(400, [

        "sucesso" => false,

        "erro" =>
            "O sexo é obrigatório."

    ]);

}


if ($sintomas === "") {

    responder(400, [

        "sucesso" => false,

        "erro" =>
            "Os sintomas são obrigatórios."

    ]);

}


if ($situacaoAtual === "") {

    responder(400, [

        "sucesso" => false,

        "erro" =>
            "A situação atual é obrigatória."

    ]);

}


/*
|--------------------------------------------------------------------------
| CONFIGURAÇÃO DA API
|--------------------------------------------------------------------------
*/

$configPath =
    __DIR__ . "/config_api.php";


if (
    !file_exists($configPath)
) {

    responder(500, [

        "sucesso" => false,

        "erro" =>
            "Arquivo config_api.php não encontrado."

    ]);

}


$config =
    require $configPath;


if (
    !is_array($config)
) {

    responder(500, [

        "sucesso" => false,

        "erro" =>
            "O arquivo config_api.php não possui uma configuração válida."

    ]);

}


/*
|--------------------------------------------------------------------------
| CHAVE GEMINI
|--------------------------------------------------------------------------
*/

$apiKey =
    trim(
        (string) (
            $config["gemini_api_key"] ?? ""
        )
    );


if ($apiKey === "") {

    responder(500, [

        "sucesso" => false,

        "erro" =>
            "A chave da API do Gemini não está configurada."

    ]);

}


/*
|--------------------------------------------------------------------------
| MODELO
|--------------------------------------------------------------------------
*/

$modelo =
    trim(
        (string) (
            $config["gemini_model"] ??
            "gemini-2.5-flash"
        )
    );


/*
|--------------------------------------------------------------------------
| PROMPT
|--------------------------------------------------------------------------
*/

$prompt = <<<PROMPT

Você é um sistema auxiliar de orientação de pacientes.

Sua função NÃO é diagnosticar doenças.

Sua função é analisar as informações fornecidas pelo paciente
e indicar QUAL ÁREA MÉDICA OU HOSPITALAR É MAIS ADEQUADA
PARA ELE PROCURAR.

A resposta deve indicar uma área de atendimento ou especialidade.

Exemplos de áreas que podem ser utilizadas:

- Clínica Médica
- Cardiologia
- Neurologia
- Ortopedia
- Pediatria
- Ginecologia e Obstetrícia
- Dermatologia
- Oftalmologia
- Otorrinolaringologia
- Urologia
- Gastroenterologia
- Pneumologia
- Psiquiatria
- Psicologia
- Odontologia
- Endocrinologia
- Nefrologia
- Oncologia
- Reumatologia
- Infectologia
- Geriatria
- Cirurgia Geral
- Neurocirurgia
- Cirurgia Vascular
- Fisioterapia
- Fonoaudiologia
- Nutrição
- Serviço Social
- Outra área

IMPORTANTE:

Não classifique pela urgência.

O objetivo é identificar QUAL ESPECIALIDADE OU ÁREA
DE ATENDIMENTO deve ser consultada.

Por exemplo:

Dor de garganta, ouvido ou nariz:
Otorrinolaringologia.

Alterações de memória, convulsões, tremores ou outros sintomas
relacionados ao sistema nervoso:
Neurologia.

Alterações emocionais, ansiedade, depressão ou sofrimento psicológico:
Psicologia ou Psiquiatria, conforme as informações fornecidas.

Problemas de pele:
Dermatologia.

Problemas relacionados ao coração:
Cardiologia.

Problemas de visão:
Oftalmologia.

Problemas musculares, ósseos ou articulares:
Ortopedia.

Problemas hormonais, diabetes ou tireoide:
Endocrinologia.

Problemas renais ou urinários:
Nefrologia ou Urologia, conforme o caso.

Problemas digestivos:
Gastroenterologia.

Problemas respiratórios:
Pneumologia.

Se não houver informações suficientes para determinar uma área,
utilize "Clínica Médica" e informe na observação que a avaliação
de um profissional será necessária para definir a especialidade.

Não faça diagnóstico.

Não invente sintomas.

Utilize somente as informações fornecidas.

Paciente:

Nome:
$nome

Data de nascimento:
$dataNascimento

Sexo:
$sexo

Doenças ou condições de saúde:
$doencas

Sintomas:
$sintomas

Situação atual:
$situacaoAtual

Informações adicionais:
$informacoesAdicionais

Retorne SOMENTE um JSON no seguinte formato:

{
    "area_recomendada": "nome da área",
    "motivos": [
        "motivo 1",
        "motivo 2"
    ],
    "observacao": "observação",
    "alertas": []
}

PROMPT;


/*
|--------------------------------------------------------------------------
| PAYLOAD GEMINI
|--------------------------------------------------------------------------
*/

$payload = [

    "contents" => [

        [

            "role" => "user",

            "parts" => [

                [

                    "text" =>
                        $prompt

                ]

            ]

        ]

    ],

    "generationConfig" => [

        "temperature" => 0.2,

        "responseMimeType" =>
            "application/json"

    ]

];


$jsonPayload =
    json_encode(
        $payload,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );


if (
    $jsonPayload === false
) {

    responder(500, [

        "sucesso" => false,

        "erro" =>
            "Não foi possível preparar a requisição para o Gemini."

    ]);

}


/*
|--------------------------------------------------------------------------
| URL GEMINI
|--------------------------------------------------------------------------
*/

$urlGemini =
    "https://generativelanguage.googleapis.com/v1beta/models/" .
    rawurlencode($modelo) .
    ":generateContent";


/*
|--------------------------------------------------------------------------
| CURL
|--------------------------------------------------------------------------
*/

if (
    !function_exists("curl_init")
) {

    responder(500, [

        "sucesso" => false,

        "erro" =>
            "A extensão cURL do PHP não está habilitada."

    ]);

}


$ch =
    curl_init(
        $urlGemini
    );


curl_setopt_array(

    $ch,

    [

        CURLOPT_RETURNTRANSFER =>
            true,

        CURLOPT_POST =>
            true,

        CURLOPT_HTTPHEADER => [

            "Content-Type: application/json",

            "x-goog-api-key: " . $apiKey

        ],

        CURLOPT_POSTFIELDS =>
            $jsonPayload,

        CURLOPT_CONNECTTIMEOUT =>
            15,

        CURLOPT_TIMEOUT =>
            60

    ]

);


$resposta =
    curl_exec($ch);


/*
|--------------------------------------------------------------------------
| ERRO CURL
|--------------------------------------------------------------------------
*/

if (
    $resposta === false
) {

    $erroCurl =
        curl_error($ch);

    curl_close($ch);

    responder(502, [

        "sucesso" => false,

        "erro" =>
            "Erro de comunicação com o Gemini.",

        "detalhes" =>
            $erroCurl

    ]);

}


/*
|--------------------------------------------------------------------------
| STATUS HTTP
|--------------------------------------------------------------------------
*/

$httpCode =
    curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );


curl_close($ch);


/*
|--------------------------------------------------------------------------
| VERIFICAR HTTP GEMINI
|--------------------------------------------------------------------------
*/

if (
    $httpCode < 200 ||
    $httpCode >= 300
) {

    $erroGemini =
        json_decode(
            $resposta,
            true
        );


    $mensagem =
        "O Gemini retornou HTTP " .
        $httpCode . ".";


    if (
        is_array($erroGemini) &&
        isset(
            $erroGemini["error"]["message"]
        )
    ) {

        $mensagem .=
            " " .
            $erroGemini["error"]["message"];

    }


    responder(502, [

        "sucesso" => false,

        "erro" =>
            $mensagem

    ]);

}


/*
|--------------------------------------------------------------------------
| DECODIFICAR RESPOSTA DO GEMINI
|--------------------------------------------------------------------------
*/

$respostaGemini =
    json_decode(
        $resposta,
        true
    );


if (
    !is_array($respostaGemini)
) {

    responder(502, [

        "sucesso" => false,

        "erro" =>
            "A resposta do Gemini não é um JSON válido."

    ]);

}


/*
|--------------------------------------------------------------------------
| EXTRAIR TEXTO
|--------------------------------------------------------------------------
*/

$textoIA = "";


if (
    isset(
        $respostaGemini["candidates"]
    ) &&
    is_array(
        $respostaGemini["candidates"]
    )
) {

    foreach (

        $respostaGemini["candidates"]

        as $candidate

    ) {

        if (
            !isset(
                $candidate["content"]["parts"]
            )
        ) {

            continue;

        }


        foreach (

            $candidate["content"]["parts"]

            as $part

        ) {

            if (
                isset($part["text"])
            ) {

                $textoIA .=
                    $part["text"];

            }

        }

    }

}


/*
|--------------------------------------------------------------------------
| TEXTO VAZIO
|--------------------------------------------------------------------------
*/

$textoIA =
    trim($textoIA);


if (
    $textoIA === ""
) {

    responder(502, [

        "sucesso" => false,

        "erro" =>
            "O Gemini não retornou uma orientação."

    ]);

}


/*
|--------------------------------------------------------------------------
| DECODIFICAR JSON DA IA
|--------------------------------------------------------------------------
*/

$orientacao =
    json_decode(
        $textoIA,
        true
    );


if (
    !is_array($orientacao)
) {

    responder(502, [

        "sucesso" => false,

        "erro" =>
            "O Gemini retornou uma orientação em formato inválido."

    ]);

}


/*
|--------------------------------------------------------------------------
| ÁREA
|--------------------------------------------------------------------------
*/

$area =
    trim(
        (string) (
            $orientacao["area_recomendada"] ??
            ""
        )
    );


if (
    $area === ""
) {

    responder(502, [

        "sucesso" => false,

        "erro" =>
            "O Gemini não informou a área recomendada."

    ]);

}


/*
|--------------------------------------------------------------------------
| MOTIVOS
|--------------------------------------------------------------------------
*/

$motivos =
    isset(
        $orientacao["motivos"]
    ) &&
    is_array(
        $orientacao["motivos"]
    )

    ? $orientacao["motivos"]

    : [];


/*
|--------------------------------------------------------------------------
| OBSERVAÇÃO
|--------------------------------------------------------------------------
*/

$observacao =
    trim(
        (string) (
            $orientacao["observacao"] ??
            ""
        )
    );


/*
|--------------------------------------------------------------------------
| ALERTAS
|--------------------------------------------------------------------------
*/

$alertas =
    isset(
        $orientacao["alertas"]
    ) &&
    is_array(
        $orientacao["alertas"]
    )

    ? $orientacao["alertas"]

    : [];


/*
|--------------------------------------------------------------------------
| RESPOSTA FINAL
|--------------------------------------------------------------------------
*/

responder(200, [

    "sucesso" => true,

    "orientacao" => [

        "area_recomendada" =>
            $area,

        "motivos" =>
            $motivos,

        "observacao" =>
            $observacao,

        "alertas" =>
            $alertas

    ]

]);

?>