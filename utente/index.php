<?php 
session_start();

if (isset($_SESSION['ID_UTENTE'])) {        //Caso o utente tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    $ID=$_SESSION['ID_UTENTE'];

    //Query para encontrar o distrito do utente
    $sql = "SELECT DISTINCT distritos.DESIGNACAO FROM distritos, todos_cp, utente WHERE utente.ID_UTENTE=$ID AND (utente.CP4=todos_cp.CP4 AND utente.CP3=todos_cp.CP3) AND todos_cp.CODIGO_DISTRITO=distritos.CODIGO_DISTRITO";
    $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
    $row = mysqli_fetch_array($result);     //Guardar na variável um array que corresponde aos dados da linha do resultado da query

    //Queries para contar o número de pedidos pendentes, aceites, cancelados e consultas terminadas do utente
    $sql2 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=0 AND pedido_consulta.ID_UTENTE=$ID)";
    $result2 = mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $sql3 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=2 AND pedido_consulta.ID_UTENTE=$ID)";
    $result3 = mysqli_query($conn,$sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $sql4 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=1 AND pedido_consulta.ID_UTENTE=$ID)";
    $result4 = mysqli_query($conn,$sql4);
    $row4 = mysqli_fetch_assoc($result4);
    $sql5 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=3 AND pedido_consulta.ID_UTENTE=$ID)";
    $result5 = mysqli_query($conn,$sql5);
    $row5 = mysqli_fetch_assoc($result5);
 ?>
<!DOCTYPE html>
<html style="max-width: 100%; overflow-x: hidden;">
    <head>
        <title>Utente</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="/projeto/css/user/main.css">
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
        // DASHBOARD
        --------------------------------------------------------->

        <div class="row no-gutters">
            <!-- Dados do utente -->
            <div class="col-6 col-md-4">
                <div class="card" style="margin-left: 6%; margin-top: 9%; width: 91%; height: 67%">
                    <div class="card-body">
                        <h4 style="text-align: center; color:#0062E6 !important;"><i class="fa fa-user" aria-hidden="true"></i> Dados Pessoais</h4>
                        <hr class="my-4">
                        <div style="margin-left: 5%;">
                            <div class="form row">
                                <h5>Nome:</h5> <h5 id="dashboard_texto"><?php echo $_SESSION['NOME_COMPLETO']; ?></h5>
                            </div>
                            <div class="form row">    
                                <h5>Email:</h5> <h5 id="dashboard_texto"> <?php echo $_SESSION['EMAIL']; ?></h5>
                            </div>
                            <div class="form row">
                                <h5>Telemóvel:</h5> <h5 id="dashboard_texto"> <?php echo $_SESSION['TELEMOVEL']; ?></h5>
                            </div>
                            <div class="form row">
                                <h5>Género:</h5> <h5 id="dashboard_texto"><?php 
                                    switch ($_SESSION["GENERO"]) {
                                        case "m":
                                            echo "Masculino";
                                        break;
                                        case "f":
                                            echo "Feminino";
                                        break;
                                    }
                                ?></h5>
                            </div>
                            <div class="form row">
                                <h5>Grupo Sanguíneo:</h5> <h5 id="dashboard_texto"> <?php 
                                    switch ($_SESSION["GRUPO_SANGUINEO"]) {
                                        case "ABM":
                                            echo "AB+";
                                        break;
                                        case "ABm":
                                            echo "AB−";
                                        break;
                                        case "BM":
                                            echo "B+";
                                        break;
                                        case "Bm":
                                            echo "B−";
                                        break;
                                        case "AM":
                                            echo "A+";
                                        break;
                                        case "Am":
                                            echo "A−";
                                        break;
                                        case "OM":
                                            echo "O+";
                                        break;
                                        case "Om":
                                            echo "O−";
                                        break;
                                    }
                                ?></h5>
                            </div>
                            <div class="form row">
                                <h5>Distrito:</h5> <h5 id="dashboard_texto"> <?php echo $row["DESIGNACAO"]; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-8">
                <div class="row row-cols-1 row-cols-md-2">
                    <!-- Número de pedidos pendentes -->
                    <div class="col mb-4">
                        <div class="card" style="margin-left: 6%; margin-top: 9%; width: 91%; height: 83%">
                            <div class="card-body">
                                <h4 style="text-align: center; color:#0062E6 !important;"><i class="fa fa-calendar-o" aria-hidden="true"></i> Pedidos Pendentes</h4>
                                <hr class="my-4">
                                <h1 style="text-align: center;"><?php echo $row2['Total'] ?></h1>            
                            </div>
                        </div>
                    </div>

                    <!-- Número de pedidos aceites -->
                    <div class="col mb-4">
                        <div class="card" style="margin-left: 0%; margin-top: 9%; width: 91%; height: 83%">
                            <div class="card-body">
                                <h4 style="text-align: center; color:#0062E6 !important;"><i class="fa fa-check" aria-hidden="true"></i> Pedidos Aceites</h4>
                                <hr class="my-4">
                                <h1 style="text-align: center;"><?php echo $row4['Total'] ?></h1>            
                            </div>
                        </div>
                    </div>

                    <!-- Número de pedidos cancelados -->
                    <div class="col mb-4">
                        <div class="card" style="margin-left: 6%; margin-top: 9%; width: 91%; height: 83%">
                            <div class="card-body">
                                <h4 style="text-align: center; color:#0062E6 !important;"><i class="fa fa-ban" aria-hidden="true"></i> Pedidos Cancelados</h4>
                                <hr class="my-4">
                                <h1 style="text-align: center;"><?php echo $row3['Total'] ?></h1>            
                            </div>
                        </div>
                    </div>

                    <!-- Número de consultas terminadas -->
                    <div class="col mb-4">
                        <div class="card" style="margin-left: 0%; margin-top: 9%; width: 91%; height: 83%">
                            <div class="card-body">
                                <h4 style="text-align: center; color:#0062E6 !important;"><i class="fa fa-archive" aria-hidden="true"></i> Consultas Terminadas</h4>
                                <hr class="my-4">
                                <h1 style="text-align: center;"><?php echo $row5['Total'] ?></h1>            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php 
}else{      //Caso o utilizador não tenha feito login       
    header("Location: /projeto/login/");        //Redirecionar o utilizador para a página de login
    exit();
}
 ?>