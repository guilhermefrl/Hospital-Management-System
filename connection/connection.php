<?php

$user = 'root';
$pass = '';
$db = 'bd_projeto';

$conn = new mysqli('localhost', $user, $pass, $db);     //Criar uma nova conexão com o servidor MySQL
$conn->set_charset("utf8");        //Definir o conjunto de carateres como utf8

if (!$conn){                    //Caso não exista conexão com o MySQL
    echo "Falha na conexão!";   //Mensagem de erro
}