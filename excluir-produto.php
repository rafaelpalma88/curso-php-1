<?php


require "src/conexao-bd.php";
require "src/Model/Product.php";
require "src/Repository/ProductRepository.php";

//var_dump($_GET);

$id = $_POST["id"];

$produtosRepositorio = new ProductRepository($pdo);
$produtosRepositorio->removeItem($id);

header("Location: admin.php");