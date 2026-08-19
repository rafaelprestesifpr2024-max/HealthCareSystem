<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>Recuperar Senha - Sistema</title>

    <link href="css/styles.css" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>


<body class="bg-dark">


<div id="layoutAuthentication">


    <div id="layoutAuthentication_content">


        <main>


            <div class="container">


                <div class="row justify-content-center">


                    <div class="col-lg-5">


                        <div class="card shadow-lg border-0 rounded-lg mt-5">


                            <div class="card-header">

                                <h3 class="text-center font-weight-light my-4">
                                    Recuperar Senha
                                </h3>

                            </div>




                            <div class="card-body">


                                <div class="small mb-3 text-muted">

                                    Informe seu e-mail e enviaremos as instruções para redefinir sua senha.

                                </div>




                                <form action="recuperar_senha.php" method="POST">



                                    <div class="form-floating mb-3">


                                        <input class="form-control"
                                               id="inputEmail"
                                               name="email"
                                               type="email"
                                               placeholder="nome@email.com"
                                               required>


                                        <label for="inputEmail">
                                            E-mail
                                        </label>


                                    </div>





                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">


                                        <a class="small" href="login.php">
                                            Voltar para o login
                                        </a>




                                        <button type="submit" class="btn btn-dark">

                                            Recuperar Senha

                                        </button>



                                    </div>



                                </form>



                            </div>





                            <div class="card-footer text-center py-3">


                                <div class="small">


                                    <a href="register.php">

                                        Não possui uma conta? Cadastre-se!

                                    </a>


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