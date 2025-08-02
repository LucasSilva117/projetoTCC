<?php 
if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['CPFR'])){
    die("Você não tem acesso á essa página, faça o login. <p><a href=\"index.php\">Entrar</a></p>");
}

?>