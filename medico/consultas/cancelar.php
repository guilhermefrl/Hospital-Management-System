<?php

    include $_SERVER['DOCUMENT_ROOT']."/projeto/connection/connection.php";     //Incluir a conexão com o servidor MySQL
    session_start();

    if(isset($_POST['s_cancelar'])){            //Caso o médico tenha clicado no botão para cancelar uma consulta
        $id_cancelar = $_POST['ID_CANCELAR'];   //Guardar o ID da consulta

        //Query para mudar o estado da consulta para 2, ou seja, cancelada
        $sql = "UPDATE pedido_consulta SET ESTADO = 2 WHERE pedido_consulta.ID_PEDIDO = $id_cancelar";
        $result = mysqli_query($conn, $sql);        //Executar a query na base de dados

        if($result){    //Caso não tenha existido nenhum erro
            header("Location: /projeto/medico/consultas/consultas_pendentes.php?success1= Consulta cancelada!");  //Mensagem de sucesso
        }
    }

?>