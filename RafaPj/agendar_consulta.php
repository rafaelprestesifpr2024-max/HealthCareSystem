<?php

session_start();

require_once "conexao.php";

/* =========================================================
   VERIFICA SE O PACIENTE ESTÁ LOGADO
   ========================================================= */

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$paciente_id = $_SESSION["usuario_id"];
$nome = $_SESSION["usuario_nome"];

$erro = "";
$sucesso = "";


/* =========================================================
   PROCESSAMENTO DO AGENDAMENTO
   ========================================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $especialidade = trim($_POST["especialidade"] ?? "");
    $motivo = trim($_POST["motivo"] ?? "");
    $problema = trim($_POST["problema"] ?? "");
    $objetivo = trim($_POST["objetivo"] ?? "");
    $observacoes = trim($_POST["observacoes"] ?? "");

    $telefone = trim($_POST["telefone"] ?? "");
    $endereco = trim($_POST["endereco"] ?? "");

    $data_consulta = $_POST["data_consulta"] ?? "";
    $hora_consulta = $_POST["hora_consulta"] ?? "";


    /* =====================================================
       VERIFICA CAMPOS OBRIGATÓRIOS
       ===================================================== */

    if (
        empty($especialidade) ||
        empty($motivo) ||
        empty($problema) ||
        empty($objetivo) ||
        empty($telefone) ||
        empty($endereco) ||
        empty($data_consulta) ||
        empty($hora_consulta)
    ) {

        $erro = "Preencha todos os campos obrigatórios.";

    } else {

        /* =================================================
           IMPede DATA PASSADA
           ================================================= */

        if ($data_consulta < date("Y-m-d")) {

            $erro = "Não é possível agendar uma consulta para uma data passada.";

        } else {

            /* =================================================
               LIMITE DE CONSULTAS POR DIA
               ================================================= */

            $limiteConsultas = 10;

            $sqlQuantidade = "
                SELECT COUNT(*) AS total
                FROM consultas
                WHERE data_consulta = ?
                AND status = 'agendada'
            ";

            $stmtQuantidade = $conn->prepare($sqlQuantidade);

            if (!$stmtQuantidade) {

                $erro = "Erro ao verificar a disponibilidade do dia.";

            } else {

                $stmtQuantidade->bind_param(
                    "s",
                    $data_consulta
                );

                $stmtQuantidade->execute();

                $resultadoQuantidade = $stmtQuantidade->get_result();
                $dadosQuantidade = $resultadoQuantidade->fetch_assoc();

                $totalConsultas = (int) $dadosQuantidade["total"];

                $stmtQuantidade->close();


                /* =================================================
                   VERIFICA SE O DIA ESTÁ LOTADO
                   ================================================= */

                if ($totalConsultas >= $limiteConsultas) {

                    $erro = "Este dia já está lotado. Escolha outra data.";

                } else {

                    /* =================================================
                       VERIFICA SE O HORÁRIO JÁ ESTÁ OCUPADO
                       ================================================= */

                    $sqlVerifica = "
                        SELECT id
                        FROM consultas
                        WHERE data_consulta = ?
                        AND hora_consulta = ?
                        AND status = 'agendada'
                    ";

                    $stmtVerifica = $conn->prepare($sqlVerifica);

                    if (!$stmtVerifica) {

                        $erro = "Erro ao consultar disponibilidade.";

                    } else {

                        $stmtVerifica->bind_param(
                            "ss",
                            $data_consulta,
                            $hora_consulta
                        );

                        $stmtVerifica->execute();

                        $resultado = $stmtVerifica->get_result();


                        if ($resultado->num_rows > 0) {

                            $erro = "Esse horário já está ocupado. Escolha outro horário.";

                        } else {

                            /* =================================================
                               REALIZA O AGENDAMENTO
                               ================================================= */

                            $sql = "
                                INSERT INTO consultas
                                (
                                    paciente_id,
                                    especialidade,
                                    motivo,
                                    problema,
                                    objetivo,
                                    observacoes,
                                    telefone,
                                    endereco,
                                    data_consulta,
                                    hora_consulta,
                                    status
                                )
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'agendada')
                            ";

                            $stmt = $conn->prepare($sql);

                            if (!$stmt) {

                                $erro = "Erro ao preparar o agendamento.";

                            } else {

                                $stmt->bind_param(
                                    "isssssssss",
                                    $paciente_id,
                                    $especialidade,
                                    $motivo,
                                    $problema,
                                    $objetivo,
                                    $observacoes,
                                    $telefone,
                                    $endereco,
                                    $data_consulta,
                                    $hora_consulta
                                );


                                if ($stmt->execute()) {

                                    $sucesso = "Consulta agendada com sucesso!";

                                } else {

                                    $erro = "Erro ao realizar o agendamento: " . $stmt->error;
                                }

                                $stmt->close();
                            }
                        }

                        $stmtVerifica->close();
                    }
                }
            }
        }
    }
}


/* =========================================================
   CONSULTA DOS DIAS OCUPADOS
   ========================================================= */

$diasOcupados = [];

$sqlDias = "
    SELECT data_consulta, COUNT(*) AS total
    FROM consultas
    WHERE status = 'agendada'
    GROUP BY data_consulta
";

$resultadoDias = $conn->query($sqlDias);

if ($resultadoDias) {

    while ($dia = $resultadoDias->fetch_assoc()) {

        $diasOcupados[$dia["data_consulta"]] =
            (int) $dia["total"];
    }
}


/* =========================================================
   LIMITE DE CONSULTAS POR DIA
   ========================================================= */

$limiteConsultas = 10;

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Agendar Consulta - HealthSystem</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- FontAwesome -->

    <script
        src="https://use.fontawesome.com/releases/v6.3.0/js/all.js">
    </script>


    <style>

        body {

            background: #f5f7fb;

            min-height: 100vh;
        }


        /* Navbar */

        .navbar {

            background: #0d6efd !important;
        }


        /* Cards */

        .card {

            border: none;

            border-radius: 18px;
        }


        .card-header {

            background: #0d6efd;

            color: white;

            border-radius: 18px 18px 0 0 !important;
        }


        /* Inputs */

        .form-control,
        .form-select {

            border-radius: 10px;
        }


        .form-control:focus,
        .form-select:focus {

            border-color: #0d6efd;

            box-shadow:
                0 0 0 .20rem
                rgba(13, 110, 253, .20);
        }


        /* Botão principal */

        .btn-primary {

            background: #0d6efd;

            border: none;

            border-radius: 10px;
        }


        .btn-primary:hover {

            background: #0b5ed7;
        }


        /* Título */

        .titulo {

            font-weight: 600;
        }


        /* Ícone */

        .icon-header {

            width: 55px;

            height: 55px;

            border-radius: 50%;

            background: white;

            color: #0d6efd;

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto 10px auto;
        }


        /* Horários */

        .horario {

            cursor: pointer;

            border: 2px solid #dee2e6;

            border-radius: 10px;

            padding: 10px;

            text-align: center;

            transition: .2s;

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

            border-radius: 7px;

            padding: 5px;
        }


        /* Informações */

        .info-box {

            background: #f0f6ff;

            border-left: 4px solid #0d6efd;

            border-radius: 8px;

            padding: 15px;
        }


        /* Campo de contato */

        .contato-box {

            background: #f8f9fa;

            border-radius: 12px;

            padding: 15px;

            border: 1px solid #e9ecef;
        }

    </style>

</head>


<body>


<!-- =========================================================
     NAVBAR
     ========================================================= -->

<nav class="navbar navbar-expand navbar-dark">

    <a
        class="navbar-brand ps-4"
        href="home_pacientes.php"
    >

        <i class="fas fa-heart-pulse"></i>

        HealthSystem

    </a>


    <div class="ms-auto me-4">

        <span class="text-white">

            Olá,
            <?= htmlspecialchars($nome) ?>

        </span>

    </div>

</nav>



<!-- =========================================================
     CONTEÚDO
     ========================================================= -->

<div class="container py-4">


    <!-- TÍTULO -->

    <div class="mb-4">

        <h1 class="titulo">

            <i class="fas fa-calendar-plus text-primary"></i>

            Agendar Consulta

        </h1>

        <p class="text-muted">

            Preencha as informações abaixo para solicitar
            uma consulta.

        </p>

    </div>



    <!-- MENSAGENS -->

    <?php if (!empty($erro)) { ?>

        <div class="alert alert-danger">

            <i class="fas fa-circle-exclamation"></i>

            <?= htmlspecialchars($erro) ?>

        </div>

    <?php } ?>


    <?php if (!empty($sucesso)) { ?>

        <div class="alert alert-success">

            <i class="fas fa-circle-check"></i>

            <?= htmlspecialchars($sucesso) ?>

        </div>

    <?php } ?>



    <form method="POST">


        <div class="row g-4">


            <!-- =================================================
                 INFORMAÇÕES DA CONSULTA
                 ================================================= -->

            <div class="col-lg-7">

                <div class="card shadow">


                    <div class="card-header text-center py-4">

                        <div class="icon-header">

                            <i class="fas fa-stethoscope fa-lg"></i>

                        </div>

                        <h4 class="mb-0">

                            Informações da Consulta

                        </h4>

                    </div>


                    <div class="card-body p-4">


                        <!-- Especialidade -->

                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                Especialidade

                                <span class="text-danger">*</span>

                            </label>


                            <select
                                name="especialidade"
                                class="form-select"
                                required
                            >

                                <option value="">

                                    Selecione uma especialidade

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



                        <!-- Motivo -->

                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                Motivo da consulta

                                <span class="text-danger">*</span>

                            </label>


                            <input
                                type="text"
                                name="motivo"
                                class="form-control"
                                placeholder="Ex.: Dor no peito, consulta de rotina..."
                                required
                            >

                        </div>



                        <!-- Problema -->

                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                Problema ou sintomas

                                <span class="text-danger">*</span>

                            </label>


                            <textarea
                                name="problema"
                                class="form-control"
                                rows="4"
                                placeholder="Descreva o problema, sintomas ou o que está sentindo..."
                                required
                            ></textarea>

                        </div>



                        <!-- Objetivo -->

                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                O que pretende fazer?

                                <span class="text-danger">*</span>

                            </label>


                            <select
                                name="objetivo"
                                class="form-select"
                                required
                            >

                                <option value="">

                                    Selecione uma opção

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



                        <!-- Observações -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Observações

                                <span class="text-muted">

                                    (opcional)

                                </span>

                            </label>


                            <textarea
                                name="observacoes"
                                class="form-control"
                                rows="3"
                                placeholder="Alguma informação adicional?"
                            ></textarea>

                        </div>



                        <!-- =================================================
                             CONTATO
                             ================================================= -->

                        <div class="contato-box">

                            <h6 class="fw-bold mb-3">

                                <i class="fas fa-address-book text-primary"></i>

                                Dados para contato

                            </h6>

                            <p class="small text-muted">

                                Informe seus dados de contato para que
                                a unidade possa entrar em contato
                                sobre esta consulta.

                            </p>


                            <!-- Telefone -->

                            <div class="mb-3">

                                <label class="form-label fw-bold">

                                    Telefone

                                    <span class="text-danger">*</span>

                                </label>


                                <input
                                    type="tel"
                                    name="telefone"
                                    class="form-control"
                                    placeholder="Ex.: (42) 99999-9999"
                                    required
                                >

                            </div>


                            <!-- Endereço -->

                            <div>

                                <label class="form-label fw-bold">

                                    Endereço

                                    <span class="text-danger">*</span>

                                </label>


                                <input
                                    type="text"
                                    name="endereco"
                                    class="form-control"
                                    placeholder="Rua, número, bairro..."
                                    required
                                >

                            </div>

                        </div>


                    </div>

                </div>

            </div>



            <!-- =================================================
                 DATA E HORÁRIO
                 ================================================= -->

            <div class="col-lg-5">

                <div class="card shadow">


                    <div class="card-header text-center py-4">

                        <div class="icon-header">

                            <i class="fas fa-calendar-days fa-lg"></i>

                        </div>

                        <h4 class="mb-0">

                            Data e Horário

                        </h4>

                    </div>


                    <div class="card-body p-4">


                        <!-- Data -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Escolha a data

                                <span class="text-danger">*</span>

                            </label>


                            <input
                                type="date"
                                name="data_consulta"
                                id="data_consulta"
                                class="form-control"
                                min="<?= date('Y-m-d') ?>"
                                required
                            >

                        </div>



                        <!-- Informação -->

                        <div class="info-box mb-4">

                            <i class="fas fa-circle-info text-primary"></i>

                            <strong>Disponibilidade</strong>

                            <p class="mb-0 mt-1 small">

                                Escolha uma data para visualizar
                                os horários disponíveis.

                            </p>

                        </div>



                        <!-- Horários -->

                        <label class="form-label fw-bold">

                            Horário

                            <span class="text-danger">*</span>

                        </label>


                        <div
                            id="horarios"
                            class="row g-2"
                        >

                            <div class="col-12">

                                <p class="text-muted text-center">

                                    Selecione uma data primeiro.

                                </p>

                            </div>

                        </div>


                    </div>

                </div>



                <!-- =================================================
                     LEGENDA
                     ================================================= -->

                <div class="card shadow mt-4">

                    <div class="card-body">

                        <h6 class="fw-bold">

                            <i class="fas fa-circle-info text-primary"></i>

                            Informações

                        </h6>

                        <p class="small text-muted mb-2">

                            Os horários já ocupados não poderão
                            ser selecionados.

                        </p>

                        <p class="small text-muted mb-0">

                            O limite é de

                            <strong><?= $limiteConsultas ?></strong>

                            consultas por dia.

                        </p>

                    </div>

                </div>

            </div>


        </div>



        <!-- =================================================
             BOTÕES
             ================================================= -->

        <div class="d-flex justify-content-between mt-4">


            <a
                href="home_pacientes.php"
                class="btn btn-outline-secondary px-4"
            >

                <i class="fas fa-arrow-left"></i>

                Voltar

            </a>


            <button
                type="submit"
                class="btn btn-primary px-5"
            >

                <i class="fas fa-calendar-check"></i>

                Confirmar Agendamento

            </button>

        </div>


    </form>

</div>



<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->

<script>

    /* =========================================================
       HORÁRIOS DISPONÍVEIS
       ========================================================= */

    const horarios = [

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


    /* =========================================================
       DIAS OCUPADOS
       ========================================================= */

    const diasOcupados =
        <?= json_encode($diasOcupados) ?>;


    const limiteConsultas =
        <?= $limiteConsultas ?>;


    const campoData =
        document.getElementById("data_consulta");


    const areaHorarios =
        document.getElementById("horarios");


    /* =========================================================
       QUANDO O PACIENTE ESCOLHER UMA DATA
       ========================================================= */

    campoData.addEventListener("change", function () {

        const data = this.value;


        areaHorarios.innerHTML = "";


        if (!data) {

            return;

        }


        /* =====================================================
           VERIFICA SE O DIA ESTÁ LOTADO
           ===================================================== */

        if (
            diasOcupados[data] !== undefined &&
            diasOcupados[data] >= limiteConsultas
        ) {

            areaHorarios.innerHTML = `

                <div class="col-12">

                    <div class="alert alert-danger">

                        <i class="fas fa-calendar-xmark"></i>

                        <strong>Este dia está lotado.</strong>

                        <br>

                        Existem
                        ${diasOcupados[data]}
                        consultas agendadas.

                        <br>

                        Escolha outra data.

                    </div>

                </div>

            `;

            return;

        }


        /* =====================================================
           MOSTRA OS HORÁRIOS
           ===================================================== */

        horarios.forEach(function (hora) {

            const coluna =
                document.createElement("div");


            coluna.className = "col-6";


            coluna.innerHTML = `

                <label class="horario w-100">

                    <input
                        type="radio"
                        name="hora_consulta"
                        value="${hora}"
                        required
                    >

                    <span>

                        ${hora}

                    </span>

                </label>

            `;


            areaHorarios.appendChild(coluna);

        });

    });

</script>



<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>