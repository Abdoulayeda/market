<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Form\ProduitContactType;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

class ProduitController extends AbstractController
{
    #[Route('/', name: 'produit_index')]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);

    }

    #[Route('/produit/show/{id}', name: 'produit_show')]
    public function show(Produit $produit): Response
    {
     return $this->render('produit/show.html.twig',['produit'=>$produit,]);

    }
}
