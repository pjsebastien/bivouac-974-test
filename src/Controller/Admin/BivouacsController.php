<?php

namespace App\Controller\Admin;

use App\Entity\Bivouac;
use App\Repository\BivouacRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/bivouacs", name="admin_bivouacs_")
 * @package App\Controller\Admin
 */

class BivouacsController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BivouacRepository $bivouacsRepo): Response
    {
        return $this->render('admin/bivouacs/index.html.twig', [
            'bivouacs' => $bivouacsRepo->findAll(),
        ]);
    }
    /**
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(Bivouac $bivouac)
    {
        $bivouac->setActive(($bivouac->getActive())?false:true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($bivouac);
        $em->flush();

        return new Response("true");
        
    }
    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Bivouac $bivouac)
    {
        $images = $bivouac->getImages();
        if($images){
            foreach ($images as $image) {
                $nomImage = $this->getParameter("images_directory")."/".$image->getName();
                if(file_exists($nomImage)){
                    unlink($nomImage);
                }                
            }
        }      
        $em = $this->getDoctrine()->getManager();
        $em->remove($bivouac);
        $em->flush();

        $this->addFlash('message', 'Bivouac supprimé avec succès');
        return $this->redirectToRoute('admin_bivouacs_home');       
    }   
}
