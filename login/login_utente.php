<?php

    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL

    //Caso o utilizador tenha inserido todos os campos obrigatórios do login e tenha clicado no botão para fazer login na visão do utente
    if(isset($_POST['login_utente'])){

        $u_nome = $_POST['u_nome'];
        $u_pass = $_POST['u_pass'];

        //Query para selecionar todos os elementos onde o nome de utilizador é igual ao inserido no login
        $sql = "SELECT * FROM utilizador WHERE USERNAME='$u_nome' ";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        if (mysqli_num_rows($result) === 1) {       //Caso exista um resultado
            $row = mysqli_fetch_assoc($result);     //Guardar na variável um array que corresponde aos dados da linha do resultado da query

            //Caso o nome de utilizador e a palavra-passe inseridos no login sejam iguais aos da base de dados e seja do tipo utente
            if ($row['USERNAME'] === $u_nome && password_verify($u_pass, $row['PASSWORD']) && $row['TIPO'] == 1) {

                //Guardar no array da sessão os dados do utilizador
                $_SESSION['ID_UTILIZADOR'] = $row['ID_UTILIZADOR'];
                $_SESSION['USERNAME'] = $row['USERNAME'];
                $_SESSION['NOME_COMPLETO'] = $row['NOME_COMPLETO'];
                $_SESSION['EMAIL'] = $row['EMAIL'];
                $_SESSION['TIPO'] = $row['TIPO'];

                $ID = $row['ID_UTILIZADOR'];
                
                //Query para selecionar todos os elementos onde o ID de utilizador é igual ao inserido
                $sql2 = "SELECT * FROM utente WHERE ID_UTILIZADOR='$ID'";
                $result2 = mysqli_query($conn, $sql2);        //Executar a query na base de dados
                $row1 = mysqli_fetch_assoc($result2);         //Guardar na variável um array que corresponde aos dados da linha do resultado da query

                //Guardar no array da sessão os dados do utilizador
                $_SESSION['CP4'] = $row1['CP4'];
                $_SESSION['CP3'] = $row1['CP3'];
                $_SESSION['TELEMOVEL'] = $row1['TELEMOVEL'];
                $_SESSION['GENERO'] = $row1['GENERO'];
                $_SESSION['DATA_NASCIMENTO'] = $row1['DATA_NASCIMENTO'];
                $_SESSION['GRUPO_SANGUINEO'] = $row1['GRUPO_SANGUINEO'];
                $_SESSION['ENDERECO'] = $row1['ENDERECO'];
                $_SESSION['ID_UTENTE'] = $row1['ID_UTENTE'];

                header("Location: /projeto/utente/");    //Redirecionar o utilizador para a visão dos utentes
                exit();
            }else{
                header("Location: /projeto/login/?error= Dados incorretos!");     //Mensagem de erro
                exit();
            }
        }
        else {
            header("Location: /projeto/login/?error= Dados incorretos!");     //Mensagem de erro
            exit();
        }
    }
    else {
        header("Location: /projeto/login/?error= Dados incorretos!");     //Mensagem de erro
        exit();
    }
?>