<?php

namespace App\Service;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

class CustomerService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCustomerById($id)
    {
        return $this->entityManager->getRepository(Customer::class)->find($id);
    }

    public function getAllCustomers()
    {
        return $this->entityManager->getRepository(Customer::class)->findAll();
    }

    public function saveCustomer(Customer $customer)
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    public function deleteCustomer(Customer $customer)
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}
