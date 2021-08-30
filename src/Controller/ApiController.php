<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/personne", name="api_liste", methods={"GET"})
     */
    public function liste(PersonneRepository $repo): Response
    {
        $tab = $repo->findAll();
       // $tab["message"] = "Liste de personnes";
        return $this->json($tab);
    }

     /**
     * @Route("/api/personne", name="api_ajouter", methods={"POST"})
     */
    public function ajouter(Request $req,EntityManagerInterface $em): Response
    {
        // objet PHP = un objet JS (body) 
        $objet = json_decode($req ->getContent());
        //$objet->nom;
        //$objet->prenom;
        $p = new Personne();
        $p->setNom($objet->nom);
        $p->setPrenom($objet->prenom);
        $em->persist($p);
        $em->flush();
        return $this->json($p);
    }

       /**
     * @Route("/api/personne/{id}", name="api_modifier", methods={"PUT"})
     */
    public function modifier(Personne $personne,Request $req,EntityManagerInterface $em): Response
    {
       // objet PHP = un objet JS (body) 
       $objet = json_decode($req ->getContent());
       // hydrater la personne
       $personne->setNom($objet->nom);
       $personne->setPrenom($objet->prenom);
       $em->flush();

        return $this->json($personne);
    }

          /**
     * @Route("/api/personne/{id}", name="api_delete", methods={"DELETE"})
     */
    public function delete(Personne $personne,EntityManagerInterface $em): Response
    {
      $em->remove($personne);
      $em->flush();
      return $this->json($personne);
    }


}
