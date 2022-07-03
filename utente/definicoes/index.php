<?php 
session_start();

if (isset($_SESSION['ID_UTENTE'])) {        //Caso o utente tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    $id=$_SESSION['ID_UTILIZADOR'];

    //Query para ir buscar os dados do utente
    $sql = "SELECT utilizador.NOME_COMPLETO, utilizador.EMAIL, utilizador.USERNAME, utente.TELEMOVEL, utente.DATA_NASCIMENTO, utente.ENDERECO, utente.CP4, utente.CP3 FROM utilizador, utente WHERE utilizador.ID_UTILIZADOR=$id AND utilizador.ID_UTILIZADOR=utente.ID_UTILIZADOR";
    $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
    $row = mysqli_fetch_assoc($result);         //Guardar na variável um array que corresponde aos dados da linha do resultado da query

    //Guardar os dados resultantes da query
    $NOME_COMPLETO = $row['NOME_COMPLETO'];
    $EMAIL = $row['EMAIL'];
    $USERNAME = $row['USERNAME'];
    $TELEMOVEL = $row['TELEMOVEL'];
    $DATA_NASCIMENTO = $row['DATA_NASCIMENTO'];
    $ENDERECO = $row['ENDERECO'];
    $CP4 = $row['CP4'];
    $CP3 = $row['CP3'];

 ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Utente</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/projeto/css/user/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">
        <link rel='shortcut icon' type='image/x-icon' href='/projeto/icon/ico.ico'/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    </head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <body id="body">
        <!--------------------------------------------------------
        // Navbar
        --------------------------------------------------------->

        <nav class="navbar navbar-expand-lg navbar" id="nav-bar">
            <a class="navbar-brand" id="nav-text" style="font-weight: bold;">Utente</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/projeto/utente/" id="nav-text"><i class="fa fa-home" aria-hidden="true"></i> Início<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="nav-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-calendar-o" aria-hidden="true"></i> Consultas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/projeto/utente/consultas/">Marcar Consultas</a>
                        <a class="dropdown-item" href="/projeto/utente/consultas/cancelar_consultas.php">Cancelar Consultas</a>
                        <a class="dropdown-item" href="/projeto/utente/consultas/historico_consultas.php">Histórico de Consultas</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/utente/historico/" id="nav-text"><i class="fa fa-book" aria-hidden="true"></i> Histórico Hospitalar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/utente/estatisticas/" id="nav-text"><i class="fa fa-bar-chart" aria-hidden="true"></i> Estatísticas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/utente/definicoes/" id="nav-text"><i class="fa fa-cog" aria-hidden="true"></i> Definições</a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <a class="nav-link" href="/projeto/logout/logout.php" id="nav-text"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                </div>                
            </div>
        </nav>

        <!--------------------------------------------------------
        // Pop-Up de aviso para eliminar a conta
        --------------------------------------------------------->

        <div class="modal fade" id="modal_eliminar_utilizador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">			
                        <h4 class="modal-title">Tem a certeza?</h4>	
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>    
                        </button>
                    </div>
                    <form action="eliminar.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="ID_REMOVER" id="ID_REMOVER">
                            <h5 class="modal-title" style="text-align: center;">
                                <div style="color: #dc3545; font-size: 120px;">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </diV>
                                A sua conta vai ser eliminada!
                            </h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                            <input type="hidden" name="id" value="<?php echo ''.$_SESSION['ID_UTILIZADOR'].'';?>">
                            <button type="submit" name="eliminar_utilizador" class="btn btn-danger">Sim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------------------------------------------------------
        // Pop-Up de erro
        --------------------------------------------------------->
        <?php if (isset($_GET['error'])) { ?>
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" style="text-align: center;">
                                <div style="color: #dc3545; font-size: 120px;">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </diV>
                                Erro!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!------------------------------------------------------------------
        // Pop-Up a informar que a palavra-passe foi alterada com sucesso
        ------------------------------------------------------------------->
        <?php if (isset($_GET['success'])) { ?>
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" style="text-align: center;">
                                <div style="color: #28a745; font-size: 120px;">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                </diV>
                                Palavra-passe alterada com sucesso!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!---------------------------------------------------------------
        // Pop-Up a informar que os dados foram alterados com sucesso
        ---------------------------------------------------------------->
        <?php if (isset($_GET['success1'])) { ?>
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" style="text-align: center;">
                                <div style="color: #28a745; font-size: 120px;">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                </diV>
                                Dados alterados com sucesso!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!----------------------------------------------------------
        // Pop-Up a informar que a palavra-passe atual está errada
        ----------------------------------------------------------->
        <?php if (isset($_GET['error1'])) { ?>
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" style="text-align: center;">
                                <div style="color: #dc3545; font-size: 120px;">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </diV>
                                Palavra-passe atual errada!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!----------------------------------------------------------
        // Pop-Up a informar que as palavras-passe não são iguais
        ----------------------------------------------------------->
        <?php if (isset($_GET['error2'])) { ?>
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" style="text-align: center;">
                                <div style="color: #dc3545; font-size: 120px;">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </diV>
                                As Palavras-passe não são iguais!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-----------------------------------------------------------------
        // Pop-Up a informar que já existe o nome de utilizador ou email
        ------------------------------------------------------------------>
        <?php if (isset($_GET['error3'])) { ?>
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" style="text-align: center;">
                                <div style="color: #dc3545; font-size: 120px;">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </diV>
                                Já existe este nome de utilizador ou email!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!--------------------------------------------------------
        // Definições
        --------------------------------------------------------->

        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            
            <h4><i class="fa fa-cog" aria-hidden="true"></i> Definições</h4>
            <hr class="my-4">

            <form action="alterar_dados.php" method="POST">
                <div class="form-row">
                    <div style="margin-left: 1.8%;">
                        <div class="form-row">
                            <h5>Alterar Dados</h5>
                        </div>
                    </div>

                    <div style="margin-left: 15%; margin-top: 1%; width: 80%;">
                        <div class="form-row">
                            <!-- Campo para alterar o nome -->
                            <div class="col-md-6 mb-3">
                                <label>Nome Completo</label>
                                <input type="text" class="form-control" name="nome_completo" value="<?php echo $NOME_COMPLETO;?>" required>
                            </div>
                            <!-- Campo para alterar o email -->
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $EMAIL;?>" required>
                            </div>
                        </div>
                    </div>

                    <div style="margin-left: 15%; margin-top: 1%; width: 80%;">
                        <div class="form-row">
                            <!-- Campo para alterar o nome de utilizador -->
                            <div class="col-md-6 mb-3">
                                <label>Nome de utilizador</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $USERNAME;?>" required>
                            </div>
                            <!-- Campo para alterar o telemóvel -->
                            <div class="col-md-3 mb-3">
                                <label>Telemóvel</label>
                                <input type="number" class="form-control" name="telemovel" value="<?php echo $TELEMOVEL;?>" required>
                            </div>
                            <!-- Campo para alterar a data de nascimento -->
                            <div class="col-md-3 mb-3">
                                <label>Data de nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" value="<?php echo $DATA_NASCIMENTO; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div style="margin-left: 15%; margin-top: 1%; width: 80%;">
                        <div class="form-row">
                            <!-- Campo para alterar o endereço -->
                            <div class="col-md-7 mb-3">
                                <label>Endereço</label>
                                <input type="text" class="form-control" name="endereco" value="<?php echo $ENDERECO;?>" required>
                            </div>
                            <!-- Campo para alterar o código postal -->
                            <div class="col-md-3 mb-3">
                                <label>Código Postal</label>
                                <input type="number" class="form-control" name="cp4" value="<?php echo $CP4;?>" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label id="disable-select1">.</label>
                                <input type="number" class="form-control" name="cp3" value="<?php echo $CP3;?>" required>
                            </div>
                        </div>
                    </div>

                    <div style="margin-left: 88%; margin-top: 1%; width: 80%;">
                        <button type="submit" name="alterar_dados" class="btn btn-success">Alterar</button>
                    </div>
                </div>
            </form>
            <hr class="my-4">
            <form action="alterar_password.php" method="POST">
                <div class="form-row">
                    <div style="margin-left: 1.8%;">
                        <div class="form-row">
                            <h5>Alterar Palavra-passe</h5>
                        </div>
                    </div>
                    <div style="margin-left: 30%; margin-top: 1%; width: 80%;">
                        <div class="form-row">
                            <!-- Campo obrigatório para inserir a palavra-passe atual -->
                            <div class="col-md-11 mb-3">
                                <label>Palavra-passe atual</label>
                                <input type="password" class="form-control" name="pass_atual" required>
                            </div>
                        </div>
                    </div>
                    <div style="margin-left: 30%; margin-top: 1%; width: 80%;">
                        <div class="form-row">
                            <!-- Campo obrigatório para inserir a nova palavra-passe -->
                            <div class="col-md-11 mb-3">
                                <label>Palavra-passe nova</label>
                                <input type="password" class="form-control" name="pass_nova" required>
                            </div>
                        </div>
                    </div>
                    <div style="margin-left: 30%; margin-top: 1%; width: 80%;">
                        <div class="form-row">
                            <!-- Campo obrigatório para confirmar a nova palavra-passe -->
                            <div class="col-md-11 mb-3">
                                <label>Confirmar Palavra-passe</label>
                                <input type="password" class="form-control" name="pass_confirmacao" required>
                            </div>
                        </div>
                    </div>

                    <div style="margin-left: 87%; margin-top: 1%; width: 80%;">
                        <button type="submit" name="mudar_password" class="btn btn-success">Alterar</button>
                    </div>
                </div>
            </form>
            <hr class="my-4">
            <div class="form-row">
                <div style="margin-left: 1.8%;">
                    <div class="form-row">
                        <h5>Eliminar Conta</h5>
                    </div>
                </div>

                <div style="margin-left: 82%; margin-top: 4%; width: 80%;">
                    <!-- Botão para eliminar a conta -->
                    <button type="button" class="btn btn-danger eliminar_btn">Eliminar Conta</button>
                </div>
            </div>
        </section>

    </body>
</html>

<script>
$('.eliminar_btn').on('click', function(){          //Caso o utente tenha clicado no botão para eliminar a conta
    $('#modal_eliminar_utilizador').modal('show');  //Mostrar o pop-up de aviso
});

$("#myModal").on('hidden.bs.modal', function () {       //Caso o pop-up seja fechado
        window.location.href = '/projeto/utente/definicoes/';       //Atualizar a página
    });
    
    $(window).on('load',function(){
        $('#myModal').modal('show');    //Mostrar pop-up(s)
    });
</script>

<?php 
}else{      //Caso o utilizador não tenha feito login 
    header("Location: /projeto/login/");        //Redirecionar o utilizador para a página de login
    exit();
}
 ?>