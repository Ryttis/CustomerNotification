<?php

namespace App\EntityRepository;

use App\Entity\Customer;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * Get the entity class.
     *
     * @return string
     */
    public function getEntityClass(): string
    {
        return Customer::class;
    }
}
