<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('Core/Autoload.php');
Autoload::register();

use App\Entity\Product;
use App\Repository\ProductRepository;

$pr = new ProductRepository();

// insert
$product = new Product();
$product->setField('salut');
$pr->save($product);

// get one
$product = $pr->get(15);
var_dump($product);


// update
$product->setField('Salut MEK');
$pr->save($product);

// get list
echo '<h1>Liste des produits : </h1>';
$products = $pr->getList();
var_dump($products);

// delete
// $pr->delete($product);