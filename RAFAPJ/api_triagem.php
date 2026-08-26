<?php
header("Content-Type: application/json; charset=utf-8");
include __DIR__ . "/conexao.php";
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
        "status" => "erro",
        "mensagem" => "Método não permitido. Utilize POST."
    ]);
}
/*
|--------------------------------------------------------------------------
| CAMPOS OBRIGATÓRIOS
|--------------------------------------------------------------------------
*/
$campos = [
    "nome",
    "data_nascimento",
    "data_triagem",
    "hora_triagem",
    "queixa_principal",
    "sintomas",
    "historico",
    "medicamentos",
    "alergias",
    "pressao",
    "temperatura",
    "frequencia",
    "saturacao",
    "dor"
];
foreach ($campos as $campo) {
    if (
        !isset($_POST[$campo]) ||
        trim((string) $_POST[$campo]) === ""
    ) {
        responder(400, [
            "status" => "erro",
            "mensagem" => "Campo obrigatório ausente: " . $campo
        ]);
    }
}
/*
|--------------------------------------------------------------------------
| DADOS
|--------------------------------------------------------------------------
*/
$nome = trim($_POST["nome"]);
$dataNascimento = trim(
    $_POST["data_nascimento"]
);
$dataTriagem = trim(
    $_POST["data_triagem"]
);
$horaTriagem = trim(
    $_POST["hora_triagem"]
);
$queixaPrincipal = trim(
    $_POST["queixa_principal"]
);
$sintomas = trim(
    $_POST["sintomas"]
);
$historico = trim(
    $_POST["historico"]
);
$medicamentos = trim(
    $_POST["medicamentos"]
);
$alergias = trim(
    $_POST["alergias"]
);
$pressaoTexto = trim(
    $_POST["pressao"]
);
$temperaturaTexto = trim(
    $_POST["temperatura"]
);
$frequenciaTexto = trim(
    $_POST["frequencia"]
);
$saturacaoTexto = trim(
    $_POST["saturacao"]
);
$dorTexto = trim(
    $_POST["dor"]
);
/*
|--------------------------------------------------------------------------
| DATA DE NASCIMENTO
|--------------------------------------------------------------------------
*/
$dataNascObj = DateTime::createFromFormat(
    "Y-m-d",
    $dataNascimento
);
if (
    !$dataNascObj ||
    $dataNascObj->format("Y-m-d") !== $dataNascimento
) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Data de nascimento inválida."
    ]);
}
/*
|--------------------------------------------------------------------------
| DATA DA TRIAGEM
|--------------------------------------------------------------------------
*/
$dataTriagemObj = DateTime::createFromFormat(
    "Y-m-d",
    $dataTriagem
);
if (
    !$dataTriagemObj ||
    $dataTriagemObj->format("Y-m-d") !== $dataTriagem
) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Data da triagem inválida."
    ]);
}
/*
|--------------------------------------------------------------------------
| HORA
|--------------------------------------------------------------------------
*/
$horaObj = DateTime::createFromFormat(
    "H:i",
    $horaTriagem
);
if (
    !$horaObj ||
    $horaObj->format("H:i") !== $horaTriagem
) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Hora da triagem inválida."
    ]);
}
/*
|--------------------------------------------------------------------------
| VERIFICAÇÃO DAS DATAS
|--------------------------------------------------------------------------
*/
if ($dataNascObj > $dataTriagemObj) {
    responder(400, [
        "status" => "erro",
        "mensagem" =>
            "A data de nascimento não pode ser posterior à triagem."
    ]);
}
/*
|--------------------------------------------------------------------------
| IDADE
|--------------------------------------------------------------------------
*/
$idade = $dataNascObj->diff(
    $dataTriagemObj
)->y;
if ($idade < 0 || $idade > 120) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Idade inválida."
    ]);
}
/*
|--------------------------------------------------------------------------
| PRESSÃO ARTERIAL
|--------------------------------------------------------------------------
*/
if (
    !preg_match(
        '/^\s*(\d{2,3})\s*[xX\/]\s*(\d{2,3})\s*$/',
        $pressaoTexto,
        $matches
    )
) {
    responder(400, [
        "status" => "erro",
        "mensagem" =>
            "Pressão inválida. Utilize o formato 120x80."
    ]);
}
$pressaoSistolica =
    (int) $matches[1];
$pressaoDiastolica =
    (int) $matches[2];
if (
    $pressaoSistolica < 40 ||
    $pressaoSistolica > 300 ||
    $pressaoDiastolica < 20 ||
    $pressaoDiastolica > 200
) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Valores de pressão inválidos."
    ]);
}
/*
|--------------------------------------------------------------------------
| TEMPERATURA
|--------------------------------------------------------------------------
*/
$temperaturaTexto = str_replace(
    [",", "°C", "°c", "C", "c"],
    [".", "", "", "", ""],
    $temperaturaTexto
);
$temperaturaTexto =
    trim($temperaturaTexto);
if (!is_numeric($temperaturaTexto)) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Temperatura inválida."
    ]);
}
$temperatura =
    (float) $temperaturaTexto;
if (
    $temperatura < 20 ||
    $temperatura > 50
) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Temperatura inválida."
    ]);
}
/*
|--------------------------------------------------------------------------
| FREQUÊNCIA CARDÍACA
|--------------------------------------------------------------------------
*/
$frequencia = filter_var(
    $frequenciaTexto,
    FILTER_VALIDATE_INT
);
if (
    $frequencia === false ||
    $frequencia < 0 ||
    $frequencia > 300
) {
    responder(400, [
        "status" => "erro",
        "mensagem" =>
            "Frequência cardíaca inválida."
    ]);
}
/*
|--------------------------------------------------------------------------
| SATURAÇÃO
|--------------------------------------------------------------------------
*/
$saturacao = filter_var(
    $saturacaoTexto,
    FILTER_VALIDATE_INT
);
if (
    $saturacao === false ||
    $saturacao < 0 ||
    $saturacao > 100
) {
    responder(400, [
        "status" => "erro",
        "mensagem" => "Saturação inválida."
    ]);
}
/*
|--------------------------------------------------------------------------
| DOR
|--------------------------------------------------------------------------
*/
$dor = filter_var(
    $dorTexto,
    FILTER_VALIDATE_INT
);
if (
    $dor === false ||
    $dor < 0 ||
    $dor > 10
) {
    responder(400, [
        "status" => "erro",
        "mensagem" =>
            "A dor deve estar entre 0 e 10."
    ]);
}
/*
|--------------------------------------------------------------------------
| CAMPOS OPCIONAIS
|--------------------------------------------------------------------------
*/
$gestante =
    isset($_POST["gestante"]) &&
    $_POST["gestante"] === "1";
$imunossuprimido =
    isset($_POST["imunossuprimido"]) &&
    $_POST["imunossuprimido"] === "1";
$cronico =
    isset($_POST["cronico"]) &&
    $_POST["cronico"] === "1";
$conscienciaAlterada =
    isset($_POST["consciencia"]) &&
    $_POST["consciencia"] === "alterada";
$hemorragia =
    isset($_POST["hemorragia"]) &&
    $_POST["hemorragia"] === "1";
$trauma =
    isset($_POST["trauma"]) &&
    $_POST["trauma"] === "1";
/*
|--------------------------------------------------------------------------
| NÍVEL DE RISCO
|--------------------------------------------------------------------------
*/
function nivelRisco(string $risco): int
{
    $niveis = [
        "Azul" => 1,
        "Verde" => 2,
        "Amarelo" => 3,
        "Laranja" => 4,
        "Vermelho" => 5
    ];
    return $niveis[$risco] ?? 0;
}
/*
|--------------------------------------------------------------------------
| REGRAS DE SEGURANÇA
|--------------------------------------------------------------------------
*/
$riscoMinimo = "Azul";
$motivosSeguranca = [];
/*
|--------------------------------------------------------------------------
| SINAIS DE MAIOR GRAVIDADE
|--------------------------------------------------------------------------
*/
if ($saturacao <= 91) {
    $riscoMinimo = "Vermelho";
    $motivosSeguranca[] =
        "Saturação muito reduzida.";
}
if ($conscienciaAlterada) {
    $riscoMinimo = "Vermelho";
    $motivosSeguranca[] =
        "Alteração de consciência informada.";
}
if ($hemorragia) {
    $riscoMinimo = "Vermelho";
    $motivosSeguranca[] =
        "Hemorragia informada.";
}
if ($trauma) {
    $riscoMinimo = "Vermelho";
    $motivosSeguranca[] =
        "Trauma informado.";
}
/*
|--------------------------------------------------------------------------
| PROTOCOLO PRELIMINAR
|--------------------------------------------------------------------------
*/
$peso = 0;
$motivosProtocolo = [];
/*
|--------------------------------------------------------------------------
| PRESSÃO
|--------------------------------------------------------------------------
*/
if ($pressaoSistolica < 90) {
    $peso += 3;
    $motivosProtocolo[] =
        "Pressão sistólica baixa.";
} elseif ($pressaoSistolica >= 180) {
    $peso += 2;
    $motivosProtocolo[] =
        "Pressão sistólica elevada.";
}
/*
|--------------------------------------------------------------------------
| FREQUÊNCIA
|--------------------------------------------------------------------------
*/
if (
    $frequencia < 50 ||
    $frequencia > 120
) {
    $peso += 3;
    $motivosProtocolo[] =
        "Frequência cardíaca fora da faixa definida.";
} elseif ($frequencia > 100) {
    $peso += 1;
    $motivosProtocolo[] =
        "Frequência cardíaca elevada.";
}
/*
|--------------------------------------------------------------------------
| SATURAÇÃO
|--------------------------------------------------------------------------
*/
if ($saturacao <= 91) {
    $peso += 3;
    $motivosProtocolo[] =
        "Saturação reduzida.";
} elseif ($saturacao <= 93) {
    $peso += 2;
    $motivosProtocolo[] =
        "Saturação abaixo da faixa definida.";
} elseif ($saturacao <= 95) {
    $peso += 1;
    $motivosProtocolo[] =
        "Saturação limítrofe.";
}
/*
|--------------------------------------------------------------------------
| TEMPERATURA
|--------------------------------------------------------------------------
*/
if (
    $temperatura >= 38.5 ||
    $temperatura < 35
) {
    $peso += 2;
    $motivosProtocolo[] =
        "Temperatura fora da faixa definida.";
} elseif ($temperatura >= 37.6) {
    $peso += 1;
    $motivosProtocolo[] =
        "Temperatura elevada.";
}
/*
|--------------------------------------------------------------------------
| DOR
|--------------------------------------------------------------------------
*/
if ($dor >= 7) {
    $peso += 2;
    $motivosProtocolo[] =
        "Dor intensa.";
} elseif ($dor >= 4) {
    $peso += 1;
    $motivosProtocolo[] =
        "Dor moderada.";
}
/*
|--------------------------------------------------------------------------
| IDADE
|--------------------------------------------------------------------------
*/
if (
    $idade < 1 ||
    $idade > 75
) {
    $peso += 2;
    $motivosProtocolo[] =
        "Faixa etária de maior atenção.";
}
/*
|--------------------------------------------------------------------------
| CONDIÇÕES ESPECIAIS
|--------------------------------------------------------------------------
*/
if ($gestante) {
    $peso += 2;
    $motivosProtocolo[] =
        "Gestação.";
}
if ($imunossuprimido) {
    $peso += 2;
    $motivosProtocolo[] =
        "Imunossupressão.";
}
if ($cronico) {
    $peso += 1;
    $motivosProtocolo[] =
        "Doença crônica informada.";
}
/*
|--------------------------------------------------------------------------
| CLASSIFICAÇÃO PRELIMINAR
|--------------------------------------------------------------------------
*/
if ($peso >= 9) {
    $riscoPreliminar = "Vermelho";
} elseif ($peso >= 7) {
    $riscoPreliminar = "Laranja";
} elseif ($peso >= 5) {
    $riscoPreliminar = "Amarelo";
} elseif ($peso >= 3) {
    $riscoPreliminar = "Verde";
} else {
    $riscoPreliminar = "Azul";
}
/*
|--------------------------------------------------------------------------
| VARIÁVEIS DA IA
|--------------------------------------------------------------------------
*/
$riscoIA = null;
$analiseIA = null;
$confiancaIA = null;
$necessitaConferenciaIA = null;
$motivosIA = [];
$alertasIA = [];
$observacaoIA = null;
$statusIA = "nao_analisada";
$erroIA = null;
/*
|--------------------------------------------------------------------------
| CONFIGURAÇÃO DO GEMINI
|--------------------------------------------------------------------------
*/
$configPath =
    __DIR__ . "/config_api.php";
if (!file_exists($configPath)) {
    responder(500, [
        "status" => "erro",
        "mensagem" =>
            "Arquivo config_api.php não encontrado.",
        "ia" => [
            "status" =>
                "erro_configuracao"
        ]
    ]);
}
$config = require $configPath;
if (!is_array($config)) {
    responder(500, [
        "status" => "erro",
        "mensagem" =>
            "config_api.php não retornou uma configuração válida.",
        "ia" => [
            "status" =>
                "erro_configuracao"
        ]
    ]);
}
$apiKey = trim(
    (string) ($config["gemini_api_key"] ?? "")
);
if (
    $apiKey === "" ||
    stripos($apiKey, "SUA_CHAVE") !== false ||
    stripos($apiKey, "MINHA_CHAVE") !== false
) {
    responder(500, [
        "status" => "erro",
        "mensagem" =>
            "Chave do Gemini não configurada corretamente.",
        "ia" => [
            "status" =>
                "erro_configuracao"
        ]
    ]);
}
/*
|--------------------------------------------------------------------------
| MODELO GEMINI
|--------------------------------------------------------------------------
*/
$modeloGemini =
    $config["gemini_model"] ??
    "gemini-2.5-flash";
/*
|--------------------------------------------------------------------------
| DADOS ENVIADOS À IA
|--------------------------------------------------------------------------
*/
$dadosIA = [
    "idade" =>
        $idade,
    "pressao_sistolica" =>
        $pressaoSistolica,
    "pressao_diastolica" =>
        $pressaoDiastolica,
    "temperatura" =>
        $temperatura,
    "frequencia_cardiaca" =>
        $frequencia,
    "saturacao" =>
        $saturacao,
    "dor" =>
        $dor,
    "queixa_principal" =>
        $queixaPrincipal,
    "sintomas" =>
        $sintomas,
    "historico" =>
        $historico,
    "medicamentos" =>
        $medicamentos,
    "alergias" =>
        $alergias,
    "gestante" =>
        $gestante,
    "imunossuprimido" =>
        $imunossuprimido,
    "doenca_cronica" =>
        $cronico,
    "consciencia_alterada" =>
        $conscienciaAlterada,
    "hemorragia" =>
        $hemorragia,
    "trauma" =>
        $trauma,
    "risco_preliminar" =>
        $riscoPreliminar
];
/*
|--------------------------------------------------------------------------
| PROMPT
|--------------------------------------------------------------------------
*/
$prompt = <<<PROMPT
Você é um sistema AUXILIAR de classificação de prioridade em triagem.
Sua função é realizar uma segunda análise dos dados fornecidos.
Você NÃO substitui um profissional de saúde.
Não faça diagnóstico.
Não invente informações.
Não altere os dados fornecidos.
Categorias:
Azul = Não urgente
Verde = Pouco urgente
Amarelo = Urgente
Laranja = Muito urgente
Vermelho = Emergência
A classificação preliminar calculada pelo protocolo foi:
{$riscoPreliminar}
Você pode manter essa classificação ou elevar a prioridade quando os dados indicarem maior gravidade.
Nunca reduza uma classificação determinada pelas regras de segurança.
Se houver informação insuficiente, inconsistência ou situação que necessite avaliação profissional, marque "necessita_conferencia" como true.
Analise somente os dados fornecidos.
Retorne somente o objeto JSON solicitado.
PROMPT;
$prompt .=
    "\n\nDados do paciente:\n";
$prompt .= json_encode(
    $dadosIA,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES |
    JSON_PRETTY_PRINT
);
/*
|--------------------------------------------------------------------------
| SCHEMA DO JSON
|--------------------------------------------------------------------------
|
| IMPORTANTE:
|
| Não usar "additionalProperties" aqui.
| A versão da API GenerateContent utilizada
| pelo endpoint pode rejeitar esse campo.
|
|--------------------------------------------------------------------------
*/
$schemaGemini = [
    "type" => "OBJECT",
    "properties" => [
        "prioridade" => [
            "type" => "STRING",
            "enum" => [
                "Azul",
                "Verde",
                "Amarelo",
                "Laranja",
                "Vermelho"
            ]
        ],
        "confianca" => [
            "type" => "STRING",
            "enum" => [
                "alta",
                "media",
                "baixa"
            ]
        ],
        "necessita_conferencia" => [
            "type" => "BOOLEAN"
        ],
        "alertas" => [
            "type" => "ARRAY",
            "items" => [
                "type" => "STRING"
            ]
        ],
        "motivos" => [
            "type" => "ARRAY",
            "items" => [
                "type" => "STRING"
            ]
        ],
        "observacao" => [
            "type" => "STRING"
        ]
    ],
    "required" => [
        "prioridade",
        "confianca",
        "necessita_conferencia",
        "alertas",
        "motivos",
        "observacao"
    ]
];
/*
|--------------------------------------------------------------------------
| PAYLOAD GEMINI
|--------------------------------------------------------------------------
*/
$payload = [
    "systemInstruction" => [
        "parts" => [
            [
                "text" =>
                    "Você é um sistema auxiliar de classificação de prioridade em triagem. Retorne somente o objeto JSON solicitado."
            ]
        ]
    ],
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
        "responseMimeType" =>
            "application/json",
        "responseSchema" =>
            $schemaGemini
    ]
];
/*
|--------------------------------------------------------------------------
| GERAR JSON
|--------------------------------------------------------------------------
*/
$jsonPayload = json_encode(
    $payload,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
);
if ($jsonPayload === false) {
    responder(500, [
        "status" => "erro",
        "mensagem" =>
            "Não foi possível montar o JSON enviado ao Gemini.",
        "ia" => [
            "status" =>
                "erro_payload"
        ]
    ]);
}
/*
|--------------------------------------------------------------------------
| URL GEMINI
|--------------------------------------------------------------------------
*/
$urlGemini =
    "https://generativelanguage.googleapis.com/v1beta/models/" .
    rawurlencode($modeloGemini) .
    ":generateContent";
/*
|--------------------------------------------------------------------------
| CURL GEMINI
|--------------------------------------------------------------------------
*/
$ch = curl_init(
    $urlGemini
);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER =>
        true,
    CURLOPT_POST =>
        true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "x-goog-api-key: " .
            $apiKey
    ],
    CURLOPT_POSTFIELDS =>
        $jsonPayload,
    CURLOPT_CONNECTTIMEOUT =>
        10,
    CURLOPT_TIMEOUT =>
        60
]);
$resposta =
    curl_exec($ch);
if ($resposta === false) {
    $erroCurl =
        curl_error($ch);
    curl_close($ch);
    responder(502, [
        "status" =>
            "erro",
        "mensagem" =>
            "Erro de comunicação com o Gemini.",
        "ia" => [
            "status" =>
                "erro_conexao",
            "erro" =>
                $erroCurl
        ]
    ]);
}
$httpCode =
    curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );
curl_close($ch);
/*
|--------------------------------------------------------------------------
| HTTP DO GEMINI
|--------------------------------------------------------------------------
*/
if (
    $httpCode < 200 ||
    $httpCode >= 300
) {
    $statusIA =
        "erro_api";
    $erroIA =
        "Gemini retornou HTTP " .
        $httpCode . ".";
    $respostaDecodificada =
        json_decode(
            $resposta,
            true
        );
    if (
        is_array(
            $respostaDecodificada
        )
    ) {
        if (
            isset(
                $respostaDecodificada["error"]["message"]
            )
        ) {
            $erroIA .=
                " " .
                $respostaDecodificada[
                    "error"
                ][
                    "message"
                ];
        }
        if (
            isset(
                $respostaDecodificada["error"]["status"]
            )
        ) {
            $erroIA .=
                " Status: " .
                $respostaDecodificada[
                    "error"
                ][
                    "status"
                ] . ".";
        }
    } else {
        $erroIA .=
            " Resposta bruta: " .
            substr(
                $resposta,
                0,
                1000
            );
    }
    responder(500, [
        "status" =>
            "erro",
        "mensagem" =>
            $erroIA,
        "http_code" =>
            $httpCode,
        "ia" => [
            "status" =>
                $statusIA
        ]
    ]);
}
/*
|--------------------------------------------------------------------------
| DECODIFICAR RESPOSTA
|--------------------------------------------------------------------------
*/
$resultadoGemini =
    json_decode(
        $resposta,
        true
    );
if (
    !is_array(
        $resultadoGemini
    )
) {
    responder(502, [
        "status" =>
            "erro",
        "mensagem" =>
            "A resposta do Gemini não é um JSON válido.",
        "ia" => [
            "status" =>
                "resposta_invalida"
        ]
    ]);
}
/*
|--------------------------------------------------------------------------
| EXTRAIR TEXTO DO GEMINI
|--------------------------------------------------------------------------
*/
$texto = "";
if (
    isset(
        $resultadoGemini["candidates"]
    ) &&
    is_array(
        $resultadoGemini["candidates"]
    )
) {
    foreach (
        $resultadoGemini["candidates"]
        as $candidate
    ) {
        if (
            !isset(
                $candidate["content"]["parts"]
            ) ||
            !is_array(
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
                isset(
                    $part["text"]
                ) &&
                is_string(
                    $part["text"]
                )
            ) {
                $texto .=
                    $part["text"];
            }
        }
    }
}
/*
|--------------------------------------------------------------------------
| RESPOSTA VAZIA
|--------------------------------------------------------------------------
*/
if (
    trim($texto) === ""
) {
    responder(502, [
        "status" =>
            "erro",
        "mensagem" =>
            "O Gemini respondeu, mas não retornou a classificação estruturada.",
        "ia" => [
            "status" =>
                "resposta_vazia"
        ]
    ]);
}
/*
|--------------------------------------------------------------------------
| INTERPRETAR JSON DA IA
|--------------------------------------------------------------------------
*/
$textoLimpo =
    trim($texto);
$analiseIA =
    json_decode(
        $textoLimpo,
        true
    );
if (
    !is_array(
        $analiseIA
    )
) {
    responder(502, [
        "status" =>
            "erro",
        "mensagem" =>
            "O Gemini retornou conteúdo, mas a classificação não pôde ser interpretada.",
        "ia" => [
            "status" =>
                "resposta_invalida"
        ]
    ]);
}
/*
|--------------------------------------------------------------------------
| VALIDAR CLASSIFICAÇÃO
|--------------------------------------------------------------------------
*/
$prioridadesValidas = [
    "Azul",
    "Verde",
    "Amarelo",
    "Laranja",
    "Vermelho"
];
if (
    !isset(
        $analiseIA["prioridade"]
    ) ||
    !in_array(
        $analiseIA["prioridade"],
        $prioridadesValidas,
        true
    )
) {
    responder(502, [
        "status" =>
            "erro",
        "mensagem" =>
            "O Gemini não retornou uma prioridade válida.",
        "ia" => [
            "status" =>
                "resposta_invalida"
        ]
    ]);
}
/*
|--------------------------------------------------------------------------
| DADOS DA IA
|--------------------------------------------------------------------------
*/
$riscoIA =
    $analiseIA["prioridade"];
$confiancaIA =
    $analiseIA["confianca"] ??
    null;
$necessitaConferenciaIA =
    isset(
        $analiseIA[
            "necessita_conferencia"
        ]
    )
        ? (bool)
            $analiseIA[
                "necessita_conferencia"
            ]
        : null;
$motivosIA =
    isset(
        $analiseIA["motivos"]
    ) &&
    is_array(
        $analiseIA["motivos"]
    )
        ? $analiseIA["motivos"]
        : [];
$alertasIA =
    isset(
        $analiseIA["alertas"]
    ) &&
    is_array(
        $analiseIA["alertas"]
    )
        ? $analiseIA["alertas"]
        : [];
$observacaoIA =
    isset(
        $analiseIA["observacao"]
    )
        ? (string)
            $analiseIA["observacao"]
        : null;
$statusIA =
    "analisada";
/*
|--------------------------------------------------------------------------
| PRIORIDADE FINAL
|--------------------------------------------------------------------------
*/
$riscoFinal =
    $riscoPreliminar;
$origem =
    "protocolo";
$nivelIA =
    nivelRisco(
        $riscoIA
    );
$nivelFinal =
    nivelRisco(
        $riscoFinal
    );
if (
    $nivelIA >
    $nivelFinal
) {
    $riscoFinal =
        $riscoIA;
    $origem =
        "protocolo_mais_ia";
} elseif (
    $nivelIA ===
    $nivelFinal
) {
    $origem =
        "protocolo_e_ia";
}
/*
|--------------------------------------------------------------------------
| PROTEÇÃO DAS REGRAS DE SEGURANÇA
|--------------------------------------------------------------------------
*/
if (
    nivelRisco(
        $riscoMinimo
    ) >
    nivelRisco(
        $riscoFinal
    )
) {
    $riscoFinal =
        $riscoMinimo;
    $origem =
        "protocolo_de_seguranca";
}
/*
|--------------------------------------------------------------------------
| DESCRIÇÃO
|--------------------------------------------------------------------------
*/
$descricoes = [
    "Azul" =>
        "Não urgente",
    "Verde" =>
        "Pouco urgente",
    "Amarelo" =>
        "Urgente",
    "Laranja" =>
        "Muito urgente",
    "Vermelho" =>
        "Emergência"
];
$descricao =
    $descricoes[
        $riscoFinal
    ];
/*
|--------------------------------------------------------------------------
| BANCO DE DADOS
|--------------------------------------------------------------------------
*/
if (
    !isset($conn) ||
    !$conn
) {
    responder(500, [
        "status" =>
            "erro",
        "mensagem" =>
            "Falha na conexão com o banco."
    ]);
}
/*
|--------------------------------------------------------------------------
| INSERT
|--------------------------------------------------------------------------
*/
$sql = "
    INSERT INTO pacientes (
        nome,
        data_nascimento,
        data_triagem,
        hora_triagem,
        queixa_principal,
        sintomas,
        historico,
        medicamentos,
        alergias,
        pressao,
        temperatura,
        frequencia,
        saturacao,
        dor,
        risco
    )
    VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?
    )
";
$stmt =
    $conn->prepare(
        $sql
    );
if (!$stmt) {
    responder(500, [
        "status" =>
            "erro",
        "mensagem" =>
            "Erro ao preparar consulta.",
        "detalhes" =>
            $conn->error
    ]);
}
/*
|--------------------------------------------------------------------------
| BIND
|--------------------------------------------------------------------------
*/
$stmt->bind_param(
    "ssssssssssdiiis",
    $nome,
    $dataNascimento,
    $dataTriagem,
    $horaTriagem,
    $queixaPrincipal,
    $sintomas,
    $historico,
    $medicamentos,
    $alergias,
    $pressaoTexto,
    $temperatura,
    $frequencia,
    $saturacao,
    $dor,
    $riscoFinal
);
/*
|--------------------------------------------------------------------------
| EXECUTAR
|--------------------------------------------------------------------------
*/
if (!$stmt->execute()) {
    $erroBanco =
        $stmt->error;
    $stmt->close();
    responder(500, [
        "status" =>
            "erro",
        "mensagem" =>
            "Não foi possível salvar a triagem.",
        "detalhes" =>
            $erroBanco
    ]);
}
$idPaciente =
    $stmt->insert_id;
$stmt->close();
/*
|--------------------------------------------------------------------------
| RESPOSTA FINAL
|--------------------------------------------------------------------------
*/
$respostaFinal = [
    "status" =>
        "sucesso",
    "mensagem" =>
        "Triagem registrada com sucesso.",
    "paciente" => [
        "id" =>
            $idPaciente,
        "nome" =>
            $nome,
        "idade" =>
            $idade
    ],
    "avaliacao" => [
        "risco_preliminar" =>
            $riscoPreliminar,
        "prioridade_ia" =>
            $riscoIA,
        "prioridade_final" =>
            $riscoFinal,
        "descricao" =>
            $descricao,
        "origem" =>
            $origem,
        "motivos" =>
            $motivosProtocolo,
        "alertas_seguranca" =>
            $motivosSeguranca
    ],
    "ia" => [
        "status" =>
            $statusIA,
        "prioridade" =>
            $riscoIA,
        "confianca" =>
            $confiancaIA,
        "necessita_conferencia" =>
            $necessitaConferenciaIA,
        "motivos" =>
            $motivosIA,
        "alertas" =>
            $alertasIA,
        "observacao" =>
            $observacaoIA,
        "erro" =>
            $erroIA
    ]
];
/*
|--------------------------------------------------------------------------
| RESPOSTA
|--------------------------------------------------------------------------
*/
responder(
    201,
    $respostaFinal
);
?>



