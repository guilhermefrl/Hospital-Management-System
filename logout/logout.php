<?php 
session_start();

session_unset();        //Liberta todas as variáveis da sessão
session_destroy();      //Destrói todos os dados associados à sessão atual

header("Location: /projeto/login/");    //Redireciona o utilizador para a página de login