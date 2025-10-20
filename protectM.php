<?php 
//proteção das páginas da recepção
if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['CPFM']) && !isset($_SESSION['CPFA'])){
    die("Você não tem acesso á essa página, faça o login. <p><a href=\"index.php\">Entrar</a></p>");
}

?>