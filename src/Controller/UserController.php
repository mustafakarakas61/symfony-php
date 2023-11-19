<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Çıkış işlemi burada işlenir
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        try{
            if ($request->isMethod('POST')) {
                $user = new User();
                $user->setUsername($request->request->get('username'));
                $user->setEmail($request->request->get('email'));

                $password = $request->request->get('password');
                $user->setPassword($password);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return $this->render('user/register.html.twig',[
            'error' => $error ?? null,
        ]);
    }
}
