<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "INSERT INTO pacientes
            (
                nome,
                data_nascimento,
                data_triagem,
                hora_triagem,
                queixa_principal,
                sintomas,
                historico,
                medicamentos,
                alergias,
                pressao,
                temperatura,
                frequencia,
                saturacao,
                dor,
                risco
            )
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssssssssssis",
        $_POST['nome'],
        $_POST['data_nascimento'],
        $_POST['data_triagem'],
        $_POST['hora_triagem'],
        $_POST['queixa_principal'],
        $_POST['sintomas'],
        $_POST['historico'],
        $_POST['medicamentos'],
        $_POST['alergias'],
        $_POST['pressao'],
        $_POST['temperatura'],
        $_POST['frequencia'],
        $_POST['saturacao'],
        $_POST['dor'],
        $_POST['risco']
    );

    if ($stmt->execute()) {
        echo "<script>alert('Triagem registrada com sucesso!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triagem Hospitalar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

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
        .btn-risk {
            height: 100px;
            font-size: 18px;
            border-radius: 15px;
        }
        .titulo {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="titulo">
                <i class="fas fa-hospital text-danger"></i> Sistema de Triagem
            </h1>
            <p class="text-muted">Cadastro e classificação inicial do paciente</p>
        </div>

        <form method="POST">

            <!-- Identificação -->
            <div class="card shadow mb-4">
                <div class="card-header bg-dark text-white">
                    <h5><i class="fas fa-user-injured"></i> Identificação do Paciente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input class="form-control" name="nome" placeholder="Nome" required>
                                <label>Nome completo</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="data_nascimento">
                                <label>Nascimento</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="data_triagem" value="<?=date('Y-m-d')?>">
                                <label>Data da triagem</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating">
                        <input type="time" class="form-control" name="hora_triagem" value="<?=date('H:i')?>">
                        <label>Hora do atendimento</label>
                    </div>
                </div>
            </div>

            <!-- Motivo -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-notes-medical"></i> Motivo do Atendimento</h5>
                </div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="queixa_principal" style="height:100px"></textarea>
                        <label>Queixa principal</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="sintomas" style="height:120px"></textarea>
                        <label>Sintomas relatados</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="historico" style="height:100px"></textarea>
                        <label>Histórico clínico</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input class="form-control" name="medicamentos">
                                <label>Medicamentos em uso</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control" name="alergias">
                                <label>Alergias</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sinais Vitais -->
            <div class="card shadow mb-4">
                <div class="card-header bg-danger text-white">
                    <h5><i class="fas fa-heartbeat"></i> Sinais Vitais</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label>Pressão arterial</label>
                            <input class="form-control" name="pressao" placeholder="120x80">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Temperatura</label>
                            <input class="form-control" name="temperatura" placeholder="36,5°C">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Frequência cardíaca</label>
                            <input class="form-control" name="frequencia" placeholder="80 bpm">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Saturação O²</label>
                            <input class="form-control" name="saturacao" placeholder="98%">
                        </div>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="number" min="0" max="10" class="form-control" name="dor">
                        <label>Escala de dor (0 - 10)</label>
                    </div>
                </div>
            </div>

            <!-- Risco -->
            <div class="card shadow mb-4">
                <div class="card-header bg-warning">
                    <h5><i class="fas fa-exclamation-triangle"></i> Classificação de Risco</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input class="btn-check" type="radio" name="risco" id="azul" value="Azul">
                            <label class="btn btn-outline-primary btn-risk w-100" for="azul">
                                🔵 Azul <br><small>Não urgente</small>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input class="btn-check" type="radio" name="risco" id="verde" value="Verde">
                            <label class="btn btn-outline-success btn-risk w-100" for="verde">
                                🟢 Verde <br><small>Pouco urgente</small>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input class="btn-check" type="radio" name="risco" id="amarelo" value="Amarelo">
                            <label class="btn btn-outline-warning btn-risk w-100" for="amarelo">
                                🟡 Amarelo <br><small>Urgente</small>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="btn-check" type="radio" name="risco" id="laranja" value="Laranja">
                            <label class="btn btn-outline-secondary btn-risk w-100" for="laranja">
                                🟠 Laranja <br><small>Muito urgente</small>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input class="btn-check" type="radio" name="risco" id="vermelho" value="Vermelho">
                            <label class="btn btn-outline-danger btn-risk w-100" for="vermelho">
                                🔴 Vermelho <br><small>Emergência</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botão -->
            <!-- Botões -->
            <div class="d-flex justify-content-end gap-3 mb-5">
                <button class="btn btn-dark btn-lg px-5">
                    <i class="fas fa-save"></i> Registrar Triagem
                </button>
                <button type="button" 
                        class="btn btn-dark btn-lg px-5" 
                        onclick="window.location.href='home.php'">
                    <i class="fas fa-home"></i> Retornar à home page
                </button>
            </div>

        </form>
    </div>
</body>
</html>
