<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['adicionar_medico'])){   //Caso o administrador tenha clicado no botão para adicionar um médico

        //Guardar os dados inseridos nos campos
        $username = $_POST['username'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $especialidade = $_POST['especialidade'];
        $experiencia = $_POST['experiencia'];

        //Query para ir buscar o ID de utilizador onde o nome de utilizador seja igual ao inserido
        $sql = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE USERNAME='$username' ";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
        
        //Query para ir buscar o ID de utilizador onde o email seja igual ao inserido
        $sql1 = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE EMAIL='$email' ";
        $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

        //Caso o email ou o nome de utilizador já existam na base de dados
        if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result1) > 0) {
            header("Location: /projeto/admin/medicos/adicionar_medicos.php?error= Já existe este email ou nome de utilizador!"); //Mensagem de erro
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
            // Criar Médico
            //---------------------------------------------------------

            $hash = password_hash($final_pass, PASSWORD_BCRYPT);        //Converter a palavra-passe em Hash

            //Inserir os dados na tabela utilizador
            $sql2 = "INSERT INTO utilizador (USERNAME, NOME_COMPLETO, PASSWORD, EMAIL, TIPO) values('$username', '$nome', '$hash', '$email', 2)";
            $result2 = mysqli_query($conn, $sql2);        //Executar a query na base de dados

            //Query para ir buscar o ID de utilizador do novo médico
            $sql3 = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE USERNAME='$username'";
            $result3 = mysqli_query($conn, $sql3);        //Executar a query na base de dados
            $row = mysqli_fetch_assoc($result3); //Guardar na variável um array que corresponde aos dados da linha do resultado da query
            $ID = $row['ID_UTILIZADOR'];    //Guardar o ID de utilizador do médico

            //Inserir os dados na tabela medico
            $sql4 = "INSERT INTO medico (ESPECIALIDADE, EXPERIENCIA, ID_UTILIZADOR) values('$especialidade', '$experiencia', '$ID')";
            $result4 = mysqli_query($conn, $sql4);        //Executar a query na base de dados

            if ($result2 && $result4) {     //Caso não tenha ocorrido nenhum erro no resgito
                //--------------------------------------------------------
                // Enviar Email
                //---------------------------------------------------------
                require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';  //É usada a biblioteca PHPMailer para enviar o email

                $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
                $mail->addAddress($email);
            
                $mail->isHTML(true);
                $mail->Subject = utf8_decode('A sua conta foi criada!');
            
                $mail->Body = utf8_decode('<b>Caro(a) '.$nome.',</b><br><br>A sua conta foi criada com sucesso!<br><br>As suas credênciais de acesso são:<br><br><b>Nome de utilizador: </b>'.$username.'<br><b>Palavra-passe: </b>'.$final_pass.'<br>');
            
                $mail->send();

                header("Location: /projeto/admin/medicos/adicionar_medicos.php?success= Médico adicionado!");  //Mensagem de sucesso
                exit();
            }
        }
    }
    else{
        header("Location: /projeto/admin/");
    }

?>