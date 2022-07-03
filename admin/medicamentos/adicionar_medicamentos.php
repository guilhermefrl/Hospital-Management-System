<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['adicionar'])){ //Caso o administrador tenha clicado no botão para adicionar um novo medicamento

        //Guardar os dados inseridos nos campos
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $laboratorio = $_POST['laboratorio'];
        $preco = $_POST['preco'];

        //Query para inserir na tabela medicamento os dados no novo medicamento
        $sql = "INSERT INTO medicamento (NOME, DESCRICAO, LABORATORIO, PRECO) values('$nome', '$descricao', '$laboratorio', '$preco')";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        if($result){         //Caso não tenha ocorrido nenhum erro
            header("Location: /projeto/admin/medicamentos/index.php?success= Medicamento Adicionado!");     //Mensagem de sucesso
        }
    }
    else{
        header("Location: /projeto/admin/");
    }

?>