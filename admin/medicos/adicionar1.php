<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['adicionar_especialidade'])){ //Caso o administrador tenha clicado no botão para adicionar uma nova especialidade

        $nome = $_POST['especialidade'];    //Guardar o nome da especialidade inserida no campo

        //Query para inserir na tabela especialidades a nova especialidade
        $sql = "INSERT INTO especialidades (NOME) values('$nome')";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        if($result){         //Caso não tenha ocorrido nenhum erro
            header("Location: /projeto/admin/medicos/adicionar_especialidades.php?success= Especialidade Adicionada!"); //Mensagem de sucesso
        }
        else{       //Caso contrário
            header("Location: /projeto/admin/medicos/adicionar_especialidades.php?error= Erro!"); //Mensagem de erro
        }
    }
    else{
        header("Location: /projeto/admin/");
    }

?>