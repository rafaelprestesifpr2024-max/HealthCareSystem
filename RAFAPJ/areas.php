<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
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
            min-width: 230px;
        }
        #resultado {
            display: none;
        }
        .area-principal {
            font-size: 30px;
            font-weight: bold;
        }
        .area-card {
            border-left: 5px solid #0d6efd;
            border-radius: 10px;
        }
        .area-secundaria {
            border-radius: 10px;
        }
        .pergunta-extra {
            display: none;
        }
        .info-ia {
            border-radius: 12px;
        }
        .aviso-medico {
            border-radius: 12px;
        }
        .badge-area {
            font-size: 14px;
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
            <i class="fas fa-stethoscope text-primary"></i>
            Orientação de Área Médica
        </h1>
        <p class="text-muted">
            Informe seus sintomas para identificar qual área de atendimento
            pode ser mais adequada.
        </p>
    </div>
    <!-- ====================================================== -->
    <!-- AVISO -->
    <!-- ====================================================== -->
    <div class="alert alert-warning aviso-medico mb-4">
        <i class="fas fa-triangle-exclamation"></i>
        <strong>Importante:</strong>
        este sistema fornece apenas uma orientação sobre a área de atendimento
        mais relacionada aos sintomas informados.
        Ele não realiza diagnóstico médico e não substitui uma avaliação
        profissional.
    </div>
    <!-- ====================================================== -->
    <!-- FORMULÁRIO -->
    <!-- ====================================================== -->
    <form id="formAreas">
        <!-- ================================================== -->
        <!-- DADOS DO PACIENTE -->
        <!-- ================================================== -->
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i>
                    Dados do paciente
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- NOME -->
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input
                                type="text"
                                class="form-control"
                                name="nome"
                                placeholder="Nome"
                                required
                            >
                            <label>
                                Nome completo
                            </label>
                        </div>
                    </div>
                    <!-- DATA NASCIMENTO -->
                    <div class="col-md-3 mb-3">
                        <div class="form-floating">
                            <input
                                type="date"
                                class="form-control"
                                name="data_nascimento"
                                id="dataNascimento"
                                required
                            >
                            <label>
                                Data de nascimento
                            </label>
                        </div>
                    </div>
                    <!-- SEXO -->
                    <div class="col-md-3 mb-3">
                        <div class="form-floating">
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
                            <label>
                                Sexo
                            </label>
                        </div>
                    </div>
                </div>
                <!-- GESTANTE -->
                <div class="form-check mt-2">
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
                <!-- SEMANAS -->
                <div
                    id="campoGestacao"
                    class="mt-3"
                    style="display:none;"
                >
                    <label class="form-label">
                        Semanas de gestação
                    </label>
                    <input
                        type="number"
                        class="form-control"
                        name="semanas_gestacao"
                        min="1"
                        max="45"
                    >
                </div>
            </div>
        </div>
        <!-- ================================================== -->
        <!-- PROBLEMA PRINCIPAL -->
        <!-- ================================================== -->
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-notes-medical"></i>
                    Problema principal
                </h5>
            </div>
            <div class="card-body">
                <!-- DESCRIÇÃO -->
                <div class="form-floating mb-4">
                    <textarea
                        class="form-control"
                        name="descricao"
                        style="height:130px"
                        placeholder="Descrição"
                        required
                    ></textarea>
                    <label>
                        Descreva o que está acontecendo
                    </label>
                </div>
                <!-- REGIÃO -->
                <label class="form-label fw-bold">
                    Qual região está relacionada ao problema?
                </label>
                <select
                    class="form-select mb-3"
                    name="regiao"
                    id="regiao"
                    required
                >
                    <option value="">
                        Selecione uma opção
                    </option>
                    <option value="cabeca">
                        Cabeça
                    </option>
                    <option value="olhos">
                        Olhos / visão
                    </option>
                    <option value="ouvidos">
                        Ouvidos
                    </option>
                    <option value="nariz">
                        Nariz / seios da face
                    </option>
                    <option value="garganta">
                        Garganta
                    </option>
                    <option value="pescoco">
                        Pescoço
                    </option>
                    <option value="peito">
                        Peito / tórax
                    </option>
                    <option value="respiratorio">
                        Respiração / pulmões
                    </option>
                    <option value="coracao">
                        Coração / palpitações
                    </option>
                    <option value="abdomen">
                        Abdômen
                    </option>
                    <option value="digestivo">
                        Estômago / intestino
                    </option>
                    <option value="urinario">
                        Rins / urina
                    </option>
                    <option value="genital">
                        Região genital
                    </option>
                    <option value="pele">
                        Pele / cabelos / unhas
                    </option>
                    <option value="ossos">
                        Ossos
                    </option>
                    <option value="articulacoes">
                        Articulações
                    </option>
                    <option value="musculos">
                        Músculos
                    </option>
                    <option value="costas">
                        Costas / coluna
                    </option>
                    <option value="neurologico">
                        Sistema nervoso
                    </option>
                    <option value="emocional">
                        Saúde emocional / mental
                    </option>
                    <option value="outro">
                        Outro / não sei identificar
                    </option>
                </select>
                <!-- LOCALIZAÇÃO -->
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control"
                        name="localizacao"
                        placeholder="Localização"
                    >
                    <label>
                        Localização mais específica
                    </label>
                </div>
                <!-- LADO -->
                <div class="form-floating">
                    <select
                        class="form-select"
                        name="lado"
                    >
                        <option value="nao_aplicavel">
                            Não se aplica
                        </option>
                        <option value="direito">
                            Lado direito
                        </option>
                        <option value="esquerdo">
                            Lado esquerdo
                        </option>
                        <option value="ambos">
                            Ambos os lados
                        </option>
                        <option value="central">
                            Centro
                        </option>
                    </select>
                    <label>
                        Lado do corpo
                    </label>
                </div>
            </div>
        </div>
        <!-- ================================================== -->
        <!-- SINTOMAS -->
        <!-- ================================================== -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-heart-pulse"></i>
                    Características dos sintomas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- SINTOMA PRINCIPAL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Sintoma principal
                        </label>
                        <select
                            class="form-select"
                            name="sintoma_principal"
                            required
                        >
                            <option value="">
                                Selecione
                            </option>
                            <option value="dor">
                                Dor
                            </option>
                            <option value="febre">
                                Febre
                            </option>
                            <option value="tosse">
                                Tosse
                            </option>
                            <option value="falta_ar">
                                Falta de ar
                            </option>
                            <option value="palpitacao">
                                Palpitação
                            </option>
                            <option value="tontura">
                                Tontura
                            </option>
                            <option value="desmaio">
                                Desmaio
                            </option>
                            <option value="fraqueza">
                                Fraqueza
                            </option>
                            <option value="formigamento">
                                Formigamento / dormência
                            </option>
                            <option value="inchaço">
                                Inchaço
                            </option>
                            <option value="sangramento">
                                Sangramento
                            </option>
                            <option value="coceira">
                                Coceira
                            </option>
                            <option value="alteracao_visao">
                                Alteração da visão
                            </option>
                            <option value="alteracao_audicao">
                                Alteração da audição
                            </option>
                            <option value="nausea">
                                Náusea
                            </option>
                            <option value="vomito">
                                Vômito
                            </option>
                            <option value="diarreia">
                                Diarreia
                            </option>
                            <option value="constipacao">
                                Constipação
                            </option>
                            <option value="urinario">
                                Alteração urinária
                            </option>
                            <option value="emocional">
                                Alteração emocional
                            </option>
                            <option value="outro">
                                Outro
                            </option>
                        </select>
                    </div>
                    <!-- DURAÇÃO -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Há quanto tempo?
                        </label>
                        <select
                            class="form-select"
                            name="duracao"
                            required
                        >
                            <option value="">
                                Selecione
                            </option>
                            <option value="hoje">
                                Começou hoje
                            </option>
                            <option value="dias">
                                Há alguns dias
                            </option>
                            <option value="semanas">
                                Há algumas semanas
                            </option>
                            <option value="meses">
                                Há alguns meses
                            </option>
                            <option value="anos">
                                Há mais de um ano
                            </option>
                            <option value="recorrente">
                                É recorrente
                            </option>
                        </select>
                    </div>
                </div>
                <!-- SINTOMAS ASSOCIADOS -->
                <div class="form-floating mb-3">
                    <textarea
                        class="form-control"
                        name="sintomas_associados"
                        style="height:120px"
                        placeholder="Sintomas"
                    ></textarea>
                    <label>
                        Outros sintomas que estão acontecendo junto
                    </label>
                </div>
                <div class="row">
                    <!-- EVOLUÇÃO -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Evolução
                        </label>
                        <select
                            class="form-select"
                            name="evolucao"
                            required
                        >
                            <option value="estavel">
                                Está estável
                            </option>
                            <option value="melhorando">
                                Está melhorando
                            </option>
                            <option value="piorando">
                                Está piorando
                            </option>
                            <option value="vai_volta">
                                Vai e volta
                            </option>
                        </select>
                    </div>
                    <!-- INTENSIDADE -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Intensidade do problema
                        </label>
                        <select
                            class="form-select"
                            name="intensidade"
                            required
                        >
                            <option value="">
                                Selecione
                            </option>
                            <option value="0">
                                0 — Nenhuma
                            </option>
                            <option value="1">
                                1
                            </option>
                            <option value="2">
                                2
                            </option>
                            <option value="3">
                                3 — Leve
                            </option>
                            <option value="4">
                                4
                            </option>
                            <option value="5">
                                5 — Moderada
                            </option>
                            <option value="6">
                                6
                            </option>
                            <option value="7">
                                7
                            </option>
                            <option value="8">
                                8
                            </option>
                            <option value="9">
                                9
                            </option>
                            <option value="10">
                                10 — Muito intensa
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- ================================================== -->
        <!-- PERGUNTAS ESPECÍFICAS -->
        <!-- ================================================== -->
        <div
            id="perguntasDinamicas"
            class="card shadow mb-4"
        >
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-list-check"></i>
                    Informações complementares
                </h5>
            </div>
            <div class="card-body">
                <!-- RESPIRATÓRIO -->
                <div
                    id="perguntasRespiratorias"
                    class="pergunta-extra"
                >
                    <h6>
                        Sintomas respiratórios
                    </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="tosse"
                                    value="1"
                                    id="tosse"
                                >
                                <label
                                    class="form-check-label"
                                    for="tosse"
                                >
                                    Tosse
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="catarro"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Catarro
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="chiado"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Chiado
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- NEUROLÓGICO -->
                <div
                    id="perguntasNeurologicas"
                    class="pergunta-extra"
                >
                    <h6>
                        Sintomas neurológicos
                    </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="fraqueza"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Fraqueza
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="formigamento"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Formigamento
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="alteracao_fala"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Alteração da fala
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DIGESTIVO -->
                <div
                    id="perguntasDigestivas"
                    class="pergunta-extra"
                >
                    <h6>
                        Sintomas digestivos
                    </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="nausea"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Náusea
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="vomito"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Vômitos
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="azia_refluxo"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Azia / refluxo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ORTOPÉDICO -->
                <div
                    id="perguntasOrtopedicas"
                    class="pergunta-extra"
                >
                    <h6>
                        Sintomas musculoesqueléticos
                    </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="trauma"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Houve trauma
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="inchaco_articular"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Inchaço
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="limitacao_movimento"
                                    value="1"
                                >
                                <label class="form-check-label">
                                    Dificuldade de movimento
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- INFORMAÇÕES ADICIONAIS -->
                <div class="form-floating mt-4">
                    <textarea
                        class="form-control"
                        name="informacoes_adicionais"
                        style="height:100px"
                        placeholder="Informações"
                    ></textarea>
                    <label>
                        Existe alguma outra informação importante?
                    </label>
                </div>
            </div>
        </div>
        <!-- ================================================== -->
        <!-- HISTÓRICO -->
        <!-- ================================================== -->
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-medical"></i>
                    Histórico de saúde
                </h5>
            </div>
            <div class="card-body">
                <label class="form-label fw-bold">
                    Possui alguma destas condições?
                </label>
                <div class="row">
                    <?php
                    $condicoes = [
                        "hipertensao" =>
                            "Hipertensão",
                        "diabetes" =>
                            "Diabetes",
                        "cardiaca" =>
                            "Doença cardíaca",
                        "pulmonar" =>
                            "Doença pulmonar",
                        "renal" =>
                            "Doença renal",
                        "neurologica" =>
                            "Doença neurológica",
                        "gastrointestinal" =>
                            "Doença gastrointestinal",
                        "autoimune" =>
                            "Doença autoimune",
                        "cancer" =>
                            "Câncer",
                        "pele" =>
                            "Doença de pele"
                    ];
                    foreach (
                        $condicoes as $valor => $nome
                    ) {
                        echo '
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="condicoes[]"
                                    value="' .
                                    htmlspecialchars(
                                        $valor,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) .
                                    '"
                                    id="' .
                                    htmlspecialchars(
                                        $valor,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) .
                                    '"
                                >
                                <label
                                    class="form-check-label"
                                    for="' .
                                    htmlspecialchars(
                                        $valor,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) .
                                    '"
                                >
                                    ' .
                                    htmlspecialchars(
                                        $nome,
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) .
                                    '
                                </label>
                            </div>
                        </div>
                        ';
                    }
                    ?>
                </div>
                <!-- MEDICAMENTOS -->
                <div class="form-floating mt-4 mb-3">
                    <input
                        type="text"
                        class="form-control"
                        name="medicamentos"
                        placeholder="Medicamentos"
                    >
                    <label>
                        Medicamentos em uso
                    </label>
                </div>
                <!-- ALERGIAS -->
                <div class="form-floating">
                    <input
                        type="text"
                        class="form-control"
                        name="alergias"
                        placeholder="Alergias"
                    >
                    <label>
                        Alergias
                    </label>
                </div>
            </div>
        </div>
        <!-- ================================================== -->
        <!-- BOTÕES -->
        <!-- ================================================== -->
        <div class="d-flex justify-content-end gap-3 mb-5">
            <button
                type="button"
                class="btn btn-secondary btn-lg px-5"
                onclick="window.location.href='home.php'"
            >
                <i class="fas fa-home"></i>
                Voltar
            </button>
            <button
                type="submit"
                class="btn btn-primary btn-lg px-5 btn-enviar"
                id="btnEnviar"
            >
                <i class="fas fa-search"></i>
                Identificar área
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
            <h5 class="mb-0">
                <i class="fas fa-check-circle"></i>
                Orientação concluída
            </h5>
        </div>
        <div class="card-body">
            <!-- ÁREA PRINCIPAL -->
            <div class="text-center mb-4">
                <p class="text-muted mb-1">
                    Área com maior correspondência:
                </p>
                <div
                    id="areaPrincipal"
                    class="area-principal text-primary"
                >
                    -
                </div>
                <p
                    id="descricaoArea"
                    class="text-muted"
                ></p>
            </div>
            <hr>
            <!-- MOTIVOS -->
            <h6>
                <i class="fas fa-circle-info"></i>
                Por que essa área foi indicada?
            </h6>
            <ul id="motivosArea"></ul>
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
            <!-- IA -->
            <div
                class="card bg-light border-0 info-ia mt-4"
            >
                <div class="card-body">
                    <h6>
                        <i class="fas fa-robot"></i>
                        Análise auxiliar
                    </h6>
                    <p class="mb-2">
                        <strong>
                            Análise utilizada:
                        </strong>
                        <span id="iaStatus">
                            Não informado
                        </span>
                    </p>
                    <p class="mb-0">
                        <strong>
                            Necessita avaliação profissional:
                        </strong>
                        <span id="conferencia">
                            Sim
                        </span>
                    </p>
                </div>
            </div>
            <!-- VOLTAR -->
            <div class="text-center mt-4">
                <button
                    type="button"
                    class="btn btn-dark"
                    onclick="window.location.href='home.php'"
                >
                    <i class="fas fa-home"></i>
                    Voltar para a home
                </button>
            </div>
        </div>
    </div>
</div>
<script>
/*
|--------------------------------------------------------------------------
| GESTAÇÃO
|--------------------------------------------------------------------------
*/
document
    .getElementById("gestante")
    .addEventListener(
        "change",
        function () {
            const campo =
                document.getElementById(
                    "campoGestacao"
                );
            campo.style.display =
                this.checked
                    ? "block"
                    : "none";
        }
    );
/*
|--------------------------------------------------------------------------
| PERGUNTAS DINÂMICAS
|--------------------------------------------------------------------------
*/
document
    .getElementById("regiao")
    .addEventListener(
        "change",
        function () {
            const regiao =
                this.value;
            document
                .querySelectorAll(
                    ".pergunta-extra"
                )
                .forEach(
                    function (elemento) {
                        elemento.style.display =
                            "none";
                    }
                );
            if (
                regiao === "respiratorio" ||
                regiao === "peito"
            ) {
                document
                    .getElementById(
                        "perguntasRespiratorias"
                    )
                    .style.display =
                        "block";
            }
            if (
                regiao === "neurologico" ||
                regiao === "cabeca"
            ) {
                document
                    .getElementById(
                        "perguntasNeurologicas"
                    )
                    .style.display =
                        "block";
            }
            if (
                regiao === "abdomen" ||
                regiao === "digestivo"
            ) {
                document
                    .getElementById(
                        "perguntasDigestivas"
                    )
                    .style.display =
                        "block";
            }
            if (
                regiao === "ossos" ||
                regiao === "articulacoes" ||
                regiao === "musculos" ||
                regiao === "costas"
            ) {
                document
                    .getElementById(
                        "perguntasOrtopedicas"
                    )
                    .style.display =
                        "block";
            }
        }
    );
/*
|--------------------------------------------------------------------------
| FORMULÁRIO
|--------------------------------------------------------------------------
*/
document
    .getElementById("formAreas")
    .addEventListener(
        "submit",
        async function (event) {
            event.preventDefault();
            const formulario =
                this;
            const botao =
                document.getElementById(
                    "btnEnviar"
                );
            botao.disabled =
                true;
            botao.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Analisando...';
            const dados =
                new FormData(
                    formulario
                );
            try {
                /*
                |--------------------------------------------------------------------------
                | ENVIA PARA API
                |--------------------------------------------------------------------------
                */
                const resposta =
                    await fetch(
                        "api_areas.php",
                        {
                            method: "POST",
                            body: dados
                        }
                    );
                /*
                |--------------------------------------------------------------------------
                | TENTA LER JSON
                |--------------------------------------------------------------------------
                */
                let resultado;
                try {
                    resultado =
                        await resposta.json();
                } catch (erroJSON) {
                    throw new Error(
                        "O servidor não retornou um JSON válido."
                    );
                }
                /*
                |--------------------------------------------------------------------------
                | ERRO HTTP
                |--------------------------------------------------------------------------
                */
                if (!resposta.ok) {
                    throw new Error(
                        resultado.mensagem ||
                        "Não foi possível realizar a análise."
                    );
                }
                /*
                |--------------------------------------------------------------------------
                | VALIDAR RESPOSTA
                |--------------------------------------------------------------------------
                */
                if (
                    !resultado.orientacao
                ) {
                    throw new Error(
                        "A resposta da API não contém os dados da orientação."
                    );
                }
                const orientacao =
                    resultado.orientacao;
                /*
                |--------------------------------------------------------------------------
                | MOSTRAR RESULTADO
                |--------------------------------------------------------------------------
                */
                const resultadoElemento =
                    document.getElementById(
                        "resultado"
                    );
                resultadoElemento.style.display =
                    "block";
                /*
                |--------------------------------------------------------------------------
                | ÁREA PRINCIPAL
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
                | DESCRIÇÃO
                |--------------------------------------------------------------------------
                */
                let descricao =
                    "Área indicada com base nas informações fornecidas.";
                if (
                    orientacao.origem ===
                    "protocolo_de_seguranca"
                ) {
                    descricao =
                        "O protocolo de segurança direcionou o atendimento para avaliação imediata.";
                }
                document
                    .getElementById(
                        "descricaoArea"
                    )
                    .textContent =
                        descricao;
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
                    ) &&
                    orientacao.motivos.length > 0
                ) {
                    orientacao
                        .motivos
                        .forEach(
                            function (motivo) {
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
                } else {
                    listaMotivos.innerHTML =
                        "<li>Não foram informados motivos específicos.</li>";
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
                    orientacao.observacao.trim() !== ""
                ) {
                    observacao.textContent =
                        orientacao.observacao;
                    observacao.style.display =
                        "block";
                } else {
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
                if (
                    Array.isArray(
                        orientacao.alertas
                    ) &&
                    orientacao.alertas.length > 0
                ) {
                    alerta.innerHTML =
                        "";
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
                            function (item) {
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
                } else {
                    alerta.style.display =
                        "none";
                }
                /*
                |--------------------------------------------------------------------------
                | STATUS DA IA
                |--------------------------------------------------------------------------
                */
                const iaStatus =
                    document.getElementById(
                        "iaStatus"
                    );
                if (
                    resultado.ia &&
                    resultado.ia.status ===
                    "analisada"
                ) {
                    iaStatus.textContent =
                        "A análise auxiliar foi utilizada.";
                } else {
                    iaStatus.textContent =
                        "A análise foi realizada pelo protocolo.";
                }
                /*
                |--------------------------------------------------------------------------
                | CONFERÊNCIA
                |--------------------------------------------------------------------------
                */
                const conferencia =
                    document.getElementById(
                        "conferencia"
                    );
                if (
                    orientacao.necessita_conferencia ===
                    true
                ) {
                    conferencia.textContent =
                        "Sim";
                } else {
                    conferencia.textContent =
                        "Recomendada";
                }
                /*
                |--------------------------------------------------------------------------
                | SCROLL
                |--------------------------------------------------------------------------
                */
                resultadoElemento
                    .scrollIntoView({
                        behavior: "smooth"
                    });
            }
            catch (erro) {
                alert(
                    "Erro ao realizar a análise:\n\n" +
                    erro.message
                );
            }
            finally {
                botao.disabled =
                    false;
                botao.innerHTML =
                    '<i class="fas fa-search"></i> Identificar área';
            }
        }
    );
</script>
</body>
</html>

