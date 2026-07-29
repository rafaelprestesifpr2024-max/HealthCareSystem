<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Cadastro - SB Admin</title>

    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">

                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Criar Conta</h3>
                            </div>

                            <div class="card-body">
                                <form action="register.php" method="POST">

                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               id="inputFullName"
                                               name="fullname"
                                               type="text"
                                               placeholder="Digite seu nome"
                                               required>
                                        <label for="inputFullName">Nome Completo</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               id="inputEmail"
                                               name="email"
                                               type="email"
                                               placeholder="nome@exemplo.com"
                                               required>
                                        <label for="inputEmail">E-mail</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               id="inputPassword"
                                               name="password"
                                               type="password"
                                               placeholder="Crie uma senha"
                                               required>
                                        <label for="inputPassword">Senha</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               id="inputPasswordConfirm"
                                               name="confirm_password"
                                               type="password"
                                               placeholder="Confirme sua senha"
                                               required>
                                        <label for="inputPasswordConfirm">Confirmar Senha</label>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark">
                                            Criar Conta
                                        </button>
                                    </div>

                                </form>
                            </div>

                            <div class="card-footer text-center py-3">
                                <div class="small">
                                    <a href="login.php">Já possui uma conta? Faça login</a>
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
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">
                        Copyright &copy; Seu Site 2026
                    </div>

                    <div>
                        <a href="#">Política de Privacidade</a>
                        &middot;
                        <a href="#">Termos e Condições</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>

</body>
</html>