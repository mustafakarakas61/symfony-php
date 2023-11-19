<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    /**
     * @Route("/order/list", name="order_list")
     */
    public function listOrders(): Response
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();

        return $this->render('order/list.html.twig', [
            'orders' => $orders,
        ]);
    }
}