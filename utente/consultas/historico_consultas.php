<?php 
session_start();

if (isset($_SESSION['ID_UTENTE'])) {        //Caso o utente tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    $ID=$_SESSION['ID_UTENTE'];

    //Query para ir buscar os dados de todas as consultas do utente
    $sql = "SELECT (DATE_FORMAT(pedido_consulta.DIA, '%d/%m/%Y')) AS DIA, (TIME_FORMAT(pedido_consulta.HORA, '%H:%i')) AS HORA, utilizador.NOME_COMPLETO ,pedido_consulta.ESTADO FROM pedido_consulta, utilizador, medico WHERE pedido_consulta.ID_UTENTE=$ID AND ((utilizador.ID_UTILIZADOR = medico.ID_UTILIZADOR) AND (pedido_consulta.ID_MEDICO=medico.ID_MEDICO))";
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
    </head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>


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
        // Histórico de Consultas
        --------------------------------------------------------->

        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            
            <h4><i class="fa fa-calendar-o" aria-hidden="true"></i> Histórico de Consultas</h4>
            <hr class="my-4">

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Consultas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Histórico de Consultas</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="container mb-5 mt-3">
                <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <td>Dia</td>
                            <td>Hora</td>
                            <td>Médico</td>
                            <td>Estado</td>
                        </tr>
                    </thead>
                    <?php
                        while($row = mysqli_fetch_array($result)){  //Fazer para todas as linhas do resultado da query
                            echo '<tr>';
                                echo '<td>'.$row["DIA"].'</td>';                //Mostrar o dia da consulta
                                echo '<td>'.$row["HORA"].'</td>';               //Mostrar a hora da consulta
                                echo '<td>'.$row["NOME_COMPLETO"].'</td>';      //Mostrar o nome do médico 
                                echo '<td class="'.$row["ESTADO"].'" style="text-align: center; vertical-align: middle;">';     //Mostrar o estado da consulta
                                    switch ($row["ESTADO"]) {
                                        case 0:
                                            echo '<span class="badge badge-secondary">Pendente</span>';
                                        break;
                                        case 1:
                                            echo '<span class="badge badge-success">Aceite</span>';
                                        break;
                                        case 2:
                                            echo '<span class="badge badge-danger">Cancelada</span>';
                                        break;
                                        case 3:
                                            echo '<span class="badge badge-info">Terminada</span>';
                                        break;
                                    }
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
            </div>
    </body>
</html>

<script>
    $(document).ready( function () {        //Configuração da tabela
        $('#myTable').DataTable({
            "order": [[3, 'asc']],
            "language":{
            "search":         "Pesquisa:",
            "paginate": {
            "next":       "Seguinte",
            "previous":   "Anterior"
            },
            "lengthMenu":     "Mostrar _MENU_ Consultas",
            "zeroRecords":    "Não foi encontrada nenhuma consulta.",
            "info":           "_END_ Consultas no total de _TOTAL_ Consultas",
            "infoEmpty":      "",
            "infoFiltered": "(filtrado de _MAX_ Consultas)"
            },
            "columnDefs": [
                            { "width": "10%", "targets": 1 },
                            { "width": "10%", "targets": 3 },
    
            ]
        });
    } );
</script>

<?php 
}else{      //Caso o utilizador não tenha feito login  
    header("Location: /projeto/login/");        //Redirecionar o utilizador para a página de login
    exit();
}
 ?>