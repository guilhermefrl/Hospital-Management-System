<?php
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    //Caso tenham sido preenchidos todos os campos obrigatórios e o utilizador tenha clicado no botão para marcar uma consulta
    if(isset($_POST['marcar_consulta'])){
        //Guardar nas variáveis os dados inseridos na marcação da consulta
        $medico = $_POST['medico'];
        $date = $_POST['date'];
        $hora = $_POST['hora'];
        $razao = $_POST['razao'];
        $utente = $_SESSION['ID_UTENTE'];

        //Colocar a data na forma aceite pela base de dados
        $aux = str_replace('/', '-', $date);
        $dia = date('Y-m-d', strtotime($aux));

        //Inserir na tabela pedido_consulta os dados da marcação
        $sql = "INSERT INTO pedido_consulta (DIA, HORA, RAZAO, ESTADO, ID_MEDICO, ID_UTENTE) values('$dia', '$hora', '$razao', 0, '$medico', '$utente')";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        if ($result) {
            header("Location: /projeto/utente/consultas/?success= A marcação foi criada com sucesso!");     //Mensagem de sucesso
            exit();
        }
        else {
            header("Location: /projeto/utente/consultas/?error= Ocorreu um erro!");     //Mensagem de erro
            exit();
        }
    }
    else {
        header("Location: /projeto/utente/consultas/?error= Ocorreu um erro!");     //Mensagem de erro
        exit();
    }
?>