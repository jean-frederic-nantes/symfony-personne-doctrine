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
     * @Route("/add", name="personne_ajouter")
     */
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $personne = new Personne();
        // je crée un objet formulaire associée à l entity $personne
        $formPersonne = $this->createForm(PersonneType::class, $personne);
        // je viens hydrater $personne en fonction $requet
        // cad les donnees du formulaire
        $formPersonne->handleRequest($request);
        if ($formPersonne->isSubmitted()) {
            // recupérer la valeur de majeur
            $majeur =$formPersonne->get('majeur')->getData();
            if($majeur)
            {
            $em->persist($personne);
            $em->flush();
            }
            return $this->redirectToRoute('personne_liste');
        }

        return $this->render('personne/ajouter.html.twig', [
            'formPersonne' => $formPersonne->createView(),
        ]);
    }
    /**
     * @Route("/modifier/{id}", name="personne_modifier")
     */
    public function modifier(Personne $personne, Request $request, EntityManagerInterface $em): Response
    {
        $formPersonne = $this->createForm(PersonneType::class, $personne);
        $formPersonne->handleRequest($request);
        if ($formPersonne->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute('personne_liste');
        }

        return $this->render('personne/modifier.html.twig', [
            'formPersonne' => $formPersonne->createView(),
        ]);
    }
    /**
     * @Route("/ajouter-brut", name="personne_ajouter_brut")
     */
    public function ajouterBrut(Request $request, EntityManagerInterface $em): Response
    {
        // recuprer nom et prenom
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $personne = new Personne();
        $personne->setNom($nom);
        $personne->setPrenom($prenom);
        $em->persist($personne);
        $em->flush();
        return $this->redirectToRoute('personne_liste');
    }
}
