<?php

    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL

    //Caso o utilizador tenha inserido todos os campos obrigatórios do login e tenha clicado no botão para fazer login na visão do administrador
    if(isset($_POST['login_admin'])){

        $a_nome = $_POST['a_nome'];
        $a_pass = $_POST['a_pass'];

        //Query para selecionar todos os elementos onde o nome de utilizador é igual ao inserido no login
        $sql = "SELECT * FROM utilizador WHERE USERNAME='$a_nome' ";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        if (mysqli_num_rows($result) === 1) {       //Caso exista um resultado
            $row = mysqli_fetch_assoc($result);     //Guardar na variável um array que corresponde aos dados da linha do resultado da query

            //Caso o nome de utilizador e a palavra-passe inseridos no login sejam iguais aos da base de dados e seja do tipo administrador
            if ($row['USERNAME'] === $a_nome && password_verify($a_pass, $row['PASSWORD']) && $row['TIPO'] == 3) {

                //Guardar no array da sessão os dados do utilizador
                $_SESSION['ID_UTILIZADOR'] = $row['ID_UTILIZADOR'];
                $_SESSION['USERNAME'] = $row['USERNAME'];
                $_SESSION['NOME_COMPLETO'] = $row['NOME_COMPLETO'];
                $_SESSION['EMAIL'] = $row['EMAIL'];
                $_SESSION['TIPO'] = $row['TIPO'];

                header("Location: /projeto/admin/");    //Redirecionar o utilizador para a visão dos administradores
                exit();
            }else{
                header("Location: /projeto/login/?error2= Dados incorretos!");     //Mensagem de erro
                exit();
            }
        }
        else {
            header("Location: /projeto/login/?error2= Dados incorretos!");     //Mensagem de erro
            exit();
        }
    }
    else {
        header("Location: /projeto/login/?error2= Dados incorretos!");     //Mensagem de erro
        exit();
    }
?>