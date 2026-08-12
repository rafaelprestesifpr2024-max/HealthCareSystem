<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Classificação de Risco</title>

    <link href="css/styles.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow border-0">

            <!-- Cabeçalho -->
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-1">Classificação de Risco</h2>
                <p class="mb-0">Sistema de Prioridade de Atendimento</p>
            </div>

            <!-- Corpo -->
            <div class="card-body">

                <!-- Alerta -->
                <div class="alert alert-info">
                    <strong>Atenção:</strong>
                    A classificação de risco define a prioridade do atendimento e
                    <strong>não a ordem de chegada</strong>.
                </div>

                <div class="row">

                    <!-- Vermelho -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-danger h-100">
                            <div class="card-header bg-danger text-white">
                                <h4 class="mb-0">🔴 Vermelho</h4>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-danger mb-3">Atendimento Imediato</span>
                                <p>Paciente com risco iminente de morte ou necessidade de intervenção imediata.</p>
                                <strong>Exemplos</strong>
                                <ul>
                                    <li>Parada cardiorrespiratória</li>
                                    <li>Inconsciência</li>
                                    <li>Choque</li>
                                    <li>Hemorragia intensa</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Laranja -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-warning h-100">
                            <div class="card-header text-dark" style="background:#fd7e14;">
                                <h4 class="mb-0">🟠 Laranja</h4>
                            </div>
                            <div class="card-body">
                                <span class="badge text-bg-warning mb-3">Até 10 minutos</span>
                                <p>Situação potencialmente grave que exige atendimento muito rápido.</p>
                                <strong>Exemplos</strong>
                                <ul>
                                    <li>Dor intensa</li>
                                    <li>Falta de ar moderada</li>
                                    <li>Alteração neurológica</li>
                                    <li>Alteração importante dos sinais vitais</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Amarelo -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-warning h-100">
                            <div class="card-header bg-warning">
                                <h4 class="mb-0">🟡 Amarelo</h4>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-warning text-dark mb-3">Até 60 minutos</span>
                                <p>Necessita avaliação médica, porém sem risco imediato.</p>
                                <strong>Exemplos</strong>
                                <ul>
                                    <li>Febre persistente</li>
                                    <li>Dor moderada</li>
                                    <li>Vômitos frequentes</li>
                                    <li>Suspeita de infecção</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Verde -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white">
                                <h4 class="mb-0">🟢 Verde</h4>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-success mb-3">Até 120 minutos</span>
                                <p>Paciente estável, podendo aguardar atendimento.</p>
                                <strong>Exemplos</strong>
                                <ul>
                                    <li>Sintomas leves</li>
                                    <li>Dor leve</li>
                                    <li>Pequenos ferimentos</li>
                                    <li>Mal-estar sem gravidade</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Azul -->
                    <div class="col-lg-12">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">🔵 Azul</h4>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-primary mb-3">Até 240 minutos</span>
                                <p>Casos sem urgência, que podem aguardar ou ser encaminhados para atendimento ambulatorial.</p>
                                <strong>Exemplos</strong>
                                <ul>
                                    <li>Renovação de receita</li>
                                    <li>Retorno médico</li>
                                    <li>Sintomas leves há vários dias</li>
                                    <li>Pequenas queixas sem gravidade</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Rodapé -->
            <div class="card-footer text-center">
                <a href="home_pacientes.php" class="btn btn-dark">← Voltar para o home</a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
