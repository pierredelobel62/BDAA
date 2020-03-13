<?php

namespace App\Repository;

use App\Entity\Customer;
use Core\Repository\ORMRepository;

class CustomerRepository extends ORMRepository
{

    public function __construct()
    {
        parent::__construct(Customer::class);
    }

}