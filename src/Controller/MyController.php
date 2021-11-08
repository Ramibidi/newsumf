<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
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
        $users = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findAll();
        return $this->redirectToRoute('blog', ['users' => $users]);
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
     * @Route("/profile/{id}", name="your_profile")
     */
    public function profileUser($id)
    {
        $users = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->find($id);
        return $this->render('user/yourProfile.html.twig', ['user' => $users]);
    }
}
