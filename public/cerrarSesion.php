<?php
require_once('../private/initialize.php');
unset($_SESSION['ApuestaTotal_idUsuario']);
unset($_SESSION['ApuestaTotal_nombre']);
unset($_SESSION['ApuestaTotal_cargo']);
session_destroy();
header('Location: index.php');
?>