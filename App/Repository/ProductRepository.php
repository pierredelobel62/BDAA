<?php

namespace App\Repository;

use App\Entity\Product;
use Core\Repository\ORMRepository;

class ProductRepository extends ORMRepository
{

    public function __construct()
    {
        parent::__construct(Product::class);
    }

}