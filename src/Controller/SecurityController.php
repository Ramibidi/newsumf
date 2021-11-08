<?php

namespace App\Controller;

use App\Entity\Conges;
use App\Entity\News;
use App\Form\CongeType;
use App\Entity\Utilisateur;
//use Doctrine\Persistence\ObjectManager;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            // tells Doctrine you want to save the User
            $entityManager->persist($user);
            //executes the queries (i.e. the INSERT query) 
            $entityManager->flush();
            //return $this->redirectToRoute('security_login');
        }

        $users = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($users as $user) {
                $temp = array(
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'roles' => $user->getRoles(),

                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(), 'users' => $users
        ]);
    }





    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {

        return $this->render('security/login.html.twig');
        // $this->redirectToRoute('blog');

    }






    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
        //return $this->render('security/login.html.twig');
    }



    /**
     * @Route("/inscriptionConge/{id}", name="security_registrationConge")
     */
    public function registrationConge($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->find($id);
        $conge = new Conges();
        $form2 = $this->createForm(CongeType::class, $conge);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            // you can fetch the EntityManager via $this->getDoctrine()
            // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
            $entityManager = $this->getDoctrine()->getManager();
            // tells Doctrine you want to save the User
            $entityManager->persist($conge);
            //executes the queries (i.e. the INSERT query) 
            $entityManager->flush();
            //return $this->redirectToRoute('security_login');

        }
        $conge = $this->getDoctrine()
            ->getRepository(Conges::class)
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($conge as $user) {
                $temp = array(
                    'startdate' => $user->getStartdate(),
                    'numberdays' => $user->getNumberdays(),
                    'status' => $user->getStatus(),

                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        }

        return $this->render('security/registrationConge.html.twig', [
            'form2' => $form2->createView(), 'users' => $user, 'conge' => $conge
        ]);
    }




    /**
     * @Route("/actuality", name="security_actuality")
     */
    public function actuality(Request $request)
    {
        $actulality = $this->getDoctrine()->getManager();

        $categories = $actulality->getRepository(News::class)->findAll();

        return $this->render('actulality/affiche.html.twig', array(
            'categ' => $categories
        ));
    }
}
