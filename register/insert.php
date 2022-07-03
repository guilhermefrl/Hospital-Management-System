<?php

include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL

    if(isset($_POST['registar'])){  //Caso o utente tenha inserido todos os campos obrigatórios do registo e tenha clicado no botão para se registar

        //Guardar nas variáveis os dados inseridos no registo
        $u_nome_c = $_POST['u_nome_c'];
        $u_email = $_POST['u_email'];
        $u_endereco = $_POST['u_endereco'];
        $u_data_nascimento = $_POST['u_data_nascimento'];
        $u_CP3 = $_POST['u_CP3'];
        $u_CP4 = $_POST['u_CP4'];
        $u_telemovel = $_POST['u_telemovel'];
        $u_genero = $_POST['u_genero'];
        $u_grupo_sanguineo = $_POST['u_grupo_sanguineo'];
        $u_nome = $_POST['u_nome'];
        $u_pass = $_POST['u_pass'];

            //Query para selecionar o ID de utilizador onde o nome de utilizador seja igual ao inserido
            $sql = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE USERNAME='$u_nome' ";
            $result = mysqli_query($conn, $sql);        //Executar a query na base de dados
            
            //Query para selecionar o ID de utilizador onde o email seja igual ao inserido
            $sql1 = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE EMAIL='$u_email' ";
            $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

            //Caso o email ou o nome de utilizador já existam na base de dados
            if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result1) > 0) {
                header("Location: /projeto/register/?error= Já existe este nome de utilizador ou email!");     //Mensagem de erro
                exit();
            }else {     //Caso contrário
                $hash = password_hash($u_pass, PASSWORD_BCRYPT);    //Converter a palavra-passe em Hash

                //Inserir os dados na tabela utilizador
                $sql2 = "INSERT INTO utilizador (USERNAME, NOME_COMPLETO, PASSWORD, EMAIL, TIPO) values('$u_nome', '$u_nome_c', '$hash', '$u_email', 1)";
                $result2 = mysqli_query($conn, $sql2);        //Executar a query na base de dados

                //Query para buscar o ID de utilizador onde o nome de utilizador é igual ao inserido
                $sql3 = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE USERNAME='$u_nome'";
                $result3 = mysqli_query($conn, $sql3);        //Executar a query na base de dados
                $row = mysqli_fetch_assoc($result3);
                $ID = $row['ID_UTILIZADOR'];

                //Inserir os dados na tabela utente
                $sql4 = "INSERT INTO utente (CP4, CP3, TELEMOVEL, GENERO, DATA_NASCIMENTO, GRUPO_SANGUINEO, ENDERECO, ID_UTILIZADOR) values('$u_CP4', '$u_CP3', '$u_telemovel', '$u_genero', '$u_data_nascimento', '$u_grupo_sanguineo', '$u_endereco', '$ID')";
                $result4 = mysqli_query($conn, $sql4);        //Executar a query na base de dados

                if ($result2 && $result4) {     //Caso não tenha ocorrido nenhum erro no resgito
                    //------------------------------------------------------------
                    // Enviar email a informar que a conta foi criada com sucesso
                    //------------------------------------------------------------
                    require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';  //É usada a biblioteca PHPMailer para enviar o email

                    $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
                    $mail->addAddress($u_email);
                
                    $mail->isHTML(true);
                    $mail->Subject = utf8_decode('A sua conta foi criada!');
                
                    $mail->Body = utf8_decode('<b>Caro(a) '.$u_nome_c.',</b><br><br>A sua conta foi criada com sucesso!');
                
                    $mail->send();

                    header("Location: /projeto/register/?success= A sua conta foi criada com sucesso!");        //Mensagem de sucesso
                    exit();
                }
                else {
                    header("Location: /projeto/register/?error= Ocorreu um erro!");     //Mensagem de erro
                    exit();
                }
            }
    }
    else{
        header("Location: /projeto/register/?error= Ocorreu um erro!");     //Mensagem de erro
        exit();
    }
?>
