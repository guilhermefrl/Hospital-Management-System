<?php
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    //Caso o médico tenha inserido todos os campos obrigatórios e tenha clicado no botão para alterar a palavra-passe
    if(isset($_POST['mudar_password'])){
        $pass_atual = $_POST['pass_atual'];
        $pass_nova = $_POST['pass_nova'];
        $pass_confirmacao = $_POST['pass_confirmacao'];
        $ID_Utilizador = $_SESSION['ID_UTILIZADOR'];

        //Query para ir buscar a palavra-passe do médico
        $sql="SELECT utilizador.PASSWORD FROM utilizador WHERE utilizador.ID_UTILIZADOR=$ID_Utilizador";
        $result = mysqli_query($conn, $sql);  //Executar a query na base de dados
        $row = mysqli_fetch_assoc($result);   //Guardar na variável um array que corresponde aos dados da linha do resultado da query

        //Caso a palavra-passe que foi inserida no primeiro campo seja igual à da base de dados
        if(password_verify($pass_atual, $row["PASSWORD"])) {
            if($pass_nova == $pass_confirmacao){    //Caso a nova palavra-passe e a de confirmação sejam iguais
                $hash = password_hash($pass_nova, PASSWORD_BCRYPT);     //Converter em Hash a nova palavra-passe

                //Query para atualizar a palavra-passe na tabela utilizador
                $sql1 = "UPDATE utilizador SET PASSWORD = '$hash' WHERE utilizador.ID_UTILIZADOR = $ID_Utilizador";
                $result1 = mysqli_query($conn, $sql1);        //Executar a query na base de dados

                if($result && $result1){    //Caso não tenha ocorrido nenhum erro

                    //Query para ir buscar o email e nome completo do médico
                    $sql2 = "SELECT utilizador.EMAIL, utilizador.NOME_COMPLETO FROM utilizador WHERE utilizador.ID_UTILIZADOR=$ID_Utilizador";
                    $result2 = mysqli_query($conn, $sql2); //Executar a query na base de dados
                    $row2 = mysqli_fetch_assoc($result2);  //Guardar na variável um array que corresponde aos dados da linha do resultado da query

                    //Guardar nas variáveis os resultados da query
                    $email = $row2['EMAIL'];
                    $nome = $row2['NOME_COMPLETO'];

                    //-----------------------------------------------------------------------
                    // Enviar email a informar que a palavra-passe foi alterada com sucesso
                    //-----------------------------------------------------------------------                   
                    require_once $_SERVER['DOCUMENT_ROOT'].'/projeto/mail/config.php';  //É usada a biblioteca PHPMailer para enviar o email

                    $mail->setFrom('noreplyprojetohospital@gmail.com', 'Hospital');
                    $mail->addAddress($email);
                
                    $mail->isHTML(true);
                    $mail->Subject = utf8_decode('A sua palavra-passe foi alterada!');
                
                    $mail->Body = utf8_decode('<b>Caro(a) '.$nome.',</b><br><br>A sua palavra-passe foi alterada com sucesso!');
                
                    $mail->send();

                    header("Location: /projeto/medico/definicoes/?success= Palavra-passe alterada com sucesso!");    //Mensagem de sucesso
                    exit();
                }
                else{  //Caso contrário
                    header("Location:  /projeto/medico/definicoes/?error= Erro!");    //Mensagem de erro
                    exit();
                }
            }
            else{  //Caso contrário
                header("Location: /projeto/medico/definicoes/?error2= As Palavras-passe não são iguais!");    //Mensagem de erro
                exit();
            }
        }
        else {  //Caso contrário
            header("Location: /projeto/medico/definicoes/?error1= Palavra-passe atual errada!");    //Mensagem de erro
            exit();
        }
    }
    else {
        header("Location: /projeto/medico/definicoes/");
        exit();
    }
?>