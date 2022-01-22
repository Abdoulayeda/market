<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\PanierContactType;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

class PanierController extends AbstractController
{


    //Fonction pour récuperer tout le panier  
    #[Route('/panier', name: 'panier_index')]
    public function index(SessionInterface $session, 
                           ProduitRepository $produitRepository, 
                           Request $request, 
                           MailerInterface $mailer): Response
    {
     $panier = $session->get("panier", []);
     $panierData =[];
     $total=0;
     foreach ($panier as $id => $quantite) {
       $produit=$produitRepository->find($id);
       $panierData[]=[
         'produit'=>$produit,
         'quantite'=>$quantite
       ];
       $total+=$produit->getPrix() * $quantite;
     }

          //Création du formulaire pour commander un panier
          $form = $this->createForm(PanierContactType::class);
          $contact = $form->handleRequest($request);
          if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                    ->from($contact->get('email')->getData())
                    ->to("abdoulayeda93@gmail.com")
                    ->subject("Commande de panier")
                    ->htmlTemplate('email/contactpanier.html.twig')
                    ->context([
                        'prenom'=>$contact->get('prenom')->getData(),
                        'nom'=>$contact->get('nom')->getData(),
                        'mail'=>$contact->get('email')->getData(),
                        'telephone'=>$contact->get('telephone')->getData(),
                        'adresse'=>$contact->get('adresse')->getData(),
                        'panierData'=>$panierData,
                        'total'=>$total  
                    ]);

            $mailer->send($email);
            return $this->redirectToRoute('panier_index');
                    
          }
        
          
        return $this->render('panier/index.html.twig', [
            'panierData' => $panierData,
            'total'=>$total,
            'form'=>$form->createView()
        ]);

      

    }

    //Fonction pour ajouter un produit dans le panier
    #[Route('/panier/{id}', name: 'panier_add')]
    public function add(SessionInterface $session, Produit $produit){
     $panier = $session->get("panier", []);
     $id=$produit->getId();
     if(!empty($panier[$id])){
       $panier[$id]++;
     }else{
       $panier[$id]=1;
     }
     $session->set('panier', $panier);
     return $this->redirectToRoute('panier_index');

    }

    #[Route('/panier/retire/{id}', name:'panier_retire')]
    public function retire(SessionInterface $session,Produit $produit){
      $panier = $session->get('panier',[]);
      $id=$produit->getid();
      if(!empty($panier[$id])){
        if($panier[$id]>1){
          $panier[$id]--;
        }else{
          unset($panier[$id]);
        }
      }
      $session->set("panier", $panier);
      return $this->redirectToRoute('panier_index');
    }

    #[Route('/panier/delete/{id}', name: 'panier_delete')]
    public function delete(SessionInterface $session, Produit $produit)
    {
      $panier = $session->get("panier", []);
      $id=$produit->getId();
      if(!empty($panier[$id])){
        unset($panier[$id]);
      }
      $session->set("panier", $panier);

      return $this->redirectToRoute('panier_index');

    }



}
