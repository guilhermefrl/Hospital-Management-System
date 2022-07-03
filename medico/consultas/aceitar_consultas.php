<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['aceitar'])){             //Caso o médico tenha clicado no botão para aceitar uma consulta
        $id_aceitar = $_POST['ID_ACEITAR'];   //Guardar o ID da consulta

        //Query para mudar o estado da consulta para 1, ou seja, aceite
        $sql = "UPDATE pedido_consulta SET ESTADO = 1 WHERE pedido_consulta.ID_PEDIDO = $id_aceitar";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        //Inserir na tabela consulta o ID do pedido de consulta
        $sql1 = "INSERT INTO consulta (ID_PEDIDO) VALUES ('$id_aceitar');";
        $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

        if($result && $result1){    //Caso não ocorra nenhum erro
            //----------------------------------------------------------------
            // Enviar email ao utente a informar que a consulta foi aceite
            //----------------------------------------------------------------

            //Query para ir buscar os dados da consulta
            $sql2 = "SELECT (DATE_FORMAT(pedido_consulta.DIA, '%d/%m/%Y')) AS DIA, (TIME_FORMAT(pedido_consulta.HORA, '%H:%i')) AS HORA, utilizador.EMAIL, utilizador.NOME_COMPLETO FROM pedido_consulta, utente, utilizador WHERE pedido_consulta.ID_PEDIDO = $id_aceitar AND (pedido_consulta.ID_UTENTE=utente.ID_UTENTE AND utente.ID_UTILIZADOR=utilizador.ID_UTILIZADOR)";
            $result2 = mysqli_query($conn, $sql2); //Executar a query na base de dados
            $row = mysqli_fetch_array($result2);   //Guardar na variável um array que corresponde aos dados da linha do resultado da query

            //Guardar os dados resultantes da query
            $u_nome_c=$row["NOME_COMPLETO"];
            $dia=$row["DIA"];
            $hora=$row["HORA"];
            $u_email=$row["EMAIL"];
            $nome_medico=$_SESSION["NOME_COMPLETO"];

            require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';      //É usada a biblioteca PHPMailer para enviar o email

            $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
            $mail->addAddress($u_email);
        
            $mail->isHTML(true);
            $mail->Subject = utf8_decode('Consulta aceite!');
        
            $mail->Body = utf8_decode('<b>Caro(a) '.$u_nome_c.',</b><br><br>O seu pedido de consulta no dia '.$dia.' às '.$hora.' foi aceite pelo '.$nome_medico.'.');
        
            $mail->send();

            header("Location: /projeto/medico/consultas/consultas_pendentes.php?success= A consulta foi aceite!");  //Mensagem de sucesso
        }
    }

?>