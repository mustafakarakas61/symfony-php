<?php

// src/Controller/CustomerController.php

namespace App\Controller;

use App\Entity\Customer;
use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @Route("/customers/{id}", name="get_customer", methods={"GET"})
     */
    public function getCustomer($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            return new JsonResponse(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        $customerData = [];
        $customerData[] = [
            'id' => $customer->getId(),
            'username' => $customer->getUsername(),
            'email' => $customer->getEmail(),
        ];

        $jsonData = json_encode($customerData);

        return new JsonResponse($jsonData, 200, [], true);
    }

    /**
     * @Route("/customers", name="get_all_customers", methods={"GET"})
     */
    public function getAllCustomers()
    {
        $customers = $this->customerService->getAllCustomers();
//        dump($customers);

        $customerData = [];
        foreach ($customers as $customer) {
            $customerData[] = [
                'id' => $customer->getId(),
                'username' => $customer->getUsername(),
                'email' => $customer->getEmail(),
            ];
        }

        $jsonData = json_encode($customerData);

        return new JsonResponse($jsonData, 200, [], true);
    }

    /**
     * @Route("/customers", name="create_customer", methods={"POST"})
     */
    public function createCustomer(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $customer = new Customer();
        $customer->setUsername($data['username']);
        $customer->setEmail($data['email']);

        $this->customerService->saveCustomer($customer);

        return new JsonResponse(['message' => 'Customer created'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/customers/{id}", name="delete_customer", methods={"DELETE"})
     */
    public function deleteCustomer($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            return new JsonResponse(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        $this->customerService->deleteCustomer($customer);

        return new JsonResponse(['message' => 'Customer deleted']);
    }
}
