<?php 
session_start();

if (isset($_SESSION['ID_MEDICO'])) {        //Caso o médico tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    $ID=$_SESSION['ID_MEDICO'];

    //Query para ir buscar os dados das várias consultas aceites pelo médico
    $sql = "SELECT DISTINCT consulta.ID_CONSULTA, consulta.ID_PEDIDO, (DATE_FORMAT(pedido_consulta.DIA, '%d/%m/%Y')) AS DIA, (TIME_FORMAT(pedido_consulta.HORA, '%H:%i')) AS HORA, pedido_consulta.RAZAO, pedido_consulta.ID_UTENTE, utilizador.ID_UTILIZADOR, utilizador.NOME_COMPLETO, utente.GENERO, (DATE_FORMAT(utente.DATA_NASCIMENTO, '%d/%m/%Y')) AS DATA_NASCIMENTO, utente.GRUPO_SANGUINEO FROM pedido_consulta, consulta, utilizador, utente WHERE pedido_consulta.ESTADO=1 AND pedido_consulta.ID_MEDICO=$ID AND pedido_consulta.ID_PEDIDO=consulta.ID_PEDIDO AND pedido_consulta.ID_UTENTE=utente.ID_UTENTE AND utente.ID_UTILIZADOR=utilizador.ID_UTILIZADOR ORDER BY pedido_consulta.DIA, pedido_consulta.HORA ASC";
    $result = mysqli_query($conn, $sql);

    //Query para ir buscar o ID e nome de todos os medicamentos
    $sql1 = "SELECT medicamento.ID_MEDICAMENTO, medicamento.NOME FROM medicamento";
    $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


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
        // Pop-Up para terminar uma consulta
        --------------------------------------------------------->
        <div class="modal fade bd-example-modal-lg" id="Modal_receitar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="terminar_consulta.php" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Consulta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Diagnóstico</label>
                                    <textarea class="form-control" rows="4" name="diagnostico" required></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Observações</label>
                                    <textarea class="form-control" rows="3" name="observacoes" required></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label>Preço</label>
                                    <input type="number" step="0.01" class="form-control" name="preco" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <label>Medicamentos</label>
                                <select class="selectpicker" data-width="100%" title="Sem medicamentos" id="medicamentos" name="medicamentos[]" multiple data-live-search="true">
                                    <?php
                                        while($row1 = mysqli_fetch_array($result1)){
                                            echo'<option value="'.$row1["ID_MEDICAMENTO"].'">'.$row1["NOME"].'</option>';
                                        }
                                    ?>
                                    <option value="-1" style="display: none;" selected></option>
                                </select>
                            </div>
                            <input type="hidden" name="id_modal" id="id_modal">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" name="receitar" class="btn btn-primary">Receitar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--------------------------------------------------------
        // Pop-Up a informar que a consulta foi terminada
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
                                </div>
                                Consulta Terminada!
                            </h4>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!--------------------------------------------------------
        // Ver Consultas
        --------------------------------------------------------->
        
        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            <h4><i class="fa fa-calendar-o" aria-hidden="true"></i> Consultas</h4>
        </section>

        <?php
            if(mysqli_num_rows($result) === 0){     //Caso não existam consultas aceites pelo médico
                echo '<section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-4 resize">
                    <h5 id="disable-select">Não existem consultas.</h5>
                </section>';
            }
            else{   //Caso existam consultas aceites pelo médico
                while($row = mysqli_fetch_array($result)){      //Mostrar os dados de cada consulta
                    echo '<section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-4 resize">
                        <div class="form row">
                            <h5 id="consulta">Consulta do dia:</h5><h5 id="consulta_dia">'.$row["DIA"].'</h5>
                        </div>
                        <hr class="my-4">
                        <div class="form row">
                            <h6 id="consulta1">Hora: </h6><h6 id="consulta2">'.$row["HORA"].'</h6>
                            <h6 id="consulta3">Utente: </h6><h6 id="consulta4">'.$row["NOME_COMPLETO"].'</h6>
                            <div style="margin-left: 62%; position: absolute;">
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#DT_'.$row["ID_CONSULTA"].'" aria-expanded="false">
                                    Mais detalhes
                                </button>
                            </div>
                            <div style="width: 100%;">
                                <div class="collapse" id="DT_'.$row["ID_CONSULTA"].'">
                                    <div class="card card-body">
                                        <div class="form row">
                                            <h6 id="consulta1_1">Género: </h6><h6 id="consulta2">';
                                                switch ($row["GENERO"]) {
                                                    case "m":
                                                        echo "Masculino";
                                                    break;
                                                    case "f":
                                                        echo "Feminino";
                                                    break;
                                                }
                                            echo '</h6>
                                            <h6 id="consulta3_1">Grupo Sanguíneo: </h6><h6 id="consulta4">';
                                                switch ($row["GRUPO_SANGUINEO"]) {
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
                                        echo '</h6>
                                            <h6 id="consulta3_1">Data de Nascimento: </h6><h6 id="consulta4">'.$row["DATA_NASCIMENTO"].'</h6>
                                        </div>
                                        <hr class="my-4">
                                        <div class="form row">
                                            <h5 id="consulta1_1">Razão:</h5>
                                        </div>
                                        <div style="padding: 8px;">
                                            <h6 id="consulta_razao">'.$row["RAZAO"].'</h6>               
                                        </div>
                                        <hr class="my-4">
                                        <div style="text-align: center; vertical-align: middle; width: 20%;>
                                            <div class="form row">
                                                <form target="_blank" action="historico_utente.php" method="POST">
                                                    <button type="button" class="btn btn-success receitar_btn" id="'.$row["ID_CONSULTA"].'">Receitar</button>
                                                    <input type="hidden" name="id" value="'.$row["ID_UTILIZADOR"].'"/>
                                                    <button type="submit" name="historico_utente" class="btn btn-primary">Histórico</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>';
                }
            }
        ?>            
    </body>
</html>

<script>
    $('.receitar_btn').on('click', function(){      //Caso o botão para terminar uma consulta seja clicado
        var ids = $(this).attr('id');
        $('#id_modal').val( ids );

        $('#Modal_receitar').modal('show');         //Mostrar o Pop-Up para terminar uma consulta
    });

    $("#Modal_receitar").on('hidden.bs.modal', function () {      //Caso o Pop-Up para terminar uma consulta seja fechado
        $(this).find('form').trigger('reset');                    //Apagar o que foi escrito nos campos
    });

    $("#myModal").on('hidden.bs.modal', function () {       //Caso o Pop-Up seja fechado
        window.location.href = '/projeto/medico/consultas/ver_consultas.php';      //Atualizar a página
    });
    
    $(window).on('load',function(){
        $('#myModal').modal('show');    //Mostrar pop-up(s)
    });

    $(function () {
        $('select[name=selValue]').val(1);
        $('.selectpicker').selectpicker('refresh')      //Necessário para atualizar o campo de selecionar medicamentos
    });
</script>

<?php 
}else{      //Caso o utilizador não tenha feito login
    header("Location: /projeto/login/");        //Redirecionar o utilizador para a página de login
    exit();
}
 ?>