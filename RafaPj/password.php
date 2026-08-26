<?php

session_start();

require_once "conexao.php";

$mensagem = "";
$tipoMensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = strtolower(trim($_POST["email"] ?? ""));


    /*
    |--------------------------------------------------------------------------
    | VALIDAÇÃO
    |--------------------------------------------------------------------------
    */

    if ($email === "") {

        $mensagem = "Informe seu e-mail.";
        $tipoMensagem = "danger";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $mensagem = "Informe um e-mail válido.";
        $tipoMensagem = "danger";

    } else {

        /*
        |--------------------------------------------------------------------------
        | VERIFICAR SE O USUÁRIO EXISTE
        |--------------------------------------------------------------------------
        */

        $sql = "SELECT id, nome, email FROM usuarios WHERE email = ? LIMIT 1";

        $stmt = $conn->prepare($sql);


        if (!$stmt) {

            $mensagem =
                "Erro ao consultar o banco de dados.";

            $tipoMensagem = "danger";

        } else {

            $stmt->bind_param(
                "s",
                $email
            );

            $stmt->execute();

            $resultado =
                $stmt->get_result();


            if ($resultado->num_rows === 1) {

                $usuario =
                    $resultado->fetch_assoc();


                /*
                |--------------------------------------------------------------------------
                | GERAR TOKEN
                |--------------------------------------------------------------------------
                */

                $token =
                    bin2hex(
                        random_bytes(32)
                    );


                /*
                |--------------------------------------------------------------------------
                | VALIDADE DO TOKEN
                | 1 hora
                |--------------------------------------------------------------------------
                */

                $expira_em =
                    date(
                        "Y-m-d H:i:s",
                        time() + 3600
                    );


                /*
                |--------------------------------------------------------------------------
                | SALVAR TOKEN
                |--------------------------------------------------------------------------
                */

                /*
                 * IMPORTANTE:
                 *
                 * Esta parte pressupõe que sua tabela
                 * usuarios possui:
                 *
                 * token_recuperacao
                 * token_recuperacao_expira
                 *
                 */


                $sqlToken = "
                    UPDATE usuarios
                    SET
                        token_recuperacao = ?,
                        token_recuperacao_expira = ?
                    WHERE id = ?
                ";


                $stmtToken =
                    $conn->prepare(
                        $sqlToken
                    );


                if (!$stmtToken) {

                    $mensagem =
                        "Erro ao preparar a recuperação de senha.";

                    $tipoMensagem = "danger";

                } else {

                    $stmtToken->bind_param(
                        "ssi",
                        $token,
                        $expira_em,
                        $usuario["id"]
                    );


                    if ($stmtToken->execute()) {


                        /*
                        |--------------------------------------------------------------------------
                        | LINK DE RECUPERAÇÃO
                        |--------------------------------------------------------------------------
                        */

                        $link =
                            "http://" .
                            $_SERVER["HTTP_HOST"] .
                            dirname($_SERVER["PHP_SELF"]) .
                            "/nova_senha.php?token=" .
                            urlencode($token);


                        /*
                        |--------------------------------------------------------------------------
                        | MENSAGEM
                        |--------------------------------------------------------------------------
                        */

                        /*
                         * Aqui você pode futuramente
                         * enviar o link por e-mail.
                         *
                         * Durante o desenvolvimento,
                         * vamos mostrar o link na tela.
                         */


                        $mensagem = "
                            Um link de recuperação foi gerado.
                            <br><br>
                            <strong>Link para redefinir a senha:</strong>
                            <br>
                            <a
                                href='" . htmlspecialchars($link) . "'
                                class='alert-link'
                            >
                                " . htmlspecialchars($link) . "
                            </a>
                            <br><br>
                            Este link será válido por 1 hora.
                        ";

                        $tipoMensagem = "success";

                    } else {

                        $mensagem =
                            "Não foi possível gerar o link de recuperação.";

                        $tipoMensagem = "danger";

                    }


                    $stmtToken->close();

                }

            } else {

                /*
                 * Por segurança, em um sistema real é melhor
                 * não informar se o e-mail existe ou não.
                 */

                $mensagem = "
                    Se o e-mail estiver cadastrado,
                    as instruções para recuperação serão
                    disponibilizadas.
                ";

                $tipoMensagem = "info";

            }


            $stmt->close();

        }

    }

}

$conn->close();

?>


<!DOCTYPE html>

<html lang="pt-BR">


<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Recuperar Senha - HealthSystem
    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        href="https://use.fontawesome.com/releases/v6.3.0/css/all.css"
        rel="stylesheet"
    >


    <style>


        body {

            min-height: 100vh;

            margin: 0;

            background:
                linear-gradient(
                    135deg,
                    #0d47a1,
                    #1976d2,
                    #42a5f5
                );

            font-family:
                Arial,
                Helvetica,
                sans-serif;

        }


        .pagina {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 15px;

        }


        .card-recuperacao {

            width: 100%;

            max-width: 480px;

            border: none;

            border-radius: 22px;

            overflow: hidden;

            background: #ffffff;

            box-shadow:
                0 20px 50px
                rgba(0, 0, 0, 0.20);

        }


        /*
        |--------------------------------------------------------------------------
        | CABEÇALHO
        |--------------------------------------------------------------------------
        */

        .cabecalho {

            background:
                linear-gradient(
                    135deg,
                    #0d6efd,
                    #0b5ed7
                );

            color: white;

            text-align: center;

            padding: 35px 25px;

        }


        .icone {

            width: 75px;

            height: 75px;

            margin: 0 auto 15px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.15);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 32px;

        }


        .cabecalho h1 {

            font-size: 27px;

            font-weight: 700;

            margin-bottom: 8px;

        }


        .cabecalho p {

            margin: 0;

            opacity: 0.9;

            font-size: 14px;

        }


        /*
        |--------------------------------------------------------------------------
        | CORPO
        |--------------------------------------------------------------------------
        */

        .card-body {

            padding: 30px;

        }


        .descricao {

            color: #6c757d;

            font-size: 14px;

            line-height: 1.6;

            margin-bottom: 25px;

        }


        /*
        |--------------------------------------------------------------------------
        | INPUT
        |--------------------------------------------------------------------------
        */

        .form-floating {

            margin-bottom: 18px;

        }


        .form-control {

            border-radius: 11px;

            border:
                1px solid #d9dee7;

        }


        .form-control:focus {

            border-color:
                #0d6efd;

            box-shadow:
                0 0 0 .20rem
                rgba(13,110,253,.15);

        }


        /*
        |--------------------------------------------------------------------------
        | BOTÃO
        |--------------------------------------------------------------------------
        */

        .btn-recuperar {

            width: 100%;

            border: none;

            border-radius: 11px;

            padding: 12px;

            font-weight: 600;

            background:
                linear-gradient(
                    135deg,
                    #0d6efd,
                    #0b5ed7
                );

        }


        .btn-recuperar:hover {

            background:
                linear-gradient(
                    135deg,
                    #0b5ed7,
                    #084298
                );

        }


        /*
        |--------------------------------------------------------------------------
        | LINKS
        |--------------------------------------------------------------------------
        */

        .link-login {

            color: #0d6efd;

            text-decoration: none;

            font-weight: 500;

        }


        .link-login:hover {

            text-decoration: underline;

        }


        /*
        |--------------------------------------------------------------------------
        | RODAPÉ
        |--------------------------------------------------------------------------
        */

        .card-footer {

            background: #f8f9fa;

            border-top:
                1px solid #eeeeee;

            text-align: center;

            padding: 20px;

        }


        .card-footer a {

            text-decoration: none;

            color: #0d6efd;

        }


        /*
        |--------------------------------------------------------------------------
        | ALERTAS
        |--------------------------------------------------------------------------
        */

        .alert {

            border-radius: 12px;

            font-size: 14px;

        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 576px) {

            .card-body {

                padding: 25px 20px;

            }

            .cabecalho {

                padding: 30px 20px;

            }

        }

    </style>

</head>


<body>


<div class="pagina">


    <div class="card-recuperacao">


        <!-- CABEÇALHO -->

        <div class="cabecalho">


            <div class="icone">

                <i class="fas fa-key"></i>

            </div>


            <h1>

                Recuperar Senha

            </h1>


            <p>

                HealthSystem

            </p>


        </div>


        <!-- CORPO -->

        <div class="card-body">


            <div class="descricao">

                <i class="fas fa-circle-info text-primary me-1"></i>

                Informe o e-mail utilizado no cadastro.
                Vamos gerar as instruções para você
                redefinir sua senha.

            </div>


            <!-- MENSAGEM -->

            <?php if (!empty($mensagem)): ?>

                <div
                    class="alert alert-<?= htmlspecialchars($tipoMensagem) ?>"
                >

                    <?= $mensagem ?>

                </div>

            <?php endif; ?>


            <!-- FORMULÁRIO -->

            <form
                method="POST"
                action=""
            >


                <div class="form-floating">


                    <input
                        class="form-control"
                        id="inputEmail"
                        name="email"
                        type="email"
                        placeholder="nome@email.com"
                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                        required
                    >


                    <label for="inputEmail">

                        <i class="fas fa-envelope me-1"></i>

                        E-mail

                    </label>


                </div>


                <button
                    type="submit"
                    class="btn btn-primary btn-recuperar"
                >

                    <i class="fas fa-paper-plane me-2"></i>

                    Recuperar senha

                </button>


            </form>


            <!-- VOLTAR -->

            <div class="text-center mt-4">


                <a
                    href="login.php"
                    class="link-login"
                >

                    <i class="fas fa-arrow-left me-1"></i>

                    Voltar para o login

                </a>


            </div>


        </div>


        <!-- RODAPÉ -->

        <div class="card-footer">


            <div class="small">

                Ainda não possui uma conta?

                <a href="cadastro.php">

                    Cadastre-se

                </a>

            </div>


            <div class="small mt-2 text-muted">

                <i class="fas fa-shield-halved me-1"></i>

                Seus dados são tratados com segurança.

            </div>


        </div>


    </div>


</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>