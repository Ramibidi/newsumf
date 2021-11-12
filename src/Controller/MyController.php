<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Conges;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyController extends AbstractController
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function afficheAccueil()
    {
        return $this->render('user/afficheAccueil.html.twig');
    }

    /**
     * @Route("/")
     */
    public function affiche()
    {

        return $this->redirectToRoute('your_profile');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function accueil()
    {

        return $this->render('user/welcome.html.twig');
    }
    /**
     * @Route("/twig")
     */
    public function twig(Environment $twig)
    {
        return new Response($twig->render('pages/yourProfile.html.twig'));
    }

    /**
     * @Route("/profile", name="your_profile")
     */
    public function profileUser(Security $security)
    {

        $userName = $security->getUser()->getUsername();
        //$entityManager = $this->getDoctrine()->getManager();
        // $user = $entityManager->getRepository('App:Utilisateur')->findOneBy(array('username' => $userName));
        //$id = $entityManager->getRepository('App:Utilisateur')->findOneBy(array('id' => $userName));
        return $this->render('user/yourProfile.html.twig', ['user' => $userName]);
    }


    /**
     * @Route("/adminhistorique", name="conge_historique")
     */
    public function historique()
    {

        $conge = $this->getDoctrine()
            ->getRepository(Conges::class)
            ->findAll();
        return $this->render('admin/historique.html.twig', ['conge' => $conge]);
    }



    /**
     * @Route("/valider/{id}", name="conge_valider")
     */
    public function valider(EntityManagerInterface $manager, $id)

    {

        $conge = $this->getDoctrine()->getRepository(Conges::class)->find($id);

        // $conge = new Conge();



        $conge->setStatus = 'VALIDEE';
        //$conge->setStatus('VALIDEE');

        $manager->persist($conge);

        $manager->flush();




        return $this->render('user/historique.html.twig', ["conge" => $conge]);
    }


    /**
     * @Route("/refuser/{id}", name="conge_refuser")
     */
    public function refuser(EntityManagerInterface $manager, $id)

    {

        $conge = $this->getDoctrine()->getRepository(Conges::class)->find($id);

        // $conge = new Conge();



        $conge->setStatus = 'REFUSE';

        $manager->persist($conge);

        $manager->flush();




        return $this->render('user/historiquerefuse.html.twig', ["conge" => $conge]);
    }
}
