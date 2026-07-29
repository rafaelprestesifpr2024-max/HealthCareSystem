<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Classificação de Risco</title>

    <link href="css/styles.css" rel="stylesheet">

</head>


<body class="bg-dark">


    <div class="container mt-5">


        <div class="card shadow-lg border-0 rounded-lg">


            <div class="card-header text-center">

                <h3>
                    Classificação de Risco da Triagem
                </h3>

                <p class="text-muted mb-0">
                    Entenda os níveis de prioridade no atendimento
                </p>

            </div>



            <div class="card-body">


                <div class="row">


                    <!-- VERMELHO -->

                    <div class="col-md-6 mb-4">

                        <div class="card border-danger h-100">


                            <div class="card-header bg-danger text-white">

                                <h4>
                                    🔴 Vermelho - Emergência
                                </h4>

                            </div>


                            <div class="card-body">

                                <p>
                                    Atendimento imediato.
                                </p>

                                <p>
                                    Paciente apresenta risco de vida ou necessidade de intervenção urgente.
                                </p>


                                <strong>Exemplos:</strong>

                                <ul>
                                    <li>Parada cardiorrespiratória</li>
                                    <li>Inconsciência</li>
                                    <li>Grande dificuldade respiratória</li>
                                    <li>Sangramento intenso</li>
                                </ul>

                            </div>


                        </div>

                    </div>





                    <!-- LARANJA -->


                    <div class="col-md-6 mb-4">


                        <div class="card border-warning h-100">


                            <div class="card-header bg-warning text-dark">

                                <h4>
                                    🟠 Laranja - Muito Urgente
                                </h4>

                            </div>


                            <div class="card-body">

                                <p>
                                    Atendimento prioritário em curto tempo.
                                </p>

                                <p>
                                    Paciente com situação potencialmente grave.
                                </p>


                                <strong>Exemplos:</strong>

                                <ul>
                                    <li>Dor intensa</li>
                                    <li>Alteração importante dos sinais vitais</li>
                                    <li>Falta de ar moderada</li>
                                    <li>Alteração neurológica</li>
                                </ul>

                            </div>


                        </div>


                    </div>







                    <!-- AMARELO -->


                    <div class="col-md-6 mb-4">


                        <div class="card border-warning h-100">


                            <div class="card-header bg-warning text-dark">


                                <h4>
                                    🟡 Amarelo - Urgente
                                </h4>


                            </div>



                            <div class="card-body">


                                <p>
                                    Necessita avaliação médica, mas sem risco imediato.
                                </p>



                                <strong>Exemplos:</strong>


                                <ul>

                                    <li>Dor moderada</li>
                                    <li>Febre persistente</li>
                                    <li>Vômitos frequentes</li>
                                    <li>Sintomas que precisam de investigação</li>

                                </ul>


                            </div>


                        </div>


                    </div>







                    <!-- VERDE -->


                    <div class="col-md-6 mb-4">


                        <div class="card border-success h-100">


                            <div class="card-header bg-success text-white">


                                <h4>
                                    🟢 Verde - Pouco Urgente
                                </h4>


                            </div>



                            <div class="card-body">


                                <p>
                                    Caso estável, podendo aguardar atendimento.
                                </p>


                                <strong>Exemplos:</strong>


                                <ul>

                                    <li>Sintomas leves</li>
                                    <li>Queixas sem sinais de gravidade</li>
                                    <li>Acompanhamentos simples</li>

                                </ul>


                            </div>


                        </div>


                    </div>




                </div>


            </div>





            <div class="card-footer text-center">


                <a href="triagem.php" class="btn btn-dark">

                    Voltar para Triagem

                </a>


            </div>



        </div>


    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>