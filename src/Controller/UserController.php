<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
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
                $encodedPassword = $this->passwordEncoder->encodePassword($user, $password);
                $user->setPassword($encodedPassword);

                $user->setRoles(['ROLE_USER']);

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
