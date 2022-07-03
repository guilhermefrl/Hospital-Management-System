<?php
    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['alterar_dados'])){     //Caso o utente tenha alterado os seus dados e tenha clicado no botão para alterar os dados

        //Guardar os dados dos campos
        $nome_completo = $_POST['nome_completo'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $telemovel = $_POST['telemovel'];
        $data_nascimento = $_POST['data_nascimento'];
        $endereco = $_POST['endereco'];
        $cp4 = $_POST['cp4'];
        $cp3 = $_POST['cp3'];
        $ID_Utente = $_SESSION['ID_UTENTE'];
        $ID_Utilizador = $_SESSION['ID_UTILIZADOR'];

        //Query para ir buscar o ID de utilizador onde o nome de utilizador seja igual ao inserido
        $sql2 = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE USERNAME='$username' ";
        $result2 = mysqli_query($conn, $sql2);    //Executar a query na base de dados
        $row2 = mysqli_fetch_assoc($result2);     //Guardar na variável um array que corresponde aos dados da linha do resultado da query
        
        //Query para ir buscar o ID de utilizador onde o email seja igual ao inserido
        $sql3 = "SELECT utilizador.ID_UTILIZADOR FROM utilizador WHERE EMAIL='$email' ";
        $result3 = mysqli_query($conn, $sql3);   //Executar a query na base de dados
        $row3 = mysqli_fetch_assoc($result3);    //Guardar na variável um array que corresponde aos dados da linha do resultado da query

        //Caso já exista o nome de utilizador ou o email e seja de outro utilizador
        if((mysqli_num_rows($result2) > 0 && $row2['ID_UTILIZADOR'] != $ID_Utilizador) || (mysqli_num_rows($result3) > 0 && $row3['ID_UTILIZADOR'] != $ID_Utilizador)){
            header("Location: /projeto/utente/definicoes/?error3= Já existe este nome de utilizador ou email!");    //Mensagem de erro
            exit();
        }
        else{   //Caso contrário
            //Atualizar os dados na tabela utente
            $sql="UPDATE utente SET CP4 = '$cp4', CP3 = '$cp3', TELEMOVEL = '$telemovel', DATA_NASCIMENTO = '$data_nascimento', ENDERECO = '$endereco' WHERE utente.ID_UTENTE = $ID_Utente";
            $result = mysqli_query($conn, $sql);

            //Atualizar os dados na tabela utilizador
            $sql1="UPDATE utilizador SET USERNAME = '$username', NOME_COMPLETO = '$nome_completo', EMAIL = '$email' WHERE utilizador.ID_UTILIZADOR = $ID_Utilizador";
            $result1 = mysqli_query($conn, $sql1);

            if($result && $result1){    //Caso não tenha ocorrido nenhum erro
                
                //Guardar no array da sessão os novos dados do utilizador
                $_SESSION['USERNAME'] = $username;
                $_SESSION['NOME_COMPLETO'] = $nome_completo;
                $_SESSION['EMAIL'] = $email;
                $_SESSION['CP4'] = $cp4;
                $_SESSION['CP3'] = $cp3;
                $_SESSION['TELEMOVEL'] = $telemovel;
                $_SESSION['DATA_NASCIMENTO'] = $data_nascimento;
                $_SESSION['ENDERECO'] = $endereco;

                header("Location: /projeto/utente/definicoes/?success1= Dados alterados com sucesso!");    //Mensagem de sucesso
                exit();
            }
            else{   //Caso contrário
                header("Location: /projeto/utente/definicoes/?error= Erro!");    //Mensagem de erro
                exit();
            }
        }
    }
    else {
        header("Location: /projeto/utente/definicoes/");
        exit();
    }
?>