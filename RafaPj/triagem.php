<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>Triagem - SB Admin</title>

    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">

<div id="layoutAuthentication">

    <div id="layoutAuthentication_content">

        <main>

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-8">

                        <div class="card shadow-lg border-0 rounded-lg mt-5">

                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">
                                    Triagem
                                </h3>
                            </div>


                            <div class="card-body">

                                <form action="salvar_triagem.php" method="POST">


                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               id="inputNome"
                                               name="nome"
                                               type="text"
                                               placeholder="Nome Completo"
                                               required>

                                        <label for="inputNome">
                                            Nome Completo
                                        </label>
                                    </div>


                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               id="inputDataTriagem"
                                               name="data_triagem"
                                               type="date"
                                               required>

                                        <label for="inputDataTriagem">
                                            Data da Triagem
                                        </label>
                                    </div>


                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               id="inputQueixa"
                                               name="queixa_principal"
                                               type="text"
                                               placeholder="Queixa Principal"
                                               required>

                                        <label for="inputQueixa">
                                            Queixa Principal
                                        </label>
                                    </div>


                                    <div class="form-floating mb-3">

                                        <textarea class="form-control"
                                                  id="inputSintomas"
                                                  name="sintomas"
                                                  placeholder="Sintomas"
                                                  style="height:100px"></textarea>

                                        <label for="inputSintomas">
                                            Sintomas
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <textarea class="form-control"
                                                  id="inputHistorico"
                                                  name="historico"
                                                  placeholder="Histórico"
                                                  style="height:100px"></textarea>

                                        <label for="inputHistorico">
                                            Histórico de Doenças
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputMedicamentos"
                                               name="medicamentos"
                                               type="text"
                                               placeholder="Medicamentos">

                                        <label for="inputMedicamentos">
                                            Medicamentos em Uso
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputAlergias"
                                               name="alergias"
                                               type="text"
                                               placeholder="Alergias">

                                        <label for="inputAlergias">
                                            Alergias
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputPressao"
                                               name="pressao"
                                               type="text"
                                               placeholder="Pressão">

                                        <label for="inputPressao">
                                            Pressão Arterial
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputTemperatura"
                                               name="temperatura"
                                               type="number"
                                               step="0.1"
                                               placeholder="Temperatura">

                                        <label for="inputTemperatura">
                                            Temperatura (°C)
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputFrequenciaCardiaca"
                                               name="frequencia_cardiaca"
                                               type="number"
                                               placeholder="Frequência">

                                        <label for="inputFrequenciaCardiaca">
                                            Frequência Cardíaca (bpm)
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputSaturacao"
                                               name="saturacao"
                                               type="number"
                                               placeholder="Saturação">

                                        <label for="inputSaturacao">
                                            Saturação de Oxigênio (%)
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputDor"
                                               name="escala_dor"
                                               type="number"
                                               min="0"
                                               max="10"
                                               placeholder="Dor">

                                        <label for="inputDor">
                                            Escala de Dor (0 a 10)
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <input class="form-control"
                                               id="inputRisco"
                                               name="classificacao_risco"
                                               type="text"
                                               placeholder="Risco">

                                        <label for="inputRisco">
                                            Classificação de Risco
                                        </label>

                                    </div>


                                    <div class="form-floating mb-3">

                                        <textarea class="form-control"
                                                  id="inputConduta"
                                                  name="conduta"
                                                  placeholder="Conduta"
                                                  style="height:100px"></textarea>

                                        <label for="inputConduta">
                                            Conduta Inicial
                                        </label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control"
                                                  id="inputObservacoes"
                                                  name="observacoes"
                                                  placeholder="Observações"
                                                  style="height:120px"></textarea>
                                        <label for="inputObservacoes">
                                            Observações
                                        </label>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark">
                                            Salvar Triagem
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small">
                                    Sistema de Triagem
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>


    <div id="layoutAuthentication_footer">

        <footer class="py-4 bg-light mt-auto">

            <div class="container-fluid px-4">

                <div class="text-center small text-muted">

                    Copyright © Sistema de Triagem 2026

                </div>

            </div>

        </footer>

    </div>


</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/scripts.js"></script>

</body>
</html>