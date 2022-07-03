<?php 
session_start();

if (isset($_SESSION['ID_UTENTE'])) {        //Caso o utente tenha feito login
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    $id=$_SESSION['ID_UTENTE'];

    //Query para contar quantas vezes cada medicamento foi receitado ao utente
    $sql = "SELECT medicamento.NOME, COUNT(utente_medicamento.ID_MEDICAMENTO) AS Total FROM medicamento LEFT JOIN utente_medicamento ON(medicamento.ID_MEDICAMENTO = utente_medicamento.ID_MEDICAMENTO) INNER JOIN consulta ON(utente_medicamento.ID_CONSULTA=consulta.ID_CONSULTA) INNER JOIN pedido_consulta ON(consulta.ID_PEDIDO=pedido_consulta.ID_PEDIDO AND pedido_consulta.ID_UTENTE=$id) GROUP BY medicamento.ID_MEDICAMENTO";
    $result = mysqli_query($conn,$sql);        //Executar a query na base de dados
    $result1 = mysqli_query($conn,$sql);

    //Queries para contar o número de pedidos pendentes, aceites, cancelados e consultas terminadas do utente
    $sql2 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=0 AND pedido_consulta.ID_UTENTE=$id)";
    $result2 = mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $sql3 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=2 AND pedido_consulta.ID_UTENTE=$id)";
    $result3 = mysqli_query($conn,$sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $sql4 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=1 AND pedido_consulta.ID_UTENTE=$id)";
    $result4 = mysqli_query($conn,$sql4);
    $row4 = mysqli_fetch_assoc($result4);
    $sql5 = "SELECT COUNT(pedido_consulta.ID_UTENTE) AS Total FROM utente LEFT JOIN pedido_consulta ON(utente.ID_UTENTE=pedido_consulta.ID_UTENTE AND pedido_consulta.ESTADO=3 AND pedido_consulta.ID_UTENTE=$id)";
    $result5 = mysqli_query($conn,$sql5);
    $row5 = mysqli_fetch_assoc($result5);

    date_default_timezone_set('Europe/Lisbon');
    $timestamp = date("Y");     //Guardar na variável o ano atual

    //Query para contar o número de consultas terminadas em cada mês, no ano atual
    $sql6 = "SELECT 
    SUM(CASE MONTH(DATA) WHEN 1 THEN 1 ELSE 0 END) AS '1',
    SUM(CASE MONTH(DATA) WHEN 2 THEN 1 ELSE 0 END) AS '2',
    SUM(CASE MONTH(DATA) WHEN 3 THEN 1 ELSE 0 END) AS '3',
    SUM(CASE MONTH(DATA) WHEN 4 THEN 1 ELSE 0 END) AS '4',
    SUM(CASE MONTH(DATA) WHEN 5 THEN 1 ELSE 0 END) AS '5',
    SUM(CASE MONTH(DATA) WHEN 6 THEN 1 ELSE 0 END) AS '6',
    SUM(CASE MONTH(DATA) WHEN 7 THEN 1 ELSE 0 END) AS '7',
    SUM(CASE MONTH(DATA) WHEN 8 THEN 1 ELSE 0 END) AS '8',
    SUM(CASE MONTH(DATA) WHEN 9 THEN 1 ELSE 0 END) AS '9',
    SUM(CASE MONTH(DATA) WHEN 10 THEN 1 ELSE 0 END) AS '10',
    SUM(CASE MONTH(DATA) WHEN 11 THEN 1 ELSE 0 END) AS '11',
    SUM(CASE MONTH(DATA) WHEN 12 THEN 1 ELSE 0 END) AS '12'
    FROM consulta, pedido_consulta, utente WHERE YEAR(DATA) = '$timestamp' AND consulta.ID_PEDIDO=pedido_consulta.ID_PEDIDO AND pedido_consulta.ID_UTENTE=utente.ID_UTENTE AND utente.ID_UTENTE=$id";
    $result6 = mysqli_query($conn,$sql6);        //Executar a query na base de dados
    $row6 = mysqli_fetch_assoc($result6);        //Guardar na variável um array que corresponde aos dados da linha do resultado da query

    $timestamp1=$timestamp-1;   //Guardar na variável o ano passado

    //Query para contar o número de consultas terminadas em cada mês, no ano passado
    $sql7 = "SELECT 
    SUM(CASE MONTH(DATA) WHEN 1 THEN 1 ELSE 0 END) AS '1',
    SUM(CASE MONTH(DATA) WHEN 2 THEN 1 ELSE 0 END) AS '2',
    SUM(CASE MONTH(DATA) WHEN 3 THEN 1 ELSE 0 END) AS '3',
    SUM(CASE MONTH(DATA) WHEN 4 THEN 1 ELSE 0 END) AS '4',
    SUM(CASE MONTH(DATA) WHEN 5 THEN 1 ELSE 0 END) AS '5',
    SUM(CASE MONTH(DATA) WHEN 6 THEN 1 ELSE 0 END) AS '6',
    SUM(CASE MONTH(DATA) WHEN 7 THEN 1 ELSE 0 END) AS '7',
    SUM(CASE MONTH(DATA) WHEN 8 THEN 1 ELSE 0 END) AS '8',
    SUM(CASE MONTH(DATA) WHEN 9 THEN 1 ELSE 0 END) AS '9',
    SUM(CASE MONTH(DATA) WHEN 10 THEN 1 ELSE 0 END) AS '10',
    SUM(CASE MONTH(DATA) WHEN 11 THEN 1 ELSE 0 END) AS '11',
    SUM(CASE MONTH(DATA) WHEN 12 THEN 1 ELSE 0 END) AS '12'
    FROM consulta, pedido_consulta, utente WHERE YEAR(DATA) = '$timestamp1' AND consulta.ID_PEDIDO=pedido_consulta.ID_PEDIDO AND pedido_consulta.ID_UTENTE=utente.ID_UTENTE AND utente.ID_UTENTE=$id";
    $result7 = mysqli_query($conn,$sql7);        //Executar a query na base de dados
    $row7 = mysqli_fetch_assoc($result7);        //Guardar na variável um array que corresponde aos dados da linha do resultado da query

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
        // Estatísticas
        --------------------------------------------------------->

            <div class="form-row">
                <!--------------------------------------------------------
                // Número de Pedidos/Consultas
                --------------------------------------------------------->
                <?php
                    if($row2['Total'] == 0 && $row3['Total'] == 0 && $row4['Total'] == 0 && $row5['Total'] == 0){
                        echo '
                        <div class="card" style="margin-left: 1.5%; margin-top: 3%; width: 48%; height: 48%">
                            <div class="card-body">
                                <div style="text-align: center;">
                                    <h5>Não existem dados</h5>
                                </div>
                            </div>
                        </div> ';
                    }
                    else{
                        echo'
                        <div class="card" style="margin-left: 1.5%; margin-top: 3%; width: 48%;">
                            <div class="card-body">
                                <div>
                                    <canvas id="myChart1"></canvas>
                                </div>
                            </div>
                        </div>';
                    }
                    #--------------------------------------------------------
                    // Número de consultas por mês
                    #--------------------------------------------------------
                    if($row6['1'] == 0 && $row6['2'] == 0 && $row6['3'] == 0 && $row6['4'] == 0 && $row6['5'] == 0 && $row6['6'] == 0 && $row6['7'] == 0 && $row6['8'] == 0 && $row6['9'] == 0 && $row6['10'] == 0 && $row6['11'] == 0 && $row6['12'] == 0
                    && $row7['1'] == 0 && $row7['2'] == 0 && $row7['3'] == 0 && $row7['4'] == 0 && $row7['5'] == 0 && $row7['6'] == 0 && $row7['7'] == 0 && $row7['8'] == 0 && $row7['9'] == 0 && $row7['10'] == 0 && $row7['11'] == 0 && $row7['12'] == 0){
                        echo '
                        <div class="card" style="margin-left: 1%; margin-top: 3%; width: 48%;">
                            <div class="card-body">
                                <div style="text-align: center;">
                                    <h5>Não existem dados</h5>
                                </div>
                            </div>
                        </div> ';
                    }
                    else{
                        echo'
                        <div class="card" style="margin-left: 1%; margin-top: 3%; width: 48%;">
                            <div class="card-body">
                                <div>
                                    <canvas id="myChart2"></canvas>
                                </div>
                            </div>
                        </div>';
                    }

                ?>
            </div>
            <div class="form-row">
                <?php
                #--------------------------------------------------------
                // Medicamentos mais receitados
                #--------------------------------------------------------
                if(mysqli_num_rows($result) > 0){
                    echo'
                    <div class="card" style="margin-left: 1.5%; margin-top: 3%; width: 48%;">
                        <div class="card-body">
                            <div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>';
                }
                else{
                    echo'
                    <div class="card" style="margin-left: 1.5%; margin-top: 3%; width: 48%; height: 48%">
                        <div class="card-body">
                            <div style="text-align: center;">
                                <h5>Não existem dados</h5>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
            </br>
            </br>
            </br>
    </body>
</html>

<script>
//--------------------------------------------------------
// Número de Pedidos/Consultas
//--------------------------------------------------------
var ctx1 = document.getElementById('myChart1');
var myChart = new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: ["Pedidos Pendentes", "Pedidos Cancelados", "Consultas não realizadas", "Consultas terminadas"],
      datasets: [
        {
          label: "Número",
          backgroundColor: [                
                "#bfd7ff",
                "#ee6055",
                "#72efdd",
                "#06d6a0"],
            data: [
                <?php
                echo'
                '.$row2['Total'].',
                '.$row3['Total'].',
                '.$row4['Total'].',
                '.$row5['Total'].',';
                ?>
            ],
        }
      ]
    },
    options: {
      legend: { 
            display: false,
       },
      title: {
        display: true,
        text: 'Número de Pedidos/Consultas',
        fontSize: 14
      }
    }
});

//--------------------------------------------------------
// Número de consultas por mês
//--------------------------------------------------------
var ctx2 = document.getElementById('myChart2');
var myChart = new Chart(ctx2, {
    type: 'line',
  data: {
    labels: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro", "Dezembro"],
    datasets: [ { 
        data: [<?php
                echo'
                '.$row6['1'].',
                '.$row6['2'].',
                '.$row6['3'].',
                '.$row6['4'].',
                '.$row6['5'].',
                '.$row6['6'].',
                '.$row6['7'].',
                '.$row6['8'].',
                '.$row6['9'].',
                '.$row6['10'].',
                '.$row6['11'].',
                '.$row6['12'].',';
                ?>],
        label: "Consultas este ano",
        borderColor: "#0ce39c",
        backgroundColor: "#a6f5da",
        fill: true
      }, {
      data: [<?php
                echo'
                '.$row7['1'].',
                '.$row7['2'].',
                '.$row7['3'].',
                '.$row7['4'].',
                '.$row7['5'].',
                '.$row7['6'].',
                '.$row7['7'].',
                '.$row7['8'].',
                '.$row7['9'].',
                '.$row7['10'].',
                '.$row7['11'].',
                '.$row7['12'].',';
                ?>],
        label: "Consultas no ano passado",
        borderColor: "#1096fb",
        backgroundColor: "#a0d5fd",
        fill: true
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Número de consultas por mês',
      fontSize: 14
    }
  }
});

//--------------------------------------------------------
// Medicamentos mais receitados
//--------------------------------------------------------
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [        
          <?php
            while($row = mysqli_fetch_array($result)){ 
                echo' "'.$row['NOME'].'", ';
            } 
          ?>
        ],
      datasets: [
        {
          label: "Número de medicamentos receitados",
          backgroundColor: ["#D0EFB1","#9BC4CB","#ffce56", "#B9E3C6","#59C9A5","#7FEFBD","#FFFD98", "#26C485", "#A3E7FC", "#F64740", "#477998", "#C4D6B0", "#77A6B6", "#B3D89C", "#D0EFB1","#ffce56", "#B9E3C6","#59C9A5","#7FEFBD","#FFFD98", "#26C485", "#A3E7FC", "#F64740", "#477998", "#C4D6B0", "#77A6B6", "#B3D89C", "#D0EFB1","#ffce56", "#B9E3C6","#59C9A5","#7FEFBD","#FFFD98", "#26C485", "#A3E7FC", "#F64740", "#477998", "#C4D6B0", "#77A6B6", "#B3D89C"],
          data: [
            <?php
                while($row1 = mysqli_fetch_array($result1)){ 
                    echo' '.$row1['Total'].', ';
                } 
            ?>
          ]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Medicamentos mais receitados',
        fontSize: 14
      },
      legend: {
            labels: {
                fontSize: 14
            }
        }
    }
});
</script>

<?php 
}else{      //Caso o utilizador não tenha feito login 
    header("Location: /projeto/login/");        //Redirecionar o utilizador para a página de login
    exit();
}
 ?>