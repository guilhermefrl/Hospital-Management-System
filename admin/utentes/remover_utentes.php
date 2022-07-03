<?php 
session_start();

//Caso o administrador tenha feito login
if (isset($_SESSION['USERNAME']) && isset($_SESSION['ID_UTENTE']) === FALSE && isset($_SESSION['ID_MEDICO']) === FALSE) {
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";

    //Query para ir buscar os dados de todos os utentes
    $sql = "SELECT utilizador.ID_UTILIZADOR, utilizador.NOME_COMPLETO, utilizador.EMAIL, utente.TELEMOVEL, (DATE_FORMAT(utente.DATA_NASCIMENTO, '%d/%m/%Y')) AS DATA_NASCIMENTO FROM utilizador, utente WHERE utilizador.TIPO=1 AND utilizador.ID_UTILIZADOR=utente.ID_UTILIZADOR";
    $result = mysqli_query($conn, $sql);  //Executar a query na base de dados

 ?>
<!DOCTYPE html>
<html>
    <head>
    <title>Admin</title>
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
            <a class="navbar-brand" id="nav-text">Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/projeto/admin/" id="nav-text"><i class="fa fa-home" aria-hidden="true"></i> Início<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="nav-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i> Utentes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/projeto/admin/utentes/remover_utentes.php">Remover Utentes</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="nav-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-md" aria-hidden="true"></i> Médicos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/projeto/admin/medicos/adicionar_medicos.php">Adicionar Médicos</a>
                        <a class="dropdown-item" href="/projeto/admin/medicos/remover_medicos.php">Remover Médicos</a>
                        <a class="dropdown-item" href="/projeto/admin/medicos/adicionar_especialidades.php">Adicionar Especialiadades</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="nav-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog" aria-hidden="true"></i> Admin
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/projeto/admin/admin/adicionar_admin.php">Adicionar Admins</a>
                        <a class="dropdown-item" href="/projeto/admin/admin/remover_admin.php">Remover Admins</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/admin/medicamentos/" id="nav-text"><i class="fa fa-medkit" aria-hidden="true"></i> Medicamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projeto/admin/definicoes/" id="nav-text"><i class="fa fa-cog" aria-hidden="true"></i> Definições</a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <a class="nav-link" href="/projeto/logout/logout.php" id="nav-text"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                </div>                
            </div>
        </nav>

        <!------------------------------------------------------
        // Pop-Up a informar que o utente vai ser removido
        ------------------------------------------------------->

        <div class="modal fade" id="modal_remover" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">			
                        <h4 class="modal-title">Tem a certeza?</h4>	
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>    
                        </button>
                    </div>
                    <form action="remover.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="ID_REMOVER" id="ID_REMOVER">
                            <p>O utente vai ser removido!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                            <button type="submit" name="remover_utente" class="btn btn-primary">Sim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!------------------------------------------------------------
        // Pop-Up a informar que o utente foi removido com sucesso
        ------------------------------------------------------------->
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
                                Utente Removido!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

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

        <!--------------------------------------------------------
        // Remover Utentes
        --------------------------------------------------------->
        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            
            <h4><i class="fa fa-user" aria-hidden="true"></i> Remover Utentes</h4>
            <hr class="my-4">

                <div class="container mb-5 mt-3">
                    <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <td style="display:none;"></td>
                                <td>Nome</td>
                                <td>Email</td>
                                <td>Telemóvel</td>
                                <td>Data de Nascimento</td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php
                            while($row = mysqli_fetch_array($result)){  //Fazer para todas as linhas do resultado da query
                                echo '<tr>';
                                    echo '<td style="display:none;">'.$row["ID_UTILIZADOR"].'</td>';
                                    echo '<td>'.$row["NOME_COMPLETO"].'</td>';       //Mostrar o nome completo do utente
                                    echo '<td>'.$row["EMAIL"].'</td>';               //Mostrar o email do utente
                                    echo '<td>'.$row["TELEMOVEL"].'</td>';           //Mostrar o número de telemóvel do utente
                                    echo '<td>'.$row["DATA_NASCIMENTO"].'</td>';     //Mostrar a data de nascimento do utente
                                    echo '<td style="text-align: center; vertical-align: middle; width: 13%"><button type="button" class="btn btn-danger remover_btn">Remover</button></td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </div>
    </body>
</html>

<script>
    $(document).ready( function(){
        $('.remover_btn').on('click', function(){      //Caso tenha sido clicado o botão para remover um utente
            $('#modal_remover').modal('show');         //Mostrar o Pop-Up de aviso

            $t = $(this).closest('tr');

            var row = $t.children("td").map(function() {    //Guardar o ID do utilizador que se pretende remover
                return $(this).text();
            }).get();

            $('#ID_REMOVER').val(row[0]);

        });
    });

    $("#myModal").on('hidden.bs.modal', function () {          //Caso o pop-up seja fechado
        window.location.href = '/projeto/admin/utentes/remover_utentes.php';       //Atualizar a página
    });
    
    $(window).on('load',function(){
        $('#myModal').modal('show');    //Mostrar pop-up(s)
    });
</script>
<script>
    $(document).ready( function () {        //Configuração da tabela
        $('#myTable').DataTable({
            "language":{
            "search":         "Pesquisa:",
            "paginate": {
            "next":       "Seguinte",
            "previous":   "Anterior"
            },
            "lengthMenu":     "Mostrar _MENU_ Utentes",
            "zeroRecords":    "Não foi encontrado nenhum utente.",
            "info":           "_END_ utentes no total de _TOTAL_ utentes",
            "infoEmpty":      "",
            "infoFiltered": "(filtrado de _MAX_ utentes)"
            },
            "columnDefs": [
                            { "orderable": false, "targets": 5 },
                            { "width": "30%", "targets": 1 },
                            { "width": "30%", "targets": 2 },
                            { "width": "20%", "targets": 4 },
    
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