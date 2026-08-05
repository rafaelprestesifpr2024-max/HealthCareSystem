<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema de Triagem</title>

    <link href="css/styles.css" rel="stylesheet">

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>

        body{
            background:linear-gradient(135deg,#0d6efd,#0b5ed7);
            min-height:100vh;
        }

        .card-home{
            border:none;
            border-radius:20px;
            box-shadow:0 20px 50px rgba(0,0,0,.2);
        }

        .btn-home{
            padding:14px;
            font-size:18px;
            border-radius:12px;
        }

        .icon-circle{
            width:110px;
            height:110px;
            border-radius:50%;
            background:#0d6efd;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            margin-bottom:25px;
        }

        footer{
            color:#777;
            font-size:14px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center align-items-center" style="min-height:100vh;">

        <div class="col-lg-5">

            <div class="card card-home">

                <div class="card-body p-5">

                    <div class="icon-circle">

                        <i class="fas fa-hospital-user fa-3x"></i>

                    </div>

                    <h2 class="text-center fw-bold">

                        Sistema de Triagem

                    </h2>

                    <p class="text-center text-muted mb-5">

                        Controle de pacientes e classificação de risco.

                    </p>

                    <div class="d-grid gap-3">

                        <a href="login.php" class="btn btn-primary btn-home">

                            <i class="fas fa-right-to-bracket me-2"></i>

                            Entrar

                        </a>

                        <a href="cadastro.php" class="btn btn-outline-primary btn-home">

                            <i class="fas fa-user-plus me-2"></i>

                            Criar Conta

                        </a>

                    </div>

                    <div class="text-center mt-4">

                        <a href="password.php" class="text-decoration-none">

                            Esqueceu sua senha?

                        </a>

                    </div>

                </div>

            </div>

            <footer class="text-center mt-4 text-white">

                © 2026 Sistema de Triagem Hospitalar

            </footer>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>