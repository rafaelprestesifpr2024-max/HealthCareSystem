<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Orientação de Área Médica</title>

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
            background: linear-gradient(
                135deg,
                #eef5ff 0%,
                #f8fbff 50%,
                #eef8f5 100%
            );

            min-height: 100vh;
            color: #263238;
        }


        .pagina {
            max-width: 1050px;
            margin: auto;
        }


        /* CABEÇALHO */

        .cabecalho {
            background: white;
            border-radius: 22px;
            padding: 35px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.07);
            margin-bottom: 25px;
        }


        .icone-titulo {
            width: 70px;
            height: 70px;
            border-radius: 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #0d6efd;
            color: white;

            font-size: 30px;

            margin: 0 auto 18px;
        }


        .titulo {
            font-weight: 700;
            color: #172b4d;
        }


        .subtitulo {
            color: #6c757d;
            max-width: 700px;
            margin: auto;
        }


        /* AVISO */

        .aviso {
            border: none;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.04);
        }


        /* CARDS */

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(0,0,0,0.06);
            margin-bottom: 22px;
        }


        .card-header-custom {
            padding: 18px 22px;
            color: white;
            font-weight: 600;
        }


        .header-paciente {
            background: linear-gradient(
                135deg,
                #343a40,
                #495057
            );
        }


        .header-condicoes {
            background: linear-gradient(
                135deg,
                #6c757d,
                #868e96
            );
        }


        .header-sintomas {
            background: linear-gradient(
                135deg,
                #0d6efd,
                #0b5ed7
            );
        }


        .header-situacao {
            background: linear-gradient(
                135deg,
                #0dcaf0,
                #0aa2c0
            );
        }


        .header-adicional {
            background: linear-gradient(
                135deg,
                #495057,
                #6c757d
            );
        }


        .card-body {
            padding: 25px;
        }


        /* FORMULÁRIOS */

        .form-label {
            font-weight: 600;
            color: #344054;
        }


        .form-control,
        .form-select {
            border-radius: 11px;
            border: 1px solid #d9dee7;
            padding: 11px 14px;
        }


        .form-control:focus,
        .form-select:focus {

            border-color: #0d6efd;

            box-shadow:
                0 0 0 0.2rem
                rgba(13,110,253,0.12);

        }


        textarea {
            resize: vertical;
        }


        /* BOTÕES */

        .area-botoes {
            background: white;
            padding: 20px;
            border-radius: 18px;

            box-shadow:
                0 8px 28px
                rgba(0,0,0,0.06);
        }


        .btn {
            border-radius: 11px;
            font-weight: 600;
        }


        .btn-identificar {
            min-width: 220px;
        }


        /* RESULTADO */

        #resultado {
            display: none;
        }


        .resultado-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;

            box-shadow:
                0 12px 40px
                rgba(25,135,84,0.15);
        }


        .resultado-header {
            background: linear-gradient(
                135deg,
                #198754,
                #20a464
            );

            color: white;
            padding: 22px;
        }


        .resultado-body {
            padding: 30px;
        }


        .area-label {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 5px;
        }


        .area-principal {
            font-size: 34px;
            font-weight: 800;
            color: #198754;
        }


        .area-icone {
            width: 80px;
            height: 80px;

            margin: auto auto 15px;

            border-radius: 50%;

            background: #e8f7ef;

            color: #198754;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 35px;
        }


        .motivos-box {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 20px;
        }


        .motivos-box li {
            margin-bottom: 8px;
        }


        .loading {
            display: none;
        }


        /* RODAPÉ */

        .rodape {
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            padding: 25px 0;
        }


        @media (max-width: 768px) {

            .cabecalho {
                padding: 25px 18px;
            }

            .card-body {
                padding: 20px;
            }

            .area-principal {
                font-size: 27px;
            }

            .area-botoes {
                text-align: center;
            }

            .area-botoes .btn {
                width: 100%;
                margin-bottom: 10px;
            }

        }

    </style>

</head>


<body>


<div class="container py-4 py-md-5">

<div class="pagina">


    <!-- CABEÇALHO -->

    <div class="cabecalho text-center">

        <div class="icone-titulo">

            <i class="fas fa-stethoscope"></i>

        </div>


        <h1 class="titulo">

            Orientação de Área Médica

        </h1>


        <p class="subtitulo mb-0">

            Informe seus sintomas e condições de saúde para receber
            uma orientação sobre qual área hospitalar ou especialidade
            pode ser mais adequada para avaliação.

        </p>

    </div>


    <!-- AVISO -->

    <div class="alert alert-warning aviso mb-4">

        <i class="fas fa-triangle-exclamation me-2"></i>

        <strong>Importante:</strong>

        este sistema fornece apenas uma orientação de área de atendimento.
        Não realiza diagnóstico médico e não substitui uma avaliação
        profissional.

    </div>


    <!-- FORMULÁRIO -->

    <form id="formAreas">


        <!-- PACIENTE -->

        <div class="card">

            <div class="card-header-custom header-paciente">

                <i class="fas fa-user me-2"></i>

                Dados do paciente

            </div>


            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nome

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="nome"
                            placeholder="Nome completo"
                            required
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Data de nascimento

                        </label>

                        <input
                            type="date"
                            class="form-control"
                            name="data_nascimento"
                            required
                        >

                    </div>


                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            Sexo

                        </label>

                        <select
                            class="form-select"
                            name="sexo"
                            required
                        >

                            <option value="">

                                Selecione

                            </option>

                            <option value="feminino">

                                Feminino

                            </option>

                            <option value="masculino">

                                Masculino

                            </option>

                            <option value="outro">

                                Outro

                            </option>

                            <option value="nao_informado">

                                Prefiro não informar

                            </option>

                        </select>

                    </div>

                </div>

            </div>

        </div>


        <!-- CONDIÇÕES -->

        <div class="card">

            <div class="card-header-custom header-condicoes">

                <i class="fas fa-notes-medical me-2"></i>

                Doenças e condições de saúde

            </div>


            <div class="card-body">

                <label class="form-label">

                    Você possui alguma doença ou condição
                    de saúde já diagnosticada?

                </label>


                <textarea
                    class="form-control"
                    name="doencas"
                    rows="4"
                    placeholder="Ex.: hipertensão, diabetes, asma, problema cardíaco, doença renal. Caso não possua, escreva 'Nenhuma'."
                ></textarea>

            </div>

        </div>


        <!-- SINTOMAS -->

        <div class="card">

            <div class="card-header-custom header-sintomas">

                <i class="fas fa-heart-pulse me-2"></i>

                Sintomas

            </div>


            <div class="card-body">

                <label class="form-label">

                    Quais sintomas você está sentindo?

                </label>


                <textarea
                    class="form-control"
                    name="sintomas"
                    rows="6"
                    placeholder="Ex.: dor de cabeça, dor de garganta, perda de audição, ansiedade, dor abdominal..."
                    required
                ></textarea>


                <div class="form-text mt-2">

                    Descreva os sintomas da forma mais clara possível.

                </div>

            </div>

        </div>


        <!-- SITUAÇÃO -->

        <div class="card">

            <div class="card-header-custom header-situacao">

                <i class="fas fa-clipboard-question me-2"></i>

                Situação atual

            </div>


            <div class="card-body">

                <label class="form-label">

                    Como você está neste momento?

                </label>


                <textarea
                    class="form-control"
                    name="situacao_atual"
                    rows="6"
                    placeholder="Informe quando começou, se está melhorando ou piorando, intensidade dos sintomas e outras informações importantes."
                    required
                ></textarea>

            </div>

        </div>


        <!-- INFORMAÇÕES -->

        <div class="card">

            <div class="card-header-custom header-adicional">

                <i class="fas fa-circle-info me-2"></i>

                Informações adicionais

            </div>


            <div class="card-body">

                <textarea
                    class="form-control"
                    name="informacoes_adicionais"
                    rows="4"
                    placeholder="Informe qualquer outra informação que possa ajudar na orientação."
                ></textarea>

            </div>

        </div>


        <!-- BOTÕES -->

        <div class="area-botoes mb-5">

            <div class="d-flex justify-content-end gap-2 flex-wrap">

                <button
                    type="button"
                    class="btn btn-secondary btn-lg px-4"
                    onclick="window.location.href='home_pacientes.php'"
                >

                    <i class="fas fa-home me-2"></i>

                    Voltar

                </button>


                <button
                    type="submit"
                    class="btn btn-primary btn-lg px-4 btn-identificar"
                    id="btnEnviar"
                >

                    <span id="textoBotao">

                        <i class="fas fa-search me-2"></i>

                        Identificar área

                    </span>


                    <span
                        id="loadingBotao"
                        class="loading"
                    >

                        <i class="fas fa-spinner fa-spin me-2"></i>

                        Analisando...

                    </span>

                </button>

            </div>

        </div>


    </form>


    <!-- RESULTADO -->

    <div
        id="resultado"
        class="resultado-card mb-5"
    >

        <div class="resultado-header">

            <h5 class="mb-0">

                <i class="fas fa-check-circle me-2"></i>

                Orientação concluída

            </h5>

        </div>


        <div class="resultado-body">


            <div class="text-center mb-4">

                <div class="area-icone">

                    <i class="fas fa-hospital-user"></i>

                </div>


                <div class="area-label">

                    Área hospitalar / especialidade
                    recomendada:

                </div>


                <div
                    id="areaPrincipal"
                    class="area-principal"
                >

                    -

                </div>

            </div>


            <hr class="my-4">


            <!-- MOTIVOS -->

            <div class="motivos-box">

                <h6 class="fw-bold mb-3">

                    <i class="fas fa-circle-info text-primary me-2"></i>

                    Por que esta área foi indicada?

                </h6>


                <ul
                    id="motivosArea"
                    class="mb-0"
                ></ul>

            </div>


            <!-- OBSERVAÇÃO -->

            <div
                id="observacaoArea"
                class="alert alert-info mt-4"
                style="display:none"
            ></div>


            <!-- ALERTAS -->

            <div
                id="alertaResultado"
                class="alert alert-warning mt-4"
                style="display:none"
            ></div>


            <div class="text-center mt-4">

                <button
                    type="button"
                    class="btn btn-dark"
                    onclick="window.location.href='home.php'"
                >

                    <i class="fas fa-home me-2"></i>

                    Voltar para a home

                </button>

            </div>

        </div>

    </div>


    <div class="rodape">

        <i class="fas fa-shield-halved me-1"></i>

        Sistema de orientação — não substitui avaliação médica profissional.

    </div>


</div>

</div>


<script>


document
    .getElementById("formAreas")
    .addEventListener(
        "submit",
        async function(event) {

            event.preventDefault();


            const formulario = this;


            const botao =
                document.getElementById(
                    "btnEnviar"
                );


            const textoBotao =
                document.getElementById(
                    "textoBotao"
                );


            const loadingBotao =
                document.getElementById(
                    "loadingBotao"
                );


            const resultado =
                document.getElementById(
                    "resultado"
                );


            /*
            |--------------------------------------------------------------------------
            | VALIDAÇÃO
            |--------------------------------------------------------------------------
            */

            if (
                !formulario.checkValidity()
            ) {

                formulario.reportValidity();

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | LOADING
            |--------------------------------------------------------------------------
            */

            botao.disabled = true;

            textoBotao.style.display =
                "none";

            loadingBotao.style.display =
                "inline";


            try {


                /*
                |--------------------------------------------------------------------------
                | FORMULÁRIO
                |--------------------------------------------------------------------------
                */

                const formData =
                    new FormData(
                        formulario
                    );


                const dados = {

                    nome:
                        String(
                            formData.get(
                                "nome"
                            ) || ""
                        ).trim(),


                    data_nascimento:
                        String(
                            formData.get(
                                "data_nascimento"
                            ) || ""
                        ).trim(),


                    sexo:
                        String(
                            formData.get(
                                "sexo"
                            ) || ""
                        ).trim(),


                    doencas:
                        String(
                            formData.get(
                                "doencas"
                            ) || ""
                        ).trim(),


                    sintomas:
                        String(
                            formData.get(
                                "sintomas"
                            ) || ""
                        ).trim(),


                    situacao_atual:
                        String(
                            formData.get(
                                "situacao_atual"
                            ) || ""
                        ).trim(),


                    informacoes_adicionais:
                        String(
                            formData.get(
                                "informacoes_adicionais"
                            ) || ""
                        ).trim()

                };


                console.log(
                    "Dados enviados:",
                    dados
                );


                /*
                |--------------------------------------------------------------------------
                | API
                |--------------------------------------------------------------------------
                */

                const resposta =
                    await fetch(
                        "api_areas.php",
                        {

                            method: "POST",

                            headers: {

                                "Content-Type":
                                    "application/json",

                                "Accept":
                                    "application/json"

                            },

                            body:
                                JSON.stringify(
                                    dados
                                )

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | TEXTO DA RESPOSTA
                |--------------------------------------------------------------------------
                */

                const texto =
                    await resposta.text();


                console.log(
                    "Status HTTP:",
                    resposta.status
                );


                console.log(
                    "Resposta da API:",
                    texto
                );


                /*
                |--------------------------------------------------------------------------
                | JSON
                |--------------------------------------------------------------------------
                */

                let resultadoAPI;


                try {

                    resultadoAPI =
                        JSON.parse(
                            texto
                        );

                }

                catch (erroJSON) {

                    console.error(
                        "Resposta inválida:",
                        texto
                    );

                    throw new Error(
                        "A API não retornou um JSON válido. Verifique o arquivo api_areas.php."
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | ERRO HTTP
                |--------------------------------------------------------------------------
                */

                if (
                    !resposta.ok
                ) {

                    throw new Error(

                        resultadoAPI.erro ||

                        resultadoAPI.mensagem ||

                        "Erro HTTP " +
                        resposta.status

                    );

                }


                /*
                |--------------------------------------------------------------------------
                | SUCESSO
                |--------------------------------------------------------------------------
                */

                if (
                    resultadoAPI.sucesso !== true
                ) {

                    throw new Error(

                        resultadoAPI.erro ||

                        resultadoAPI.mensagem ||

                        "A API não conseguiu realizar a análise."

                    );

                }


                /*
                |--------------------------------------------------------------------------
                | ORIENTAÇÃO
                |--------------------------------------------------------------------------
                */

                const orientacao =
                    resultadoAPI.orientacao;


                if (!orientacao) {

                    throw new Error(
                        "A API não retornou a orientação."
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | MOSTRAR RESULTADO
                |--------------------------------------------------------------------------
                */

                resultado.style.display =
                    "block";


                /*
                |--------------------------------------------------------------------------
                | ÁREA
                |--------------------------------------------------------------------------
                */

                document
                    .getElementById(
                        "areaPrincipal"
                    )
                    .textContent =

                    orientacao.area_recomendada ||

                    "Não determinada";


                /*
                |--------------------------------------------------------------------------
                | MOTIVOS
                |--------------------------------------------------------------------------
                */

                const listaMotivos =
                    document.getElementById(
                        "motivosArea"
                    );


                listaMotivos.innerHTML =
                    "";


                if (

                    Array.isArray(
                        orientacao.motivos
                    )

                    &&

                    orientacao.motivos.length > 0

                ) {

                    orientacao
                        .motivos
                        .forEach(
                            function(motivo) {

                                const li =
                                    document.createElement(
                                        "li"
                                    );


                                li.textContent =
                                    motivo;


                                listaMotivos
                                    .appendChild(
                                        li
                                    );

                            }
                        );

                }

                else {

                    const li =
                        document.createElement(
                            "li"
                        );


                    li.textContent =
                        "Não foram informados motivos específicos.";


                    listaMotivos
                        .appendChild(
                            li
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | OBSERVAÇÃO
                |--------------------------------------------------------------------------
                */

                const observacao =
                    document.getElementById(
                        "observacaoArea"
                    );


                if (

                    orientacao.observacao &&

                    String(
                        orientacao.observacao
                    ).trim() !== ""

                ) {

                    observacao.textContent =
                        orientacao.observacao;


                    observacao.style.display =
                        "block";

                }

                else {

                    observacao.style.display =
                        "none";

                }


                /*
                |--------------------------------------------------------------------------
                | ALERTAS
                |--------------------------------------------------------------------------
                */

                const alerta =
                    document.getElementById(
                        "alertaResultado"
                    );


                alerta.innerHTML =
                    "";


                if (

                    Array.isArray(
                        orientacao.alertas
                    )

                    &&

                    orientacao.alertas.length > 0

                ) {


                    const titulo =
                        document.createElement(
                            "strong"
                        );


                    titulo.textContent =
                        "Atenção:";


                    alerta.appendChild(
                        titulo
                    );


                    const lista =
                        document.createElement(
                            "ul"
                        );


                    lista.className =
                        "mb-0 mt-2";


                    orientacao
                        .alertas
                        .forEach(
                            function(item) {

                                const li =
                                    document.createElement(
                                        "li"
                                    );


                                li.textContent =
                                    item;


                                lista.appendChild(
                                    li
                                );

                            }
                        );


                    alerta.appendChild(
                        lista
                    );


                    alerta.style.display =
                        "block";

                }

                else {

                    alerta.style.display =
                        "none";

                }


                /*
                |--------------------------------------------------------------------------
                | SCROLL
                |--------------------------------------------------------------------------
                */

                resultado.scrollIntoView({

                    behavior: "smooth",

                    block: "start"

                });

            }


            catch (erro) {

                console.error(
                    "Erro completo:",
                    erro
                );


                alert(

                    "Erro ao realizar a análise:\n\n" +

                    erro.message

                );

            }


            finally {

                botao.disabled =
                    false;


                textoBotao.style.display =
                    "inline";


                loadingBotao.style.display =
                    "none";

            }

        }
    );

</script>


</body>

</html>