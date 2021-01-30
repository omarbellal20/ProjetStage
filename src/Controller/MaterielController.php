<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
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

class MaterielController extends AbstractController
{
    /**
     * @Route("/materiel", name="materiel")
     */
    public function index(): Response
    {
        $rep=$this->getDoctrine()->getRepository(Materiel::class);

        $materiel = $rep->findAll();
        
         return $this->render('materiel/index.html.twig', [
             'materiels' => $materiel,
         ]);
     
    }

    
    /**
      * @Route("/materiel/new", name="create_materiel")
      */
      public function createmateriel(Request $request,EntityManagerInterface $manager)
      {
        $materiel = new Materiel();  

        $form=$this->createForm(MaterielType::class,$materiel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($materiel);
            $manager->flush();
        }
        
        return $this->render('materiel/new.html.twig',[
            'form'=>$form->createView()
          ]);
      }



    /**
      * @Route("/materiel/edit/{id}", name="modify_materiel")
      */
      public function editmateriel(Materiel $materiel,Request $request,EntityManagerInterface $manager)
      {
        $form=$this->createForm(MaterielType::class,$materiel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($materiel);
            $manager->flush();

            return $this->redirectToRoute("materiel");
        }
        
        return $this->render('materiel/edit.html.twig',[
            'form'=>$form->createView(),
            'materiel'=>$materiel
          ]);
      }



      
    /**
      * @Route("/materiel/delete/{id}", name="sup_materiel")
      */
      public function deletemateriel(Materiel $materiel,EntityManagerInterface $manager)
      {
           
            $manager->remove($materiel);
            $manager->flush();
        
        return $this->redirectToRoute("materiel",[
            'id'=>$materiel->getId()
          ]);
      }


    /**
      * @Route("/materiel/show/{id}", name="show_materiel")
      */
      public function showmateriel(Materiel $materiel)
      {
        
        return $this->render('materiel/show.html.twig',[
            'monmateriel'=>$materiel
          ]);
      }

}
