<?php 
session_start();

if (isset($_SESSION['ID_UTILIZADOR'])) {        //Caso o utilizador tenha feito login
    if (isset($_SESSION['ID_UTENTE'])){         //Caso o utilizador seja do tipo utente
        header("Location: /projeto/utente/");   //Redirecionar o utilizador para a visão do utente
        exit();
    }

    if (isset($_SESSION['ID_MEDICO'])){         //Caso o utilizador seja do tipo médico
        header("Location: /projeto/medico/");   //Redirecionar o utilizador para a visão do médico
        exit();
    }

    if (isset($_SESSION['ID_UTENTE']) === FALSE && isset($_SESSION['ID_MEDICO']) === FALSE){    //Caso o utilizador seja do tipo administrador
        header("Location: /projeto/admin/");        //Redirecionar o utilizador para a visão do administrador
        exit();
    }    
 ?>

<?php 
}else{  //Mostar a página de login

}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/projeto/css/login_register/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <link rel='shortcut icon' type='image/x-icon' href='/projeto/icon/ico.ico'/>
    </head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <boby>
        <div class="container">
            <div class="col card">
                <div class="card-body">
                    <h4 class="title text-center mt-5">
                        Fazer Login
                    </h4>
                    
                    <!-- Escolher o tipo de utilizador -->
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-toggle="pill" href="#login-utente" role="tab" aria-selected="true">Utente</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-toggle="pill" href="#login-medico" role="tab" aria-selected="false">Médico</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-toggle="pill" href="#login-admin" role="tab" aria-selected="false">Admin</a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <!-- Login para os utentes -->
                        <div class="tab-pane fade show active" id="login-utente" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form action="login_utente.php" method="POST">
                                <!-- Mensagem de erro -->
                                <?php if(isset($_GET['error'])){ ?>
                                    <p class="error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><?php echo $_GET['error']; ?></p>
                                <?php } ?>

                                <!-- Campo obrigatório para inserir o nome de utilizador -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label style="font-weight: bold;">Nome de utilizador</label>
                                        <input type="text" class="form-control" name="u_nome" required>
                                    </div>
                                </div>
                                <!-- Campo obrigatório para inserir a palavra-passe -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label style="font-weight: bold;">Palavra-passe</label>
                                        <input type="password" class="form-control" name="u_pass" required>
                                    </div>
                                </div>
                                </br>
                                <button class="btn btn-primary" name="login_utente" type="submit">Login</button>
                            </form>

                            <hr class="my-4">
                            
                            <!-- Link para a página de registo de utentes -->
                            <div class="text-center mb-2">
                                Ainda não tem conta?
                                <a href="/projeto/register" class="register-link">
                                    Registe-se
                                </a>
                            </div>
                        </div>

                        <!-- Login para os médicos -->
                        <div class="tab-pane fade" id="login-medico" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <form action="login_medico.php" method="POST">
                                <!-- Mensagem de erro -->
                                <?php if(isset($_GET['error1'])){ ?>
                                    <p class="error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><?php echo $_GET['error1']; ?></p>
                                <?php } ?>

                                <!-- Campo obrigatório para inserir o nome de utilizador -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label style="font-weight: bold;">Nome de utilizador</label>
                                        <input type="text" class="form-control" name="m_nome" required>
                                    </div>
                                </div>
                                <!-- Campo obrigatório para inserir a palavra-passe -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label style="font-weight: bold;">Palavra-passe</label>
                                        <input type="password" class="form-control" name="m_pass" required>
                                    </div>
                                </div>
                                </br>
                                <button class="btn btn-primary" name="login_medico" type="submit">Login</button>
                            </form>
                        </div>
                        
                        <!-- Login para os administradores -->
                        <div class="tab-pane fade" id="login-admin" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <form action="login_admin.php" method="POST">
                                <!-- Mensagem de erro -->
                                <?php if(isset($_GET['error2'])){ ?>
                                    <p class="error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><?php echo $_GET['error2']; ?></p>
                                <?php } ?>

                                <!-- Campo obrigatório para inserir o nome de utilizador -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label style="font-weight: bold;">Nome de utilizador</label>
                                        <input type="text" class="form-control" name="a_nome" required>
                                    </div>
                                </div>
                                <!-- Campo obrigatório para inserir a palavra-passe -->
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label style="font-weight: bold;">Palavra-passe</label>
                                        <input type="password" class="form-control" name="a_pass" required>
                                    </div>
                                </div>
                                </br>
                                <button class="btn btn-primary" name="login_admin" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>