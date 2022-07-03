<?php 
session_start();

if (isset($_SESSION['ID_UTENTE'])) {        //Caso o utente tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    $ID_UTENTE = $_SESSION['ID_UTENTE'];

    //Query para ir buscar todos os dados de todas as consultas terminadas do utente
    $sql1 = "SELECT DISTINCT utilizador.NOME_COMPLETO, pedido_consulta.ID_PEDIDO, consulta.ID_CONSULTA, consulta.DIAGNOSTICO, consulta.OBSERVACOES, consulta.DATA, consulta.PRECO FROM pedido_consulta, consulta, medico, utilizador WHERE pedido_consulta.ESTADO=3 AND pedido_consulta.ID_UTENTE=$ID_UTENTE AND pedido_consulta.ID_PEDIDO=consulta.ID_PEDIDO AND pedido_consulta.ID_MEDICO=medico.ID_MEDICO AND medico.ID_UTILIZADOR=utilizador.ID_UTILIZADOR ORDER BY consulta.DATA DESC";
    $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados
    
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
        // Histórico do Utente
        --------------------------------------------------------->
        <section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-5 resize">
            <?php echo'
            <div class="form row">
                <h4><i class="fa fa-book" aria-hidden="true"></i> Histórico Hospitalar</h4>
            </div>';?>
        </section>

        <?php
            if(mysqli_num_rows($result1) === 0){    //Caso não existam consultas terminadas
                echo '<section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-4 resize">
                    <h5 id="disable-select">Não existe histórico.</h5>
                </section>';
            }
            else{       //Caso existam consultas terminadas
                while($row1 = mysqli_fetch_array($result1)){    //Fazer para todas as linhas do resultado da query
                    echo '<section class="shadow-sm mx-auto w-75 shadow clearfix my-5 rounded bg-white p-4 resize">
                        <div class="form row">';

                        //Separar o datetime em dia e hora
                        $aux1=$row1["DATA"];
                        list($second,$first) = explode(' ',strrev($aux1),2);
                        $first = strrev($first);
                        $second = strrev($second);
                    
                        $dia = date("d/m/Y", strtotime($first));
                        $hora = date("H:i", strtotime($second));

                        //Mostrar os dados da consulta
                            echo'<h5 id="consulta">Consulta do dia:</h5><h5 id="consulta_dia">'.$dia.'</h5>
                        </div>
                        <hr class="my-4">
                        <div class="form row">
                            <h6 id="consulta1">Hora: </h6><h6 id="consulta2">'.$hora.'</h6>
                            <h6 id="consulta3">Médico: </h6><h6 id="consulta4">'.$row1["NOME_COMPLETO"].'</h6>
                            <div style="margin-left: 62%; position: absolute;">
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#DT_'.$row1["ID_CONSULTA"].'" aria-expanded="false">
                                    Mais detalhes
                                </button>
                            </div>
                            <div style="width: 100%;">
                                <div class="collapse" id="DT_'.$row1["ID_CONSULTA"].'">
                                    <div class="card card-body">
                                        <div class="form row">
                                            <h5 id="consulta1_1">Diagnóstico:</h5>
                                        </div>
                                        <div style="padding: 8px;">
                                            <h6 id="consulta_razao">'.$row1["DIAGNOSTICO"].'</h6>               
                                        </div>
                                        <hr class="my-4">
                                        <div class="form row">
                                            <h5 id="consulta1_1">Observações:</h5>
                                        </div>
                                        <div style="padding: 8px;">
                                            <h6 id="consulta_razao">'.$row1["OBSERVACOES"].'</h6>               
                                        </div>
                                        <hr class="my-4">
                                        <div class="form row">
                                            <h5 id="consulta1_1">Preço:</h5>
                                        </div>
                                        <div style="padding: 8px;">
                                            <h6 id="consulta_razao">'.$row1["PRECO"].'€</h6>               
                                        </div>';

                                        $aux=$row1["ID_CONSULTA"];

                                        //Query para ir buscar todos os medicamentos associados à consulta
                                        $sql3 = "SELECT utente_medicamento.ID_MEDICAMENTO, medicamento.NOME, medicamento.DESCRICAO, medicamento.LABORATORIO, medicamento.PRECO FROM utente_medicamento, medicamento WHERE utente_medicamento.ID_CONSULTA=$aux AND utente_medicamento.ID_MEDICAMENTO=medicamento.ID_MEDICAMENTO";
                                        $result3 = mysqli_query($conn, $sql3);        //Executar a query na base de dados

                                  echo' <hr class="my-4">
                                            <div class="form row">
                                                <h5 id="consulta1_1">Medicamentos:</h5>
                                            </div>
                                            <div style="padding: 8px;">';
                                            if(mysqli_num_rows($result3) === 0){  //Caso não tenham sido receitados medicamentos
                                                echo '<h6 id="consulta_razao">Não foram receitados medicamentos.</h6>';
                                            }
                                            else{           //Caso contrário
                                                while($row3 = mysqli_fetch_array($result3)){  //Mostrar todos os medicamentos receitados na consulta
                                                    echo'<ul class="list-group">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        '.$row3["NOME"].'
                                                        <button tabindex="0" class="btn btn-primary" role="button" data-toggle="popover" data-trigger="focus" title="Descrição" data-content="'.$row3["DESCRICAO"].'">
                                                            <i class="fa fa-info" aria-hidden="true"></i>
                                                        </button>
                                                        </li>
                                                    </ul>';
                                                }
                                            }
                                            //Botão para gerar um pdf com os dados da consulta
                                            echo'</div>
                                        <hr class="my-4">
                                            <div class="form row">
                                                <div style="margin-left: 3%; position: relative;">
                                                    <form target="_blank" action="gerar_pdf.php" method="POST">
                                                        <input type="hidden" name="id" value="'.$row1["ID_CONSULTA"].'"/>
                                                        <button type="submit" name="gerar_pdf" class="btn btn-outline-danger"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
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
    $(document).ready(function(){       //Mostrar descrição dos medicamentos
        $('[data-toggle="popover"]').popover();
        $('.popover-dismiss').popover({
            trigger: 'focus'
        })
    });
</script>
<?php 
}else{      //Caso o utilizador não tenha feito login  
    header("Location: /projeto/login/");        //Redirecionar o utilizador para a página de login
    exit();
}
 ?>