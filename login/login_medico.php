<?php

    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL

    //Caso o utilizador tenha inserido todos os campos obrigatórios do login e tenha clicado no botão para fazer login na visão do médico
    if(isset($_POST['login_medico'])){ 

        $m_nome = $_POST['m_nome'];
        $m_pass = $_POST['m_pass'];

        //Query para selecionar todos os elementos onde o nome de utilizador é igual ao inserido no login
        $sql = "SELECT * FROM utilizador WHERE USERNAME='$m_nome' ";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        if (mysqli_num_rows($result) === 1) {       //Caso exista um resultado
            $row = mysqli_fetch_assoc($result);     //Guardar na variável um array que corresponde aos dados da linha do resultado da query

            //Caso o nome de utilizador e a palavra-passe inseridos no login sejam iguais aos da base de dados e seja do tipo médico
            if ($row['USERNAME'] === $m_nome && password_verify($m_pass, $row['PASSWORD']) && $row['TIPO'] == 2) {

                //Guardar no array da sessão os dados do utilizador
                $_SESSION['ID_UTILIZADOR'] = $row['ID_UTILIZADOR'];
                $_SESSION['USERNAME'] = $row['USERNAME'];
                $_SESSION['NOME_COMPLETO'] = $row['NOME_COMPLETO'];
                $_SESSION['EMAIL'] = $row['EMAIL'];
                $_SESSION['TIPO'] = $row['TIPO'];

                $ID = $row['ID_UTILIZADOR'];

                //Query para selecionar todos os elementos das tabelas medico e especialidade onde o ID de utilizador é igual ao inserido
                $sql2 = "SELECT medico.ID_MEDICO, medico.EXPERIENCIA, especialidades.NOME FROM medico, especialidades WHERE medico.ESPECIALIDADE=especialidades.ID_ESPECIALIDADE AND ID_UTILIZADOR='$ID'";
                $result2 = mysqli_query($conn, $sql2);        //Executar a query na base de dados
                $row1 = mysqli_fetch_assoc($result2);         //Guardar na variável um array que corresponde aos dados da linha do resultado da query

                //Guardar no array da sessão os dados do utilizador
                $_SESSION['ESPECIALIDADE'] = $row1['NOME'];
                $_SESSION['EXPERIENCIA'] = $row1['EXPERIENCIA'];
                $_SESSION['ID_MEDICO'] = $row1['ID_MEDICO'];

                header("Location: /projeto/medico/");   //Redirecionar o utilizador para a visão dos médicos
                exit();
            }else{
                header("Location: /projeto/login/?error1= Dados incorretos!");     //Mensagem de erro
                exit();
            }
        }
        else {
            header("Location: /projeto/login/?error1= Dados incorretos!");     //Mensagem de erro
            exit();
        }
    }
    else {
        header("Location: /projeto/login/?error1= Dados incorretos!");     //Mensagem de erro
        exit();
    }
?>