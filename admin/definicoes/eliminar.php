<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['eliminar_admin'])){   //Caso o administrador tenha clicado no botão para eliminar a sua conta

        $id_remover = $_POST['id'];     //Guardar o ID de utilizador do administrador

        //--------------------------------------------------------
        // Remover Admin
        //---------------------------------------------------------

        //Query para ir buscar o email e nome completo do administrador
        $sql = "SELECT utilizador.NOME_COMPLETO, utilizador.EMAIL FROM utilizador WHERE utilizador.ID_UTILIZADOR=$id_remover";
        $result = mysqli_query($conn, $sql);  //Executar a query na base de dados
        $row = mysqli_fetch_assoc($result);   //Guardar na variável um array que corresponde aos dados da linha do resultado da query

        //Guardar nas variáveis os resultados da query
        $nome = $row['NOME_COMPLETO'];
        $email = $row['EMAIL'];

        //Eliminar na tabela utilizador onde o ID de utilizador seja igual ao inserido
        $sql1 = "DELETE FROM utilizador WHERE utilizador.ID_UTILIZADOR=$id_remover";
        $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

        if ($result && $result1) {     //Caso o administrador seja eliminado
            //-----------------------------------------------------------------------------
            // Enviar email a informar o administrador que a sua conta foi eliminada
            //-----------------------------------------------------------------------------
            require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';   //É usada a biblioteca PHPMailer para enviar o email

            $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
            $mail->addAddress($email);
        
            $mail->isHTML(true);
            $mail->Subject = utf8_decode('A sua conta foi eliminada!');
        
            $mail->Body = utf8_decode('<b>Caro(a) '.$nome.',</b><br><br>A sua conta foi eliminada com sucesso!');
        
            $mail->send();

            header("Location: /projeto/logout/logout.php");     //Terminar sessão
            exit();
        }
        else{       //Caso contrário
            header("Location: /projeto/admin/definicoes/?error= Erro!");    //Mensagem de erro
            exit();
        }
    }
    else{
        header("Location: /projeto/admin/definicoes/");
    }

?>