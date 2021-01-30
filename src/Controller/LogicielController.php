<?php

namespace App\Controller;

use App\Entity\Logiciel;
use App\Form\LogicielType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

  /**
    * Require ROLE_ADMIN for *every* controller method in this class.
    *
    * @IsGranted("ROLE_ADMIN")
    */

class LogicielController extends AbstractController
{
    /**
     * @Route("/logiciel", name="logiciel")
     */
    public function index(): Response
    {

        $rep=$this->getDoctrine()->getRepository(Logiciel::class);

        $logiciel = $rep->findAll();
        
         return $this->render('logiciel/index.html.twig', [
             'logiciels' => $logiciel,
         ]);
     
    }



    
    /**
      * @Route("/logiciel/new", name="create_logiciel")
      */
      public function createlogiciel(Request $request,EntityManagerInterface $manager)
      {
        $logiciel = new Logiciel();  

        $form=$this->createForm(LogicielType::class,$logiciel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($logiciel);
            $manager->flush();
        }
        
        return $this->render('logiciel/new.html.twig',[
            'form'=>$form->createView()
          ]);
      }



    /**
      * @Route("/logiciel/edit/{id}", name="modify_logiciel")
      */
      public function editlogiciel(Logiciel $logiciel,Request $request,EntityManagerInterface $manager)
      {
        $form=$this->createForm(LogicielType::class,$logiciel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($logiciel);
            $manager->flush();

            return $this->redirectToRoute("logiciel");
        }
        
        return $this->render('logiciel/edit.html.twig',[
            'form'=>$form->createView(),
            'logiciel'=>$logiciel
          ]);
      }



      
    /**
      * @Route("/logiciel/delete/{id}", name="sup_logiciel")
      */
      public function deletelogiciel(Logiciel $logiciel,EntityManagerInterface $manager)
      {
           
            $manager->remove($logiciel);
            $manager->flush();
        
        return $this->redirectToRoute("logiciel",[
            'id'=>$logiciel->getId()
          ]);
      }


    /**
      * @Route("/logiciel/show/{id}", name="show_logiciel")
      */
      public function showlogiciel(Logiciel $logiciel)
      {
        
        return $this->render('logiciel/show.html.twig',[
            'monlogiciel'=>$logiciel
          ]);
      }

}
