<?php

namespace App\Controller;

use App\Entity\Customer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", name="customer_list")
     */
    public function listCustomers(): Response
    {
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        return $this->render('customer/customer.html.twig', [
            'customers' => $customers,
        ]);
    }

    /**
     * @Route("/customer/add", name="customer_add")
     */
    public function addCustomer(Request $request): Response
    {
        $username = $request->request->get('new_customer_username');
        $email = $request->request->get('new_customer_email');

        $customer = new Customer();
        $customer->setUsername($username);
        $customer->setEmail($email);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($customer);
        $entityManager->flush();

        $this->addFlash('success', 'Müşteri başarıyla eklendi.');

        return $this->redirectToRoute('customer_list');
    }

    #[Route('/delete/{id}', name: 'customer_delete')]
    public function deleteUser($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Customer::class)->find($id);

        if (!$customer) {
            throw $this->createNotFoundException('Müşteri bulunamadı');
        }

        $orders = $customer->getOrders();

        foreach ($orders as $order) {
            $entityManager->remove($order);
        }

        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->redirectToRoute('customer_list');
    }
}