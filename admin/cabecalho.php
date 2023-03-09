<?php

date_default_timezone_set('America/Sao_Paulo');
(!isset($_SESSION)) ? session_start() : "";
$nivel = 1; //0,1 ou 2

if ($_SESSION['acesso'] != 'd033e22ae348aeb5660fc2140aec35850c4da997' OR $_SESSION['nivel'] < $nivel) {
    header("location:logout.php");
}

if (isset($_SESSION['start_login']) && (time() - $_SESSION['start_login'] > 600)) {
    header("location:logout.php");
}
$_SESSION['start_login'] = time();
