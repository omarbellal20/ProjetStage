<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
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

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */
    public function index(): Response
    {
       $rep=$this->getDoctrine()->getRepository(Site::class);

       $sites = $rep->findAll();
       
        return $this->render('site/index.html.twig', [
            'sites' => $sites,
        ]);
    }

    /**
      * @Route("/admin", name="admin")
      */
      public function homepage()
      {
          //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
          return $this->render('home/admin.html.twig');
      }

    /**
      * @Route("/site/new", name="create_site")
      */
      public function createSite(Request $request,EntityManagerInterface $manager)
      {
        $site = new Site();  

        $form=$this->createForm(SiteType::class,$site);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($site);
            $manager->flush();
        }
        
        return $this->render('site/new.html.twig',[
            'form'=>$form->createView()
          ]);
      }



    /**
      * @Route("/site/edit/{id}", name="modify_site")
      */
      public function editSite(Site $site,Request $request,EntityManagerInterface $manager)
      {
        $form=$this->createForm(SiteType::class,$site);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($site);
            $manager->flush();

            return $this->redirectToRoute("site");
        }
        
        return $this->render('site/edit.html.twig',[
            'form'=>$form->createView(),
            'site'=>$site
          ]);
      }



      
    /**
      * @Route("/site/delete/{id}", name="sup_site")
      */
      public function deleteSite(Site $site,EntityManagerInterface $manager)
      {
           
            $manager->remove($site);
            $manager->flush();
        
        return $this->redirectToRoute("site",[
            'id'=>$site->getId()
          ]);
      }


    /**
      * @Route("/site/show/{id}", name="show_site")
      */
      public function showSite(Site $site)
      {
        
        return $this->render('site/show.html.twig',[
            'monsite'=>$site
          ]);
      }

}
