<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/", name="acceuil")
     */
    public function acceuil(EntityManagerInterface $manager, UserPasswordHasherInterface $hasher)
    {
        /*  $user = new User();
         $user->setEmail('aliou@gmail.com');
         $password = $hasher->hashPassword($user, 'diaoaliou');
         $user->setPassword($password);

         $manager->persist($user);
         $manager->flush(); */

        return $this->render('home/acceuil.html.twig');
    }
}
