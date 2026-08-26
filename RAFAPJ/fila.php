<?php 
include "conexao.php"; 

/*
|--------------------------------------------------------------------------
| ORDEM DE PRIORIDADE
|--------------------------------------------------------------------------
| Vermelho = maior urgência
| Laranja  = segunda maior urgência
| Amarelo  = terceira
| Verde    = quarta
| Azul     = menor urgência
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
        END ASC,
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

    <title>
        Pacientes - Sistema de Triagem
    </title> 

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
                href="home_pacientes.php" 
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
                                                    Data
                                                </th> 

                                                <th>
                                                    Urgência
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


                                                    <!-- RISCO / URGÊNCIA --> 

                                                    <td> 

                                                        <?php 

                                                        switch ($p['risco']) { 

                                                            case "Vermelho": 
                                                                $cor = "danger"; 
                                                                $icone = "fa-triangle-exclamation";
                                                                break; 

                                                            case "Laranja": 
                                                                $cor = "warning"; 
                                                                $icone = "fa-triangle-exclamation";
                                                                break; 

                                                            case "Amarelo": 
                                                                $cor = "warning"; 
                                                                $icone = "fa-circle-exclamation";
                                                                break; 

                                                            case "Verde": 
                                                                $cor = "success"; 
                                                                $icone = "fa-circle-check";
                                                                break; 

                                                            case "Azul": 
                                                                $cor = "primary"; 
                                                                $icone = "fa-circle-info";
                                                                break; 

                                                            default: 
                                                                $cor = "secondary"; 
                                                                $icone = "fa-circle-question";
                                                                break; 

                                                        } 

                                                        ?> 


                                                        <span class="badge bg-<?= $cor ?>"> 

                                                            <i class="fas <?= $icone ?>"></i>

                                                            <?= htmlspecialchars(
                                                                $p['risco'],
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?> 

                                                        </span> 

                                                    </td> 


                                                </tr> 


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
