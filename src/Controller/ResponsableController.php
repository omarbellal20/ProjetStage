<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

  /**
    * Require ROLE_ADMIN for *every* controller method in this class.
    *
    * @IsGranted("ROLE_ADMIN")
    */


class ResponsableController extends AbstractController
{
    /**
     * @Route("/responsable", name="responsable")
     */
    public function index(): Response
    {
        $rep=$this->getDoctrine()->getRepository(User::class);

        $users = $rep->findAll();
        
         return $this->render('responsable/index.html.twig', [
             'users' => $users,
         ]);
    }



    
    /**
      * @Route("/responsable/new", name="create_responsable")
      */
      public function createresponsable(Request $request,EntityManagerInterface $manager,
      UserPasswordEncoderInterface $encoder)
      {
          $user = new User();
  
          $form = $this->createForm(RegistrationType::class, $user);
  
          $form->handleRequest($request);
  
          if($form->isSubmitted() && $form->isValid()){
              $hash = $encoder->encodePassword($user, $user->getPassword());
  
              $user->setPassword($hash);
    
              $manager->persist($user);
              $manager->flush();
  
              return $this->redirectToRoute('responsable');
          }
          
          return $this->render('responsable/add.html.twig', [
              'form' => $form->createView(),
          ]);
      }


    /**
      * @Route("/responsable/edit/{id}", name="modify_responsable")
      */
      public function editresponsable(User $responsable,Request $request,EntityManagerInterface $manager)
      {
        $form=$this->createForm(RegistrationType::class,$responsable);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($responsable);
            $manager->flush();

            return $this->redirectToRoute("responsable");
        }
        
        return $this->render('responsable/edit.html.twig',[
            'form'=>$form->createView(),
            'responsable'=>$responsable
          ]);
      }



      
    /**
      * @Route("/responsable/delete/{id}", name="sup_responsable")
      */
      public function deleteresponsable(User $responsable,EntityManagerInterface $manager)
      {
           
            $manager->remove($responsable);
            $manager->flush();
        
        return $this->redirectToRoute("responsable",[
            'id'=>$responsable->getId()
          ]);
      }


    /**
      * @Route("/responsable/show/{id}", name="show_responsable")
      */
      public function showresponsable(User $responsable)
      {
        
        return $this->render('responsable/show.html.twig',[
            'monresponsable'=>$responsable
          ]);
      }

}
