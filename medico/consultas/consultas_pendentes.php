<?php 
session_start();

if (isset($_SESSION['ID_MEDICO'])) {        //Caso o médico tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    $ID=$_SESSION['ID_MEDICO'];

    //Query para ir buscar os dados dos pedidos pendentes do médico
    $sql = "SELECT DISTINCT pedido_consulta.ID_PEDIDO, (DATE_FORMAT(pedido_consulta.DIA, '%d/%m/%Y')) AS DIA, utilizador.NOME_COMPLETO, (TIME_FORMAT(pedido_consulta.HORA, '%H:%i')) AS HORA, pedido_consulta.RAZAO ,pedido_consulta.ESTADO FROM pedido_consulta, utilizador, medico, utente WHERE pedido_consulta.ID_MEDICO=$ID AND pedido_consulta.ESTADO=0 AND ((utilizador.ID_UTILIZADOR=utente.ID_UTILIZADOR) AND (pedido_consulta.ID_UTENTE=utente.ID_UTENTE))";
    $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Médico</title>
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
            <a class="navbar-brand" id="nav-text" style="font-weight: bold;">Médico</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/projeto/medico/" id="nav-text"><i class="fa fa-home" aria-hidden="true"></i> Início<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="nav-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-calendar-o" aria-hidden="true"></i> Consultas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/projeto/medico/consultas/ver_consultas.php">Ver Consultas</a>
                        <a class="dropdown-item" href="/projeto/medico/consultas/consultas_pendentes.php">Consultas Pendentes</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/medico/historico/" id="nav-text"><i class="fa fa-book" aria-hidden="true"></i> Histórico Hospitalar de Utentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/medico/consultas_terminadas/" id="nav-text"><i class="fa fa-archive" aria-hidden="true"></i> Consultas Terminadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/medico/estatisticas/" id="nav-text"><i class="fa fa-bar-chart" aria-hidden="true"></i> Estatísticas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/medico/definicoes/" id="nav-text"><i class="fa fa-cog" aria-hidden="true"></i> Definições</a>
                    </li>
                </ul>  
                <div class="form-inline my-2 my-lg-0">
                    <a class="nav-link" href="/projeto/logout/logout.php" id="nav-text"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                </div>                
            </div>
        </nav>

        <!--------------------------------------------------------
        // Pop-Up para cancelar consultas
        --------------------------------------------------------->

        <div class="modal fade" id="modal_cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">			
                        <h4 class="modal-title">Tem a certeza?</h4>	
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>    
                        </button>
                    </div>
                    <form action="cancelar.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="ID_CANCELAR" id="ID_CANCELAR">
                            <p>A consulta vai ser cancelada!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                            <button type="submit" name="s_cancelar" class="btn btn-primary">Sim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------------------------------------------------------
        // Pop-Up a informar que a consulta foi aceite
        --------------------------------------------------------->
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
                                Consulta Aceite!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!--------------------------------------------------------
        // Pop-Up a informar que a consulta foi cancelada
        --------------------------------------------------------->
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
                                Consulta Cancelada!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!--------------------------------------------------------
        // Consultas Pendentes
        --------------------------------------------------------->
        
        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            
            <h4><i class="fa fa-calendar-o" aria-hidden="true"></i> Consultas Pendentes</h4>
            <hr class="my-4">

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Consultas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Consultas Pendentes</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="container mb-5 mt-3">
                <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <td style="display:none;"></td>
                            <td>Dia</td>
                            <td>Hora</td>
                            <td>Utente</td>
                            <td>Razão</td>
                            <td>Estado</td>
                            <td></td>
                        </tr>
                    </thead>
                    <?php
                        while($row = mysqli_fetch_array($result)){  //Fazer para todas as linhas do resultado da query
                            echo '<tr>';
                                echo '<td style="display:none;">'.$row["ID_PEDIDO"].'</td>';
                                echo '<td>'.$row["DIA"].'</td>';                //Mostrar o dia da consulta
                                echo '<td>'.$row["HORA"].'</td>';               //Mostrar a hora da consulta
                                echo '<td>'.$row["NOME_COMPLETO"].'</td>';      //Mostrar o nome do utente
                                echo '<td>'.$row["RAZAO"].'</td>';              //Mostrar a razão para a consulta
                                echo '<td class="'.$row["ESTADO"].'" style="text-align: center; vertical-align: middle;">';
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

                                echo '<form action="aceitar_consultas.php" method="POST">';
                                    echo '<div class="form-row">';
                                        echo '<td style="text-align: center; vertical-align: middle; width: 20%;">';
                                            echo '<input type="hidden" name="ID_ACEITAR" value="'.$row["ID_PEDIDO"].'"/>';
                                            echo '<button type="submit" name="aceitar" class="btn btn-success">Aceitar</button>
                                            <button type="button" class="btn btn-danger cancelar_btn">Cancelar</button>
                                        </td>';
                                    echo '</div>';
                                echo '</form>';
                            echo '</tr>';
                        }
                    ?>
                </table>
            </div>
    </body>
</html>

<script>
    $(document).ready( function(){
        $('.cancelar_btn').on('click', function(){      //Caso tenha sido clicado o botão para cancelar uma consulta
            $('#modal_cancelar').modal('show');         //Mostrar o Pop-Up de aviso

            $t = $(this).closest('tr');

            var row = $t.children("td").map(function() {    //Guardar o ID da consulta que se pretende cancelar
                return $(this).text();
            }).get();

            console.log(row);

            $('#ID_CANCELAR').val(row[0]);

        });
    });

    $(window).on('load',function(){
        $('#myModal').modal('show');    //Mostrar pop-up(s)
    });

    $("#myModal").on('hidden.bs.modal', function () {       //Caso o Pop-Up seja fechado
        window.location.href = '/projeto/medico/consultas/consultas_pendentes.php';      //Atualizar a página
    });
</script>
<script>
    $(document).ready( function () {        //Configuração da tabela
        $('#myTable').DataTable({
            "order": [[1, 'asc']],
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
                            { "orderable": false, "targets": 0 },
                            { "orderable": false, "targets": 4 },
                            { "orderable": false, "targets": 6 },
                            { "width": "10%", "targets": 5 },
    
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