<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag", name="admin_tag_")
 * @package App\Controller\Admin
 */

class TagController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(TagRepository $tagRepo)
    {
        return $this->render('admin/tag/index.html.twig', [
            'tag' => $tagRepo->findAll(),
        ]);
    }
    /**
     * @Route("/ajout", name="ajout")
     */
    public function ajoutTag(Request $request)
    {
        $tag = new Tag;

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('admin_tag_home');
        }

        return $this->render('admin/tag/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function ModifTag(Tag $tag ,Request $request)
    {

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('admin_tag_home');
        }

        return $this->render('admin/tag/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Tag $tag)
    {
     
        $em = $this->getDoctrine()->getManager();
        $em->remove($tag);
        $em->flush();

        $this->addFlash('message', 'Service supprimé avec succès');
        return $this->redirectToRoute('admin_tag_home');       
    } 
}
