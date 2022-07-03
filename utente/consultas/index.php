<?php 
session_start();

if (isset($_SESSION['ID_UTENTE'])) {        //Caso o utente tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL

    //Query para ir buscar o nome e especialidade de todos os médicos da base de dados
    $sql = "SELECT utilizador.NOME_COMPLETO, especialidades.NOME, medico.ID_MEDICO FROM utilizador, medico, especialidades WHERE utilizador.TIPO=2 AND utilizador.ID_UTILIZADOR=medico.ID_UTILIZADOR AND medico.ESPECIALIDADE=especialidades.ID_ESPECIALIDADE";
    $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
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
        // Marcar Consultas
        --------------------------------------------------------->

        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            
            <h4><i class="fa fa-calendar-o" aria-hidden="true"></i> Marcar Consulta</h4>
            <hr class="my-4">

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Consultas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Marcar Consulta</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <form action="insert.php" method="POST">
                <div class="form-row">
                    <!-- Campo para selecionar um médico -->
                    <div class="col-md-6 mb-3">
                        <label style="font-weight: bold;">Médico</label>
                            <select name="medico" class="form-control">
                                <!-- Mostrar todos os médicos e a resptiva especialidade -->
                                <?php while($row = mysqli_fetch_array($result)):;?>
                                <option value=<?php echo $row['ID_MEDICO'];?>><?php echo $row['NOME_COMPLETO'];?> (<?php echo $row['NOME'];?>)</option>
                                <?php endwhile;?>
                            </select>
                    </div>

                    <!-- Campo para selecionar o dia da consulta -->
                    <div class="col-md-3 mb-3">
                        <label style="font-weight: bold;">Dia da Consulta</label>
                        <input class="form-control" id="date" name="date" placeholder="dd/mm/aaaa" type="text" required >
                    </div>

                    <!-- Campo para selecionar a hora da consulta -->
                    <div class="col-md-3 mb-3">
                        <label style="font-weight: bold;">Hora da Consulta</label>
                        <input type="time" class="form-control" name="hora" required>
                    </div>
                </div>

                <!-- Campo para inserir a razão da consulta -->
                <div class="form-row">
                    <label style="font-weight: bold;">Razão</label>
                    <textarea class="form-control" rows="3" name="razao" required></textarea>
                </div>
                </br>
                <div class="form-row">
                    <button class="btn btn-primary" name="marcar_consulta" type="submit">Marcar</button>

                    <!-- Mensagem de erro -->
                    <?php if(isset($_GET['error'])){ ?>
                        <p class="error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><?php echo $_GET['error']; ?></p>
                    <?php } ?>

                    <!-- Mensagem de sucesso -->
                    <?php if (isset($_GET['success'])) { ?>
                        <p class="success"><i class="fa fa-check" aria-hidden="true"></i><?php echo $_GET['success']; ?></p>
                        <div aria-live="polite" aria-atomic="true" style="position: absolute; min-height: 200px; top: 70px; right: 1.5%;">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="false" data-autohide="false">
                                <div class="toast-header">
                                    <strong class="mr-auto"><i class="fa fa-info" aria-hidden="true"></i> Informação</strong>
                                    <small>Agora</small>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="toast-body">
                                    Caso marque uma consulta, ainda tem de ser aprovada.
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>

    </body>
</html>

<script>
$(document).ready(function() {      //Configuração do calendário para escolher o dia de uma consulta
  var dateInput = $('input[name="date"]');
  var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : 'body';
  dateInput.datepicker({
    format: 'dd/mm/yyyy',
    container: container,
    todayHighlight: true,
    autoclose: true,
    startDate: truncateDate(new Date()),
  });

  $('#date').datepicker('setStartDate', truncateDate(new Date()));
});

function truncateDate(date) {
  return new Date(date.getFullYear(), date.getMonth(), date.getDate());
}
</script>
<script>
$(document).ready(function (){
    $(".toast").toast("show")       //Mostrar a mensagem de sucesso
}
)
</script>

<?php 
}else{      //Caso o utilizador não tenha feito login  
    header("Location: /projeto/login/");        //Redirecionar o utilizador para a página de login
    exit();
}
 ?>