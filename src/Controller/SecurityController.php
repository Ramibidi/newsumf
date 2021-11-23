<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Conges;
use App\Entity\Upload;
use App\Form\CongeType;
use App\Form\UploadType;
//use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
//use Symfony\Component\BrowserKit\Request;
use Doctrine\Persistence\ObjectManager;
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
        /*
        $users = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findAll();
            */
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
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
     * @Route("/createConge", name="security_registrationConge")
     */
    public function registrationConge(Request $request)
    {
        /*
        $user = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findAll();
            */
        $conge = new Conges();
        $form2 = $this->createForm(CongeType::class, $conge);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            // you can fetch the EntityManager via $this->getDoctrine()
            // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
            $entityManager = $this->getDoctrine()->getManager();
            // tells Doctrine you want to save the conge
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
            'form2' => $form2->createView(), /*'users' => $user,*/ 'conge' => $conge
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










    /**
     * @Route("/upload", name="security_upload")
     */
    public function profile_user(Request $request)
    {
        $upload = new Upload;
        $user = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findAll();
        $form3 = $this->createForm(UploadType::class, $upload);
        $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            $file = $upload->getName();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory', $fileName));
            $upload->setName($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('user/upload.html.twig', ['user' => $user,  'form3' => $form3->createView()]);
    }


    /**
     * @Route("/uplod", name="uplod")
     */
    public function nvroute()
    {

        $users = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findAll();
        return $this->render(
            'security/registration2.html.twig',
            ['users' => $users]
        );
    }
}
