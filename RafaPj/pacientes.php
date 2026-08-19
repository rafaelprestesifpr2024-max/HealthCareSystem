<?php

include "conexao.php";


/*
|--------------------------------------------------------------------------
| BUSCA PACIENTES
|--------------------------------------------------------------------------
| Ordem de prioridade:
| Vermelho -> Laranja -> Amarelo -> Verde -> Azul
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM pacientes
    WHERE exibir = 1
    ORDER BY
        CASE risco
            WHEN 'Vermelho' THEN 1
            WHEN 'Laranja' THEN 2
            WHEN 'Amarelo' THEN 3
            WHEN 'Verde' THEN 4
            WHEN 'Azul' THEN 5
            ELSE 6
        END,
        id DESC
";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Pacientes - Sistema de Triagem</title>

    <link
        href="css/styles.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f4f6f9;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            padding: 18px;
        }

        .table {
            vertical-align: middle;
        }

        .badge {
            padding: 10px 15px;
            font-size: 14px;
        }

        .titulo {
            font-weight: 700;
        }

        .info-card {
            border-radius: 15px;
        }

    </style>

</head>


<body class="sb-nav-fixed">


    <!-- MENU SUPERIOR -->

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">


        <!-- LOGO / NOME -->

        <a
            class="navbar-brand ps-3"
            href="home.php"
        >

            <i class="fas fa-hospital"></i>

            RAFAPJ

        </a>



        <!-- BOTÃO VOLTAR PARA HOME -->

        <div class="ms-auto me-3">

            <a
                href="home.php"
                class="btn btn-light btn-sm"
            >

                <i class="fas fa-home"></i>

                Voltar para a Home

            </a>

        </div>

    </nav>



    <div id="layoutSidenav">


        <div id="layoutSidenav_content">


            <main>


                <div class="container-fluid px-4">


                    <!-- MENSAGEM DE PACIENTE OCULTADO -->

                    <?php if (isset($_GET['ocultado'])): ?>

                        <div
                            class="alert alert-success alert-dismissible fade show mt-3"
                            role="alert"
                        >

                            <i class="fas fa-check-circle"></i>

                            <strong>
                                Paciente removido da apresentação.
                            </strong>

                            <br>

                            O cadastro continua salvo no sistema.

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                            ></button>

                        </div>

                    <?php endif; ?>



                    <!-- MENSAGEM DE ERRO -->

                    <?php if (isset($_GET['erro'])): ?>

                        <div
                            class="alert alert-danger alert-dismissible fade show mt-3"
                            role="alert"
                        >

                            <i class="fas fa-exclamation-circle"></i>

                            Não foi possível remover o paciente da apresentação.

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                            ></button>

                        </div>

                    <?php endif; ?>



                    <!-- TÍTULO -->

                    <div class="mt-4 mb-4">

                        <h1 class="titulo">

                            <i class="fas fa-user-injured text-danger"></i>

                            Pacientes

                        </h1>

                        <p class="text-muted">

                            Lista de pacientes cadastrados através da triagem

                        </p>

                    </div>



                    <!-- CARD PRINCIPAL -->

                    <div class="card shadow mb-4">


                        <!-- CABEÇALHO -->

                        <div class="card-header bg-dark text-white">

                            <h5 class="mb-0">

                                <i class="fas fa-users"></i>

                                Pacientes registrados

                            </h5>

                        </div>



                        <!-- CONTEÚDO -->

                        <div class="card-body">


                            <?php if ($resultado && $resultado->num_rows > 0): ?>


                                <div class="table-responsive">


                                    <table class="table table-hover table-bordered">


                                        <!-- CABEÇALHO DA TABELA -->

                                        <thead class="table-dark">

                                            <tr>

                                                <th>
                                                    Nome
                                                </th>

                                                <th>
                                                    Nascimento
                                                </th>

                                                <th>
                                                    Data
                                                </th>

                                                <th>
                                                    Queixa principal
                                                </th>

                                                <th>
                                                    Sinais vitais
                                                </th>

                                                <th>
                                                    Risco
                                                </th>

                                                <th>
                                                    Detalhes
                                                </th>

                                            </tr>

                                        </thead>



                                        <!-- LISTA DE PACIENTES -->

                                        <tbody>


                                            <?php while ($p = $resultado->fetch_assoc()): ?>


                                                <tr>


                                                    <!-- NOME -->

                                                    <td>

                                                        <strong>

                                                            <?= htmlspecialchars(
                                                                $p['nome'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?>

                                                        </strong>

                                                    </td>



                                                    <!-- NASCIMENTO -->

                                                    <td>

                                                        <?= htmlspecialchars(
                                                            $p['data_nascimento'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>

                                                    </td>



                                                    <!-- DATA DA TRIAGEM -->

                                                    <td>

                                                        <?= htmlspecialchars(
                                                            $p['data_triagem'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>

                                                        <br>

                                                        <small class="text-muted">

                                                            <?= htmlspecialchars(
                                                                $p['hora_triagem'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?>

                                                        </small>

                                                    </td>



                                                    <!-- QUEIXA -->

                                                    <td>

                                                        <?= htmlspecialchars(
                                                            $p['queixa_principal'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>

                                                    </td>



                                                    <!-- SINAIS VITAIS -->

                                                    <td>

                                                        <i class="fas fa-heartbeat text-danger"></i>

                                                        <?= htmlspecialchars(
                                                            $p['pressao'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>

                                                        <br>


                                                        🌡️

                                                        <?= htmlspecialchars(
                                                            $p['temperatura'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>

                                                        <br>


                                                        ❤️

                                                        <?= htmlspecialchars(
                                                            $p['frequencia'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>

                                                        bpm

                                                        <br>


                                                        🫁

                                                        <?= htmlspecialchars(
                                                            $p['saturacao'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>

                                                        %

                                                    </td>



                                                    <!-- RISCO -->

                                                    <td>


                                                        <?php

                                                        switch ($p['risco']) {

                                                            case "Vermelho":

                                                                $cor = "danger";

                                                                break;


                                                            case "Laranja":

                                                                $cor = "warning";

                                                                break;


                                                            case "Amarelo":

                                                                $cor = "warning";

                                                                break;


                                                            case "Verde":

                                                                $cor = "success";

                                                                break;


                                                            case "Azul":

                                                                $cor = "primary";

                                                                break;


                                                            default:

                                                                $cor = "secondary";

                                                        }

                                                        ?>


                                                        <span
                                                            class="badge bg-<?= $cor ?>"
                                                        >

                                                            <?= htmlspecialchars(
                                                                $p['risco'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?>

                                                        </span>

                                                    </td>



                                                    <!-- DETALHES -->

                                                    <td>


                                                        <div class="d-flex gap-2 flex-wrap">


                                                            <!-- VER FICHA -->

                                                            <button
                                                                class="btn btn-primary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#paciente<?= (int)$p['id'] ?>"
                                                            >

                                                                <i class="fas fa-eye"></i>

                                                                Ver ficha

                                                            </button>



                                                            <!-- REMOVER DA APRESENTAÇÃO -->

                                                            <form
                                                                action="ocultar_paciente.php"
                                                                method="POST"
                                                                onsubmit="return confirm('Deseja remover este paciente da apresentação? O cadastro continuará salvo no sistema.');"
                                                            >

                                                                <input
                                                                    type="hidden"
                                                                    name="id"
                                                                    value="<?= (int)$p['id'] ?>"
                                                                >


                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger btn-sm"
                                                                >

                                                                    <i class="fas fa-eye-slash"></i>

                                                                    Remover da apresentação

                                                                </button>

                                                            </form>


                                                        </div>

                                                    </td>


                                                </tr>



                                                <!-- MODAL DA FICHA -->

                                                <div
                                                    class="modal fade"
                                                    id="paciente<?= (int)$p['id'] ?>"
                                                    tabindex="-1"
                                                    aria-hidden="true"
                                                >

                                                    <div class="modal-dialog modal-lg">


                                                        <div class="modal-content">


                                                            <!-- CABEÇALHO DO MODAL -->

                                                            <div class="modal-header bg-dark text-white">


                                                                <h5 class="modal-title">

                                                                    <i class="fas fa-file-medical"></i>

                                                                    Ficha do paciente

                                                                </h5>


                                                                <button
                                                                    type="button"
                                                                    class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal"
                                                                ></button>


                                                            </div>



                                                            <!-- CORPO DO MODAL -->

                                                            <div class="modal-body">


                                                                <h5>

                                                                    <?= htmlspecialchars(
                                                                        $p['nome'],
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>

                                                                </h5>


                                                                <hr>


                                                                <p>

                                                                    <b>
                                                                        Histórico:
                                                                    </b>

                                                                    <br>

                                                                    <?= htmlspecialchars(
                                                                        $p['historico'],
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>

                                                                </p>


                                                                <p>

                                                                    <b>
                                                                        Sintomas:
                                                                    </b>

                                                                    <br>

                                                                    <?= htmlspecialchars(
                                                                        $p['sintomas'],
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>

                                                                </p>


                                                                <p>

                                                                    <b>
                                                                        Medicamentos:
                                                                    </b>

                                                                    <?= htmlspecialchars(
                                                                        $p['medicamentos'],
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>

                                                                </p>


                                                                <p>

                                                                    <b>
                                                                        Alergias:
                                                                    </b>

                                                                    <?= htmlspecialchars(
                                                                        $p['alergias'],
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>

                                                                </p>


                                                                <p>

                                                                    <b>
                                                                        Dor:
                                                                    </b>

                                                                    <?= htmlspecialchars(
                                                                        $p['dor'],
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>

                                                                    /10

                                                                </p>


                                                            </div>


                                                        </div>

                                                    </div>

                                                </div>


                                            <?php endwhile; ?>


                                        </tbody>

                                    </table>

                                </div>


                            <?php else: ?>


                                <!-- NENHUM PACIENTE -->

                                <div class="alert alert-info">

                                    <i class="fas fa-info-circle"></i>

                                    Nenhum paciente disponível para apresentação.

                                </div>


                            <?php endif; ?>


                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>



    <!-- BOOTSTRAP JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


</body>

</html>
