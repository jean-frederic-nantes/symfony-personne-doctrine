<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="personne_liste")
     */
    public function liste(PersonneRepository $repo): Response
    {
       $tab = $repo->findAll();
       //dump($tab);
       
        return $this->render('personne/liste.html.twig', [
            'personnes' => $tab,
        ]);
    }

     /**
     * @Route("/ajouter", name="personne_ajouter")
     */
    public function ajouter(EntityManagerInterface $em): Response
    {
      // Entity Mananger
      $personne = new Personne();
      $personne->setNom('DOE');
      $personne->setPrenom('John');
      //mettre la personne à disposition de l'entityMananger
      $em->persist($personne);
      $em->flush(); // on sauvegaer en base de données
      // redirection vers la route personne_liste
      return $this->redirectToRoute('personne_liste');


    }
}