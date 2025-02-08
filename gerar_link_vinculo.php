<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estabelecimento') {
    echo "Acesso negado!";
    exit();
}

$estabelecimento_id = $_SESSION['id'];
$link = "vincular_cliente.php?estabelecimento=" . $estabelecimento_id;

echo $link;
?>
