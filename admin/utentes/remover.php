<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['remover_utente'])){   //Caso o administrador tenha clicado no botão para remover um utente

        $id_remover = $_POST['ID_REMOVER'];     //Guardar o ID de utilizador do utente

        //--------------------------------------------------------
        // Remover Utente
        //---------------------------------------------------------

        //Query para ir buscar o email e nome completo do utente
        $sql = "SELECT utilizador.NOME_COMPLETO, utilizador.EMAIL FROM utilizador WHERE utilizador.ID_UTILIZADOR=$id_remover";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
        $row = mysqli_fetch_assoc($result);         //Guardar na variável um array que corresponde aos dados da linha do resultado da query

        //Guardar nas variáveis os resultados da query
        $nome = $row['NOME_COMPLETO'];
        $email = $row['EMAIL'];

        //Query para ir buscar o ID de utente
        $sql1 = "SELECT utente.ID_UTENTE FROM utente WHERE utente.ID_UTILIZADOR=$id_remover";
        $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados
        $row1 = mysqli_fetch_assoc($result1);   //Guardar na variável um array que corresponde aos dados da linha do resultado da query
        $ID_UTENTE = $row1['ID_UTENTE'];        //Guardar ID

        //Query para ir buscar o ID's dos pedidos de consulta que o utente efetuou
        $sql2 = "SELECT pedido_consulta.ID_PEDIDO FROM pedido_consulta WHERE pedido_consulta.ID_UTENTE=$ID_UTENTE";
        $result2 = mysqli_query($conn, $sql2);        //Executar a query na base de dados

        while($row2 = mysqli_fetch_array($result2)){  //Fazer para todas as linhas do resultado da query
            $ID_PEDIDO=$row2["ID_PEDIDO"];            //Guardar ID

            //Query para ir buscar o ID da consulta correspondente ao pedido de consulta
            $sql3 = "SELECT consulta.ID_CONSULTA FROM consulta WHERE consulta.ID_PEDIDO=$ID_PEDIDO";
            $result3 = mysqli_query($conn, $sql3);        //Executar a query na base de dados
            $row3 = mysqli_fetch_assoc($result3); //Guardar na variável um array que corresponde aos dados da linha do resultado da query
            $ID_CONSULTA = $row3['ID_CONSULTA'];  //Guardar ID

            //Eliminar na tabela utente_medicamento onde o ID da consulta seja igual ao inserido
            $sql4 = "DELETE FROM utente_medicamento WHERE utente_medicamento.ID_CONSULTA=$ID_CONSULTA";
            $result4 = mysqli_query($conn, $sql4);        //Executar a query na base de dados

            //Eliminar na tabela consulta onde o ID do pedido de consulta seja igual ao inserido
            $sql5 = "DELETE FROM consulta WHERE consulta.ID_PEDIDO=$ID_PEDIDO";
            $result5 = mysqli_query($conn, $sql5);        //Executar a query na base de dados
        }

        //Eliminar na tabela pedido_consulta onde o ID de utente seja igual ao inserido
        $sql6 = "DELETE FROM pedido_consulta WHERE pedido_consulta.ID_UTENTE=$ID_UTENTE";
        $result6 = mysqli_query($conn, $sql6);        //Executar a query na base de dados

        //Eliminar na tabela utente onde o ID de utilizador seja igual ao inserido
        $sql7 = "DELETE FROM utente WHERE utente.ID_UTILIZADOR=$id_remover";
        $result7 = mysqli_query($conn, $sql7);        //Executar a query na base de dados

        //Eliminar na tabela utilizador onde o ID de utilizador seja igual ao inserido
        $sql8 = "DELETE FROM utilizador WHERE utilizador.ID_UTILIZADOR=$id_remover";
        $result8 = mysqli_query($conn, $sql8);        //Executar a query na base de dados

        if ($result8) {     //Caso o utente seja removido
            //------------------------------------------------------------------
            // Enviar email a informar o utente que a sua conta foi removida
            //------------------------------------------------------------------
            require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';  //É usada a biblioteca PHPMailer para enviar o email

            $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
            $mail->addAddress($email);
        
            $mail->isHTML(true);
            $mail->Subject = utf8_decode('A sua conta foi removida!');
        
            $mail->Body = utf8_decode('<b>Caro(a) '.$nome.',</b><br><br>A sua conta foi removida por um Admin!');
        
            $mail->send();

            header("Location: /projeto/admin/utentes/remover_utentes.php?success= Utente removido!");    //Mensagem de sucesso
            exit();
        }
        else{       //Caso contrário
            header("Location: /projeto/admin/utentes/remover_utentes.php?error= Erro!");    //Mensagem de erro
            exit();
        }
    }
    else{
        header("Location: /projeto/admin/");
    }

?>