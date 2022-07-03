<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['eliminar_medico'])){   //Caso o médico tenha clicado no botão para eliminar a sua conta

        $id_remover = $_POST['id'];     //Guardar o ID de utilizador do médico

        //--------------------------------------------------------
        // Remover Médico
        //---------------------------------------------------------

        //Query para ir buscar o email e nome completo do médico
        $sql = "SELECT utilizador.NOME_COMPLETO, utilizador.EMAIL FROM utilizador WHERE utilizador.ID_UTILIZADOR=$id_remover";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
        $row = mysqli_fetch_assoc($result);         //Guardar na variável um array que corresponde aos dados da linha do resultado da query

        //Guardar nas variáveis os resultados da query
        $nome = $row['NOME_COMPLETO'];
        $email = $row['EMAIL'];

        //Atualizar a tabela utilizador com o email, nome de utilizador e palavra-passe com os campos vazios
        $sql1 = "UPDATE utilizador SET TIPO = 0, EMAIL = '', USERNAME = '', PASSWORD = '' WHERE utilizador.ID_UTILIZADOR=$id_remover";
        $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

        if ($result && $result1) {  //Caso não tenha ocorrido nenhum erro
            //-----------------------------------------------------------------------------
            // Enviar email a informar o médico que a sua conta foi removida com sucesso
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
            header("Location: /projeto/medico/definicoes/?error= Erro!");    //Mensagem de erro
            exit();
        }
    }
    else{
        header("Location: /projeto/medico/definicoes/");
    }

?>