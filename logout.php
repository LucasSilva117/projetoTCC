<?php 
if(!isset($_SESSION)){
    session_start();
}

session_destroy();

echo "<script>alert('Você saiu da sua conta!');location.href='index.php';</script>";

?>