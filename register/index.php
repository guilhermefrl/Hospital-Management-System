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
}else{  //Mostar a página de registo

}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registar</title>
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
                    <div class="form-row">
                        <div class="text-center mt-5">
                            <a href="/projeto/login/" id="back_button">
                                <i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 1.8em;"></i>
                            </a>
                        </div>
                        <h4 class="title text-center mt-5" style="margin-left: auto; margin-right: auto;">
                            Registar
                        </h4>
                    </div>
                    
                    <form action="insert.php" method="POST">
                        <!-- Mensagem de erro -->
                        <?php if(isset($_GET['error'])){ ?>
                            <p class="error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><?php echo $_GET['error']; ?></p>
                        <?php } ?>

                        <!-- Mensagem de sucesso -->
                        <?php if (isset($_GET['success'])) { ?>
                            <p class="success"><i class="fa fa-check" aria-hidden="true"></i><?php echo $_GET['success']; ?></p>
                        <?php } ?>

                        <div class="form-row">
                            <!-- Campo obrigatório para inserir o nome completo -->
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: bold;">Nome Completo</label>
                                <input type="text" class="form-control" name="u_nome_c" required>
                            </div>

                            <!-- Campo obrigatório para inserir o email -->
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: bold;">Email</label>
                                <input type="email" class="form-control" name="u_email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Campo obrigatório para inserir o endereço -->
                            <div class="col-md-7 mb-3">
                                <label style="font-weight: bold;">Endereço</label>
                                <input type="text" class="form-control" name="u_endereco" required>
                            </div>

                            <!-- Campo obrigatório para inserir a data de nascimento -->
                            <div class="col-md-5 mb-3">
                                <label style="font-weight: bold;">Data de nascimento</label>
                                <input type="date" class="form-control" name="u_data_nascimento" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Campo obrigatório para inserir o código postal -->
                            <div class="col-md-4 mb-3">
                                <label style="font-weight: bold;">Código Postal</label>
                                <input type="number" class="form-control" name="u_CP4" minlength="4" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label id="disable-select">.</label>
                                <input type="number" class="form-control" name="u_CP3" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Campo obrigatório para inserir o telemóvel -->
                            <div class="col-md-4 mb-3">
                                <label style="font-weight: bold;">Telemóvel</label>
                                <input type="number" class="form-control" name="u_telemovel" required>
                            </div>

                            <!-- Campo para selecionar o género -->
                            <div class="col-md-4 mb-3">
                                <label for="u_genero" style="font-weight: bold;">Género</label>
                                <select name="u_genero" class="form-control">
                                    <option value="m">Masculino</option>
                                    <option value="f">Feminino</option>
                                </select>
                            </div>

                            <!-- Campo para selecionar o grupo sanguíneo -->
                            <div class="col-md-4 mb-3">
                                <label for="u_grupo_sanguineo" style="font-weight: bold;">Grupo sanguíneo</label>
                                <select name="u_grupo_sanguineo" class="form-control">
                                    <option value="ABM">AB+</option>
                                    <option value="ABm">AB−</option>
                                    <option value="BM">B+</option>
                                    <option value="Bm">B−</option>
                                    <option value="AM">A+</option>
                                    <option value="Am">A−</option>
                                    <option value="OM">O+</option>
                                    <option value="Om">O−</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Campo obrigatório para inserir o nome de utilizador -->
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: bold;">Nome de utilizador</label>
                                <input type="text" class="form-control" name="u_nome" required>
                            </div>

                            <!-- Campo obrigatório para inserir a palavra-passe -->
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: bold;">Palavra-passe</label>
                                <input type="password" class="form-control" name="u_pass" required>
                            </div>
                        </div>
                        </br>
                        <div class="form-row">
                            <button class="btn btn-primary btn_1" name="registar" type="submit">Registar</button>
                            <div id="spinner" style="margin-left: 4%; display:none;">
                                <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    $(document).ready( function(){
        $('.btn_1').on('click', function(){     //Caso o botão para registar seja clicado
            $('form').submit(function(e) {
                $("#spinner").show();           //Mostrar o spinner
            });
        });
    });    
</script>