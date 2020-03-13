<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('Core/Autoload.php');
Autoload::register();

use App\Entity\Product;
use App\Repository\ProductRepository;

$pr = new ProductRepository();
// $product = new Product();
// $product->setField('salut');

// $product = $pr->get(10);
// var_dump($product);



// $product->setField('Salut MEK');
// $pr->save($product);
echo '<h1>Liste des produits : </h1>';
$products = $pr->getList();
var_dump($products);

// $pr->delete($product);