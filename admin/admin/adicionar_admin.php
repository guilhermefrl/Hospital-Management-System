<?php 
session_start();

//Caso o administrador tenha feito login
if (isset($_SESSION['USERNAME']) && isset($_SESSION['ID_UTENTE']) === FALSE && isset($_SESSION['ID_MEDICO']) === FALSE) {
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL

    //Query para ir buscar os dados de todos os administradores
    $sql = "SELECT utilizador.USERNAME, utilizador.NOME_COMPLETO, utilizador.EMAIL FROM utilizador WHERE utilizador.TIPO=3";
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

        <!--------------------------------------------------------
        // Pop-Up para adicionar um administrador
        --------------------------------------------------------->
        <div class="modal fade" id="Modal_adicionar_admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="adicionar.php" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Admin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Nome de utilizador</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Nome Completo</label>
                                    <input type="text" class="form-control" name="nome" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" name="adicionar_admin" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-------------------------------------------------------------------
        // Pop-Up a informar que o administrador foi adicionado com sucesso
        -------------------------------------------------------------------->
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
                                Admin Adicionado!
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
                                Já existe este email ou nome de utilizador!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!--------------------------------------------------------
        // Adicionar Admin
        --------------------------------------------------------->
        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            
            <h4><i class="fa fa-cog" aria-hidden="true"></i> Adicionar Admins</h4>
            <hr class="my-4">

                <div class="form-row">
                    <button class="btn btn-primary adicionar_admin_btn" style="margin-left: 2%;" type="button">Adicionar</button>
                </div>
                </br>

                <div class="container mb-5 mt-3">
                    <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <td>Nome de utilizador</td>
                                <td>Nome</td>
                                <td>Email</td>
                            </tr>
                        </thead>
                        <?php
                            while($row = mysqli_fetch_array($result)){  //Fazer para todas as linhas do resultado da query
                                echo '<tr>';
                                    echo '<td>'.$row["USERNAME"].'</td>';       //Mostrar o nome de utilizador do administrador
                                    echo '<td>'.$row["NOME_COMPLETO"].'</td>';  //Mostrar o nome completo do administrador
                                    echo '<td>'.$row["EMAIL"].'</td>';          //Mostrar o email do administrador
                                echo '</tr>';
                            }
                        ?>
                    </table>
                </div>
    </body>
</html>

<script>
    $('.adicionar_admin_btn').on('click', function(){   //Caso o botão para adicionar um novo administrador tenha sido clicado
        $('#Modal_adicionar_admin').modal('show');      //Mostrar o pop-up para adicionar um novo administrador
    });

    $("#Modal_adicionar_admin").on('hidden.bs.modal', function () {      //Caso o pop-up para adicionar um administrador seja fechado
        $(this).find('form').trigger('reset');                           //Apagar o que foi escrito nos campos
    });

    $("#myModal").on('hidden.bs.modal', function () {          //Caso o pop-up seja fechado
        window.location.href = '/projeto/admin/admin/adicionar_admin.php';       //Atualizar a página
    });
    
    $(window).on('load',function(){
        $('#myModal').modal('show');    //Mostrar pop-up(s)
    });

    $(document).ready( function () {        //Configuração da tabela
        $('#myTable').DataTable({
            "order": [],
            "language":{
            "search":         "Pesquisa:",
            "paginate": {
            "next":       "Seguinte",
            "previous":   "Anterior"
            },
            "lengthMenu":     "Mostrar _MENU_ Admins",
            "zeroRecords":    "Não foi encontrado nenhum admin.",
            "info":           "_END_ admins no total de _TOTAL_ admins",
            "infoEmpty":      "",
            "infoFiltered": "(filtrado de _MAX_ admins)"
            },
            "columnDefs": [
                            { "width": "35%", "targets": 1 },
                            { "width": "40%", "targets": 2 },
    
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