<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['adicionar_admin'])){   //Caso o administrador tenha clicado no botão para adicionar outro administrador

        //Guardar os dados inseridos nos campos
        $username = $_POST['username'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        //Query para ir buscar o ID de utilizador onde o nome de utilizador seja igual ao inserido
        $sql = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE USERNAME='$username' ";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
        
        //Query para ir buscar o ID de utilizador onde o email seja igual ao inserido
        $sql1 = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE EMAIL='$email' ";
        $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

        //Caso o email ou o nome de utilizador já existam na base de dados
        if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result1) > 0) {
            header("Location: /projeto/admin/admin/adicionar_admin.php?error= Já existe este email ou nome de utilizador!");     //Mensagem de erro
            exit();
        }else {     //caso contrário
            //--------------------------------------------------------
            // Gerar Password
            //---------------------------------------------------------

            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*';
            $pass = array();
            $charactersLength = strlen($characters) - 1;
            $pass_length = random_int(30,50);       //Gerar aleatóriamente o tamanho da palavra-passe
            
            for ($i = 0; $i < $pass_length; $i++) {
                $n = random_int(0, $charactersLength);      //Escolher aleatóriamente um caráter
                $pass[] = $characters[$n];                  //Inserir no array
            }

            $final_pass = implode($pass);                   //Juntar os elementos do array numa string

            //--------------------------------------------------------
            // Criar Admin
            //---------------------------------------------------------

            $hash = password_hash($final_pass, PASSWORD_BCRYPT);        //Converter a palavra-passe em Hash

            //Inserir os dados na tabela utilizador
            $sql2 = "INSERT INTO utilizador (USERNAME, NOME_COMPLETO, PASSWORD, EMAIL, TIPO) values('$username', '$nome', '$hash', '$email', 3)";
            $result2 = mysqli_query($conn, $sql2);        //Executar a query na base de dados

            if ($result2) {     //Caso não tenha ocorrido nenhum erro no resgito
                //-------------------------------------------------------------
                // Enviar email a informar que a conta foi criada com sucesso
                //-------------------------------------------------------------
                require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';  //É usada a biblioteca PHPMailer para enviar o email

                $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
                $mail->addAddress($email);
            
                $mail->isHTML(true);
                $mail->Subject = utf8_decode('A sua conta foi criada!');
            
                $mail->Body = utf8_decode('<b>Caro(a) '.$nome.',</b><br><br>A sua conta foi criada com sucesso!<br><br>As suas credênciais de acesso são:<br><br><b>Nome de utilizador: </b>'.$username.'<br><b>Palavra-passe: </b>'.$final_pass.'<br>');
            
                $mail->send();

                header("Location: /projeto/admin/admin/adicionar_admin.php?success= Admin adicionado!");  //Mensagem de sucesso
                exit();
            }
        }
    }
    else{
        header("Location: /projeto/admin/");
    }

?>