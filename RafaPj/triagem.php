<!DOCTYPE html>
<html lang="pt-BR">


<head>


    <meta charset="UTF-8">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Triagem Hospitalar</title>


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


        .form-control,
        .form-select {
            border-radius: 10px;
        }


        .titulo {
            font-weight: 700;
        }


        .btn-enviar {
            min-width: 220px;
        }


        #resultado {
            display: none;
        }


        .risco-final {
            font-size: 30px;
            font-weight: bold;
        }


        .info-ia {
            border-radius: 12px;
        }


    </style>


</head>




<body>




<div class="container py-5">




    <!-- ====================================================== -->
    <!-- TÍTULO -->
    <!-- ====================================================== -->


    <div class="text-center mb-5">


        <h1 class="titulo">


            <i class="fas fa-hospital text-danger"></i>


            Sistema de Triagem


        </h1>


        <p class="text-muted">


            Cadastro e classificação inicial do paciente


        </p>


    </div>






    <!-- ====================================================== -->
    <!-- FORMULÁRIO -->
    <!-- ====================================================== -->


    <form id="formTriagem">




        <!-- ====================================================== -->
        <!-- IDENTIFICAÇÃO -->
        <!-- ====================================================== -->


        <div class="card shadow mb-4">


            <div class="card-header bg-dark text-white">


                <h5>


                    <i class="fas fa-user-injured"></i>


                    Identificação do Paciente


                </h5>


            </div>




            <div class="card-body">


                <div class="row">


                    <div class="col-md-6 mb-3">


                        <div class="form-floating">


                            <input
                                type="text"
                                class="form-control"
                                name="nome"
                                placeholder="Nome"
                                required
                            >


                            <label>Nome completo</label>


                        </div>


                    </div>




                    <div class="col-md-3 mb-3">


                        <div class="form-floating">


                            <input
                                type="date"
                                class="form-control"
                                name="data_nascimento"
                                required
                            >


                            <label>Data de nascimento</label>


                        </div>


                    </div>




                    <div class="col-md-3 mb-3">


                        <div class="form-floating">


                            <input
                                type="date"
                                class="form-control"
                                name="data_triagem"
                                value="<?= date('Y-m-d') ?>"
                                required
                            >


                            <label>Data da triagem</label>


                        </div>


                    </div>


                </div>




                <div class="form-floating">


                    <input
                        type="time"
                        class="form-control"
                        name="hora_triagem"
                        value="<?= date('H:i') ?>"
                        required
                    >


                    <label>Hora do atendimento</label>


                </div>


            </div>


        </div>






        <!-- ====================================================== -->
        <!-- MOTIVO -->
        <!-- ====================================================== -->


        <div class="card shadow mb-4">


            <div class="card-header bg-primary text-white">


                <h5>


                    <i class="fas fa-notes-medical"></i>


                    Motivo do Atendimento


                </h5>


            </div>




            <div class="card-body">




                <div class="form-floating mb-3">


                    <textarea
                        class="form-control"
                        name="queixa_principal"
                        style="height:100px"
                        required
                    ></textarea>


                    <label>Queixa principal</label>


                </div>




                <div class="form-floating mb-3">


                    <textarea
                        class="form-control"
                        name="sintomas"
                        style="height:120px"
                        required
                    ></textarea>


                    <label>Sintomas relatados</label>


                </div>




                <div class="form-floating mb-3">


                    <textarea
                        class="form-control"
                        name="historico"
                        style="height:100px"
                        required
                    ></textarea>


                    <label>Histórico clínico</label>


                </div>




                <div class="row">


                    <div class="col-md-6 mb-3">


                        <div class="form-floating">


                            <input
                                type="text"
                                class="form-control"
                                name="medicamentos"
                                placeholder="Medicamentos"
                                required
                            >


                            <label>Medicamentos em uso</label>


                        </div>


                    </div>




                    <div class="col-md-6">


                        <div class="form-floating">


                            <input
                                type="text"
                                class="form-control"
                                name="alergias"
                                placeholder="Alergias"
                                required
                            >


                            <label>Alergias</label>


                        </div>


                    </div>


                </div>


            </div>


        </div>






        <!-- ====================================================== -->
        <!-- SINAIS VITAIS -->
        <!-- ====================================================== -->


        <div class="card shadow mb-4">


            <div class="card-header bg-danger text-white">


                <h5>


                    <i class="fas fa-heartbeat"></i>


                    Sinais Vitais


                </h5>


            </div>




            <div class="card-body">


                <div class="row">




                    <div class="col-md-3 mb-3">


                        <label class="form-label">


                            Pressão arterial


                        </label>


                        <input
                            type="text"
                            class="form-control"
                            name="pressao"
                            placeholder="120x80"
                            required
                        >


                    </div>




                    <div class="col-md-3 mb-3">


                        <label class="form-label">


                            Temperatura


                        </label>


                        <input
                            type="text"
                            class="form-control"
                            name="temperatura"
                            placeholder="36,5"
                            required
                        >


                    </div>




                    <div class="col-md-3 mb-3">


                        <label class="form-label">


                            Frequência cardíaca


                        </label>


                        <input
                            type="number"
                            class="form-control"
                            name="frequencia"
                            placeholder="80"
                            min="0"
                            max="300"
                            required
                        >


                    </div>




                    <div class="col-md-3 mb-3">


                        <label class="form-label">


                            Saturação O₂


                        </label>


                        <input
                            type="number"
                            class="form-control"
                            name="saturacao"
                            placeholder="98"
                            min="0"
                            max="100"
                            required
                        >


                    </div>


                </div>




                <div class="form-floating mt-3">


                    <input
                        type="number"
                        min="0"
                        max="10"
                        class="form-control"
                        name="dor"
                        placeholder="Dor"
                        required
                    >


                    <label>


                        Escala de dor (0 - 10)


                    </label>


                </div>


            </div>


        </div>






        <!-- ====================================================== -->
        <!-- CONDIÇÕES ESPECIAIS -->
        <!-- ====================================================== -->


        <div class="card shadow mb-4">


            <div class="card-header bg-secondary text-white">


                <h5>


                    <i class="fas fa-user-shield"></i>


                    Condições Especiais


                </h5>


            </div>




            <div class="card-body">




                <div class="form-check mb-3">


                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="gestante"
                        value="1"
                        id="gestante"
                    >


                    <label
                        class="form-check-label"
                        for="gestante"
                    >


                        Gestante


                    </label>


                </div>




                <div class="form-check mb-3">


                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="imunossuprimido"
                        value="1"
                        id="imunossuprimido"
                    >


                    <label
                        class="form-check-label"
                        for="imunossuprimido"
                    >


                        Imunossuprimido


                    </label>


                </div>




                <div class="form-check mb-3">


                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="cronico"
                        value="1"
                        id="cronico"
                    >


                    <label
                        class="form-check-label"
                        for="cronico"
                    >


                        Doença crônica


                    </label>


                </div>




                <div class="form-check mb-3">


                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="hemorragia"
                        value="1"
                        id="hemorragia"
                    >


                    <label
                        class="form-check-label"
                        for="hemorragia"
                    >


                        Hemorragia


                    </label>


                </div>




                <div class="form-check mb-3">


                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="trauma"
                        value="1"
                        id="trauma"
                    >


                    <label
                        class="form-check-label"
                        for="trauma"
                    >


                        Trauma


                    </label>


                </div>




                <label class="form-label">


                    Estado de consciência


                </label>




                <select
                    class="form-select"
                    name="consciencia"
                >


                    <option value="normal">


                        Normal


                    </option>


                    <option value="alterada">


                        Alterada


                    </option>


                </select>


            </div>


        </div>






        <!-- ====================================================== -->
        <!-- CLASSIFICAÇÃO -->
        <!-- ====================================================== -->


        <div class="card shadow mb-4">


            <div class="card-header bg-warning">


                <h5>


                    <i class="fas fa-robot"></i>


                    Classificação de Risco


                </h5>


            </div>




            <div class="card-body">


                <div class="alert alert-info mb-0">


                    <i class="fas fa-info-circle"></i>


                    <strong>
                        A classificação será realizada automaticamente.
                    </strong>


                    <br>


                    O sistema utilizará as regras de segurança e a análise
                    auxiliar da IA para determinar a prioridade.


                    <br><br>


                    A classificação final poderá ser:


                    <strong>
                        Azul, Verde, Amarelo, Laranja ou Vermelho.
                    </strong>


                </div>


            </div>


        </div>






        <!-- ====================================================== -->
        <!-- BOTÕES -->
        <!-- ====================================================== -->


        <div class="d-flex justify-content-end gap-3 mb-5">


            <button
                type="button"
                class="btn btn-secondary btn-lg px-5"
                onclick="window.location.href='home.php'"
            >


                <i class="fas fa-home"></i>


                Retornar à home


            </button>




            <button
                type="submit"
                class="btn btn-dark btn-lg px-5 btn-enviar"
                id="btnEnviar"
            >


                <i class="fas fa-stethoscope"></i>


                Realizar Triagem


            </button>


        </div>




    </form>






    <!-- ====================================================== -->
    <!-- RESULTADO -->
    <!-- ====================================================== -->


    <div
        id="resultado"
        class="card shadow mb-5"
    >


        <div class="card-header bg-success text-white">


            <h5>


                <i class="fas fa-check-circle"></i>


                Triagem concluída


            </h5>


        </div>




        <div class="card-body text-center">




            <p class="text-muted">


                Prioridade final do paciente:


            </p>




            <div
                id="riscoFinal"
                class="risco-final mb-3"
            ></div>




            <p id="descricaoRisco"></p>




            <hr>




            <!-- ================================================== -->
            <!-- PROTOCOLO -->
            <!-- ================================================== -->


            <div class="text-start">


                <h6>


                    <i class="fas fa-list-check"></i>


                    Motivos identificados pelo protocolo


                </h6>


                <ul id="motivos"></ul>




                <!-- ================================================== -->
                <!-- IA -->
                <!-- ================================================== -->


                <div class="card bg-light border-0 mt-4 info-ia">


                    <div class="card-body">


                        <h6 class="mb-3">


                            <i class="fas fa-robot"></i>


                            Análise auxiliar da IA


                        </h6>




                        <p class="mb-2">


                            <strong>Prioridade sugerida pela IA:</strong>


                            <span id="prioridadeIA">
                                Não disponível
                            </span>


                        </p>




                        <p class="mb-2">


                            <strong>Confiança:</strong>


                            <span id="confiancaIA">
                                Não disponível
                            </span>


                        </p>




                        <p class="mb-2">


                            <strong>Necessita conferência humana:</strong>


                            <span id="conferenciaIA">
                                Não informado
                            </span>


                        </p>




                        <strong>Motivos identificados pela IA:</strong>


                        <ul id="motivosIA"></ul>




                        <strong>Alertas identificados pela IA:</strong>


                        <ul id="alertasIA"></ul>




                        <div
                            id="observacaoIA"
                            class="alert alert-info mt-3"
                            style="display:none"
                        ></div>


                    </div>


                </div>




                <!-- ================================================== -->
                <!-- SEGURANÇA -->
                <!-- ================================================== -->


                <h6 class="mt-4">


                    <i class="fas fa-shield-halved"></i>


                    Alertas de segurança do protocolo


                </h6>


                <ul id="alertas"></ul>


            </div>




            <hr>




            <button
                type="button"
                class="btn btn-dark mt-3"
                onclick="window.location.href='home.php'"
            >


                <i class="fas fa-home"></i>


                Voltar para a home


            </button>


        </div>


    </div>


</div>






<!-- ====================================================== -->
<!-- JAVASCRIPT -->
<!-- ====================================================== -->


<script>




document
    .getElementById("formTriagem")
    .addEventListener("submit", async function(event) {




        event.preventDefault();




        const formulario = this;


        const botao =
            document.getElementById("btnEnviar");




        /*
        |--------------------------------------------------------------------------
        | DESABILITA BOTÃO
        |--------------------------------------------------------------------------
        */


        botao.disabled = true;


        botao.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> Processando...';




        /*
        |--------------------------------------------------------------------------
        | DADOS
        |--------------------------------------------------------------------------
        */


        const dados =
            new FormData(formulario);




        try {




            /*
            |--------------------------------------------------------------------------
            | ENVIA PARA API
            |--------------------------------------------------------------------------
            */


            const resposta =
                await fetch(
                    "api_triagem.php",
                    {
                        method: "POST",
                        body: dados
                    }
                );




            const resultado =
                await resposta.json();




            /*
            |--------------------------------------------------------------------------
            | ERRO
            |--------------------------------------------------------------------------
            */


            if (!resposta.ok) {


                throw new Error(
                    resultado.mensagem ||
                    "Não foi possível realizar a triagem."
                );


            }




            /*
            |--------------------------------------------------------------------------
            | RESULTADO
            |--------------------------------------------------------------------------
            */


            document
                .getElementById("resultado")
                .style.display = "block";




            const avaliacao =
                resultado.avaliacao;




            /*
            |--------------------------------------------------------------------------
            | PRIORIDADE FINAL
            |--------------------------------------------------------------------------
            */


            document
                .getElementById("riscoFinal")
                .textContent =
                    avaliacao.prioridade_final;




            document
                .getElementById("descricaoRisco")
                .textContent =
                    avaliacao.descricao;




            /*
            |--------------------------------------------------------------------------
            | COR DO RESULTADO
            |--------------------------------------------------------------------------
            */


            const risco =
                avaliacao.prioridade_final;




            const riscoElemento =
                document.getElementById("riscoFinal");




            riscoElemento.className =
                "risco-final mb-3";




            if (risco === "Azul") {


                riscoElemento.classList.add(
                    "text-primary"
                );


            }


            else if (risco === "Verde") {


                riscoElemento.classList.add(
                    "text-success"
                );


            }


            else if (risco === "Amarelo") {


                riscoElemento.classList.add(
                    "text-warning"
                );


            }


            else if (risco === "Laranja") {


                riscoElemento.classList.add(
                    "text-warning"
                );


            }


            else if (risco === "Vermelho") {


                riscoElemento.classList.add(
                    "text-danger"
                );


            }




            /*
            |--------------------------------------------------------------------------
            | MOTIVOS DO PROTOCOLO
            |--------------------------------------------------------------------------
            */


            const listaMotivos =
                document.getElementById("motivos");




            listaMotivos.innerHTML = "";




            if (
                avaliacao.motivos &&
                avaliacao.motivos.length > 0
            ) {




                avaliacao.motivos.forEach(
                    function(motivo) {




                        const li =
                            document.createElement("li");




                        li.textContent =
                            motivo;




                        listaMotivos.appendChild(li);


                    }
                );




            } else {




                listaMotivos.innerHTML =
                    "<li>Nenhum motivo identificado pelo protocolo.</li>";


            }




            /*
            |--------------------------------------------------------------------------
            | DADOS DA IA
            |--------------------------------------------------------------------------
            */


            const ia =
                resultado.ia;




            /*
            |--------------------------------------------------------------------------
            | PRIORIDADE DA IA
            |--------------------------------------------------------------------------
            */


            const prioridadeIA =
                document.getElementById("prioridadeIA");




            if (
                ia &&
                ia.prioridade
            ) {


                prioridadeIA.textContent =
                    ia.prioridade;


            } else {


                prioridadeIA.textContent =
                    "Não disponível";


            }




            /*
            |--------------------------------------------------------------------------
            | CONFIANÇA
            |--------------------------------------------------------------------------
            */


            const confiancaIA =
                document.getElementById("confiancaIA");




            if (
                ia &&
                ia.confianca
            ) {


                confiancaIA.textContent =
                    ia.confianca;


            } else {


                confiancaIA.textContent =
                    "Não disponível";


            }




            /*
            |--------------------------------------------------------------------------
            | CONFERÊNCIA HUMANA
            |--------------------------------------------------------------------------
            */


            const conferenciaIA =
                document.getElementById("conferenciaIA");




            if (
                ia &&
                typeof ia.necessita_conferencia !== "undefined"
            ) {


                conferenciaIA.textContent =
                    ia.necessita_conferencia
                        ? "Sim"
                        : "Não";


            } else {


                conferenciaIA.textContent =
                    "Não informado";


            }




            /*
            |--------------------------------------------------------------------------
            | MOTIVOS DA IA
            |--------------------------------------------------------------------------
            */


            const listaMotivosIA =
                document.getElementById("motivosIA");




            listaMotivosIA.innerHTML = "";




            if (
                ia &&
                Array.isArray(ia.motivos) &&
                ia.motivos.length > 0
            ) {




                ia.motivos.forEach(
                    function(motivo) {




                        const li =
                            document.createElement("li");




                        li.textContent =
                            motivo;




                        listaMotivosIA.appendChild(li);


                    }
                );




            } else {




                listaMotivosIA.innerHTML =
                    "<li>A IA não forneceu motivos adicionais.</li>";


            }




            /*
            |--------------------------------------------------------------------------
            | ALERTAS DA IA
            |--------------------------------------------------------------------------
            */


            const listaAlertasIA =
                document.getElementById("alertasIA");




            listaAlertasIA.innerHTML = "";




            if (
                ia &&
                Array.isArray(ia.alertas) &&
                ia.alertas.length > 0
            ) {




                ia.alertas.forEach(
                    function(alerta) {




                        const li =
                            document.createElement("li");




                        li.textContent =
                            alerta;




                        listaAlertasIA.appendChild(li);


                    }
                );




            } else {




                listaAlertasIA.innerHTML =
                    "<li>Nenhum alerta adicional identificado pela IA.</li>";


            }




            /*
            |--------------------------------------------------------------------------
            | OBSERVAÇÃO DA IA
            |--------------------------------------------------------------------------
            */


            const observacao =
                document.getElementById("observacaoIA");




            if (
                ia &&
                ia.observacao
            ) {




                observacao.textContent =
                    ia.observacao;




                observacao.style.display =
                    "block";




            } else {




                observacao.style.display =
                    "none";


            }




            /*
            |--------------------------------------------------------------------------
            | ALERTAS DE SEGURANÇA DO PROTOCOLO
            |--------------------------------------------------------------------------
            */


            const listaAlertas =
                document.getElementById("alertas");




            listaAlertas.innerHTML = "";




            if (
                avaliacao.alertas_seguranca &&
                avaliacao.alertas_seguranca.length > 0
            ) {




                avaliacao.alertas_seguranca.forEach(
                    function(alerta) {




                        const li =
                            document.createElement("li");




                        li.textContent =
                            alerta;




                        listaAlertas.appendChild(li);


                    }
                );




            } else {




                listaAlertas.innerHTML =
                    "<li>Nenhum alerta de segurança identificado.</li>";


            }




            /*
            |--------------------------------------------------------------------------
            | SCROLL
            |--------------------------------------------------------------------------
            */


            document
                .getElementById("resultado")
                .scrollIntoView({
                    behavior: "smooth"
                });




            /*
            |--------------------------------------------------------------------------
            | LIMPA FORMULÁRIO
            |--------------------------------------------------------------------------
            */


            formulario.reset();




        }




        catch (erro) {




            alert(
                "Erro ao realizar a triagem:\n\n" +
                erro.message
            );




        }




        finally {




            /*
            |--------------------------------------------------------------------------
            | RESTAURA BOTÃO
            |--------------------------------------------------------------------------
            */


            botao.disabled = false;




            botao.innerHTML =
                '<i class="fas fa-stethoscope"></i> Realizar Triagem';


        }


    });




</script>




</body>


</html>


