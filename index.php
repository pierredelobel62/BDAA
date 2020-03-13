<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('Core/Autoload.php');
Autoload::register();

use App\Entity\Product;
use App\Entity\Customer;
use App\Repository\ProductRepository;
use App\Repository\CustomerRepository;
use Core\Migration\MigrationManager;

$pr = new ProductRepository();
$cr = new CustomerRepository();

$mm = new MigrationManager();
$mm->migrateTable('category');

// insert
$product = new Product();
$product->setName('salut');
$pr->save($product);
echo 'Insertion du produit ' . $product->getName();
echo '<br/>';

$customer = new Customer();
$customer->setName('Pierre');
$cr->save($customer);
echo 'Insertion du customer ' . $customer->getName();
echo '<br/>';

// get one
$id = 1;
$product = $pr->get($id);
echo 'Sélection du produit ' . $id . ' ' . $product->getName();
echo '<br/>';

$id = 1;
$customer = $cr->get($id);
echo 'Sélection du customer ' . $id . ' ' . $customer->getName();
echo '<br/>';


// update
$product->setName('Salut MEK');
$pr->save($product);
echo 'Modification du produit ' . $product->getName();
echo '<br/>';

$customer->setName('Pierrot');
$cr->save($customer);
echo 'Modification du customer ' . $customer->getName();
echo '<br/>';

// get list
echo 'Liste des produits :';
$products = $pr->getList();
var_dump($products);

echo 'Liste des customers :';
$customers = $cr->getList();
var_dump($customers);

// delete
// $pr->delete($product);
// $cr->delete($customer);