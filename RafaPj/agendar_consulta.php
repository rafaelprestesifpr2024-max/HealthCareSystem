<?php


require_once "conexao.php";


/*
|--------------------------------------------------------------------------
| CONFIGURAÇÕES
|--------------------------------------------------------------------------
*/


$limiteConsultas = 10;


$horariosDisponiveis = [
    "08:00",
    "08:30",
    "09:00",
    "09:30",
    "10:00",
    "10:30",
    "11:00",
    "11:30",
    "13:00",
    "13:30",
    "14:00",
    "14:30",
    "15:00",
    "15:30",
    "16:00",
    "16:30"
];


/*
|--------------------------------------------------------------------------
| VARIÁVEIS
|--------------------------------------------------------------------------
*/


$nome = "";
$email = "";
$telefone = "";
$endereco = "";


$especialidade = "";
$motivo = "";
$problema = "";
$objetivo = "";
$observacoes = "";


$data = "";
$hora = "";


$erro = "";
$sucesso = "";


/*
|--------------------------------------------------------------------------
| PROCESSAMENTO
|--------------------------------------------------------------------------
*/


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $endereco = trim($_POST["endereco"] ?? "");


    $especialidade = trim($_POST["especialidade"] ?? "");
    $motivo = trim($_POST["motivo"] ?? "");
    $problema = trim($_POST["problema"] ?? "");
    $objetivo = trim($_POST["objetivo"] ?? "");
    $observacoes = trim($_POST["observacoes"] ?? "");


    $data = trim($_POST["data"] ?? "");
    $hora = trim($_POST["hora"] ?? "");


    /*
    |--------------------------------------------------------------------------
    | VALIDA CAMPOS
    |--------------------------------------------------------------------------
    */


    if (
        $nome === "" ||
        $email === "" ||
        $telefone === "" ||
        $endereco === "" ||
        $especialidade === "" ||
        $motivo === "" ||
        $problema === "" ||
        $objetivo === "" ||
        $data === "" ||
        $hora === ""
    ) {


        $erro = "Preencha todos os campos obrigatórios.";


    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {


        $erro = "Informe um e-mail válido.";


    } elseif (!in_array($hora, $horariosDisponiveis, true)) {


        $erro = "O horário selecionado é inválido.";


    } else {


        /*
        |--------------------------------------------------------------------------
        | VERIFICA DATA
        |--------------------------------------------------------------------------
        */


        $hoje = date("Y-m-d");


        if ($data < $hoje) {


            $erro = "Não é possível agendar uma consulta para uma data passada.";


        } else {


            /*
            |--------------------------------------------------------------------------
            | VERIFICA LIMITE DO DIA
            |--------------------------------------------------------------------------
            */


            $sql = "
                SELECT COUNT(*) AS total
                FROM consultas
                WHERE data_consulta = ?
                AND status = 'agendada'
            ";


            $stmt = $conn->prepare($sql);


            if (!$stmt) {


                $erro = "Erro no banco: " . $conn->error;


            } else {


                $stmt->bind_param("s", $data);
                $stmt->execute();


                $resultado = $stmt->get_result();
                $dados = $resultado->fetch_assoc();


                $total = (int) $dados["total"];


                $stmt->close();


                if ($total >= $limiteConsultas) {


                    $erro = "Este dia já atingiu o limite de 10 consultas.";


                } else {


                    /*
                    |--------------------------------------------------------------------------
                    | VERIFICA HORÁRIO
                    |--------------------------------------------------------------------------
                    */


                    $sql = "
                        SELECT id
                        FROM consultas
                        WHERE data_consulta = ?
                        AND hora_consulta = ?
                        AND status = 'agendada'
                        LIMIT 1
                    ";


                    $stmt = $conn->prepare($sql);


                    if (!$stmt) {


                        $erro = "Erro no banco: " . $conn->error;


                    } else {


                        $stmt->bind_param(
                            "ss",
                            $data,
                            $hora
                        );


                        $stmt->execute();


                        $resultado = $stmt->get_result();


                        $ocupado = $resultado->num_rows > 0;


                        $stmt->close();


                        if ($ocupado) {


                            $erro = "Esse horário já está ocupado.";


                        } else {


                            /*
                            |--------------------------------------------------------------------------
                            | INSERE CONSULTA
                            |--------------------------------------------------------------------------
                            */


                            $sql = "
                                INSERT INTO consultas
                                (
                                    nome_paciente,
                                    email_paciente,
                                    telefone_paciente,
                                    endereco_paciente,
                                    especialidade,
                                    motivo,
                                    problema,
                                    objetivo,
                                    observacoes,
                                    data_consulta,
                                    hora_consulta,
                                    status
                                )
                                VALUES
                                (
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    ?,
                                    'agendada'
                                )
                            ";


                            $stmt = $conn->prepare($sql);


                            if (!$stmt) {


                                $erro = "Erro ao preparar o agendamento: " . $conn->error;


                            } else {


                                $stmt->bind_param(
                                    "sssssssssss",
                                    $nome,
                                    $email,
                                    $telefone,
                                    $endereco,
                                    $especialidade,
                                    $motivo,
                                    $problema,
                                    $objetivo,
                                    $observacoes,
                                    $data,
                                    $hora
                                );


                                if ($stmt->execute()) {


                                    $sucesso =
                                        "Consulta agendada com sucesso!";


                                    /*
                                    | Limpa formulário
                                    */


                                    $nome = "";
                                    $email = "";
                                    $telefone = "";
                                    $endereco = "";


                                    $especialidade = "";
                                    $motivo = "";
                                    $problema = "";
                                    $objetivo = "";
                                    $observacoes = "";


                                    $data = "";
                                    $hora = "";


                                } else {


                                    $erro =
                                        "Erro ao salvar a consulta: "
                                        . $stmt->error;
                                }


                                $stmt->close();
                            }
                        }
                    }
                }
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| BUSCA HORÁRIOS OCUPADOS
|--------------------------------------------------------------------------
*/


$horariosOcupados = [];


$sql = "
    SELECT data_consulta, hora_consulta
    FROM consultas
    WHERE status = 'agendada'
";


$resultado = $conn->query($sql);


if ($resultado) {


    while ($row = $resultado->fetch_assoc()) {


        $dataBanco = $row["data_consulta"];
        $horaBanco = substr($row["hora_consulta"], 0, 5);


        if (!isset($horariosOcupados[$dataBanco])) {
            $horariosOcupados[$dataBanco] = [];
        }


        $horariosOcupados[$dataBanco][] = $horaBanco;
    }
}


?>


<!DOCTYPE html>


<html lang="pt-BR">


<head>


    <meta charset="UTF-8">


    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <title>Agendar Consulta - HealthSystem</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <style>


        body {
            background: #f5f7fb;
        }


        .card {
            border: none;
            border-radius: 18px;
        }


        .card-header {
            background: #0d6efd;
            color: white;
            border-radius: 18px 18px 0 0 !important;
        }


        .form-control,
        .form-select {
            border-radius: 10px;
        }


        .horario {
            display: block;
            cursor: pointer;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            background: white;
        }


        .horario:hover {
            border-color: #0d6efd;
            background: #f0f6ff;
        }


        .horario input {
            display: none;
        }


        .horario input:checked + span {
            background: #0d6efd;
            color: white;
            display: block;
            padding: 6px;
            border-radius: 7px;
        }


    </style>


</head>


<body>


<nav class="navbar navbar-dark bg-primary">


    <div class="container">


        <span class="navbar-brand">
            HealthSystem
        </span>


    </div>


</nav>


<div class="container py-5">


    <div class="row justify-content-center">


        <div class="col-lg-10">


            <div class="card shadow">


                <div class="card-header text-center py-4">


                    <h2>
                        Agendar Consulta
                    </h2>


                    <p class="mb-0">
                        Preencha os dados abaixo
                    </p>


                </div>


                <div class="card-body p-4">


                    <?php if ($erro !== "") { ?>


                        <div class="alert alert-danger">


                            <?= htmlspecialchars(
                                $erro,
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>


                        </div>


                    <?php } ?>




                    <?php if ($sucesso !== "") { ?>


                        <div class="alert alert-success">


                            <?= htmlspecialchars(
                                $sucesso,
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>


                        </div>


                    <?php } ?>




                    <form method="POST">


                        <h4 class="mb-3">
                            Dados do paciente
                        </h4>


                        <div class="row">


                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    Nome completo *
                                </label>


                                <input
                                    type="text"
                                    name="nome"
                                    class="form-control"
                                    value="<?= htmlspecialchars(
                                        $nome,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>"
                                    required
                                >


                            </div>




                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    E-mail *
                                </label>


                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="<?= htmlspecialchars(
                                        $email,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>"
                                    required
                                >


                            </div>




                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    Telefone *
                                </label>


                                <input
                                    type="text"
                                    name="telefone"
                                    class="form-control"
                                    value="<?= htmlspecialchars(
                                        $telefone,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>"
                                    required
                                >


                            </div>




                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    Endereço *
                                </label>


                                <input
                                    type="text"
                                    name="endereco"
                                    class="form-control"
                                    value="<?= htmlspecialchars(
                                        $endereco,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>"
                                    required
                                >


                            </div>


                        </div>




                        <hr class="my-4">




                        <h4 class="mb-3">
                            Dados da consulta
                        </h4>




                        <div class="row">


                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    Especialidade *
                                </label>


                                <select
                                    name="especialidade"
                                    class="form-select"
                                    required
                                >


                                    <option value="">
                                        Selecione
                                    </option>


                                    <option value="Clínica Geral">
                                        Clínica Geral
                                    </option>


                                    <option value="Cardiologia">
                                        Cardiologia
                                    </option>


                                    <option value="Pediatria">
                                        Pediatria
                                    </option>


                                    <option value="Ortopedia">
                                        Ortopedia
                                    </option>


                                    <option value="Dermatologia">
                                        Dermatologia
                                    </option>


                                    <option value="Odontologia">
                                        Odontologia
                                    </option>


                                    <option value="Psicologia">
                                        Psicologia
                                    </option>


                                    <option value="Outra">
                                        Outra
                                    </option>


                                </select>


                            </div>




                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    Motivo da consulta *
                                </label>


                                <input
                                    type="text"
                                    name="motivo"
                                    class="form-control"
                                    required
                                >


                            </div>




                            <div class="col-12 mb-3">


                                <label class="form-label">
                                    Problema ou sintomas *
                                </label>


                                <textarea
                                    name="problema"
                                    class="form-control"
                                    rows="4"
                                    required
                                ></textarea>


                            </div>




                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    Objetivo *
                                </label>


                                <select
                                    name="objetivo"
                                    class="form-select"
                                    required
                                >


                                    <option value="">
                                        Selecione
                                    </option>


                                    <option value="Consulta / avaliação">
                                        Consulta / avaliação
                                    </option>


                                    <option value="Retorno">
                                        Retorno
                                    </option>


                                    <option value="Acompanhamento">
                                        Acompanhamento
                                    </option>


                                    <option value="Solicitação de exames">
                                        Solicitação de exames
                                    </option>


                                    <option value="Avaliação de exames">
                                        Avaliação de exames
                                    </option>


                                    <option value="Outro">
                                        Outro
                                    </option>


                                </select>


                            </div>




                            <div class="col-md-6 mb-3">


                                <label class="form-label">
                                    Observações
                                </label>


                                <textarea
                                    name="observacoes"
                                    class="form-control"
                                    rows="2"
                                ></textarea>


                            </div>


                        </div>




                        <hr class="my-4">




                        <h4 class="mb-3">
                            Data e horário
                        </h4>




                        <div class="mb-4">


                            <label class="form-label">
                                Data da consulta *
                            </label>


                            <input
                                type="date"
                                name="data"
                                id="data"
                                class="form-control"
                                min="<?= date("Y-m-d") ?>"
                                required
                            >


                        </div>




                        <label class="form-label">
                            Horário *
                        </label>




                        <div
                            id="horarios"
                            class="row g-2 mb-4"
                        >


                            <div class="col-12">


                                <div class="alert alert-info">


                                    Escolha uma data para
                                    visualizar os horários.


                                </div>


                            </div>


                        </div>




                        <div class="d-flex justify-content-between align-items-center">

                            <a
                         href="home_pacientes.php"
                             class="btn btn-secondary btn-lg px-4"
                          >
                          Voltar para Home
                         </a>

                            <button
                            type="submit"
                            class="btn btn-primary btn-lg px-5"
                           >
                            Agendar consulta
                           </button>

                           </div>



                    </form>


                </div>


            </div>


        </div>


    </div>


</div>




<script>


const horarios = <?= json_encode(
    $horariosDisponiveis,
    JSON_UNESCAPED_UNICODE
) ?>;


const horariosOcupados = <?= json_encode(
    $horariosOcupados,
    JSON_UNESCAPED_UNICODE
) ?>;


const campoData =
    document.getElementById("data");


const areaHorarios =
    document.getElementById("horarios");




campoData.addEventListener("change", function () {


    const data = campoData.value;


    areaHorarios.innerHTML = "";


    if (!data) {
        return;
    }


    const ocupados =
        horariosOcupados[data] || [];


    horarios.forEach(function (hora) {


        const coluna =
            document.createElement("div");


        coluna.className = "col-6 col-md-3";


        if (ocupados.includes(hora)) {


            coluna.innerHTML = `
                <div class="horario text-danger">
                    <strong>${hora}</strong>
                    <br>
                    <small>Ocupado</small>
                </div>
            `;


        } else {


            coluna.innerHTML = `
                <label class="horario">


                    <input
                        type="radio"
                        name="hora"
                        value="${hora}"
                        required
                    >


                    <span>
                        ${hora}
                    </span>


                </label>
            `;


        }


        areaHorarios.appendChild(coluna);


    });


});


</script>


</body>


</html>


