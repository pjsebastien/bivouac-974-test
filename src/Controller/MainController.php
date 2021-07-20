<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Form\SearchBivouacType;
use App\Repository\BivouacRepository;
use App\Repository\CommentRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(BivouacRepository $bivouacRepo, TagRepository $tagsRepo, CommentRepository $commentRepo, Request $request): Response
    {
        $bivouac = $bivouacRepo->findBy(['active' => true], ['created_at' => 'desc'], 20);
        $form = $this->createForm(SearchBivouacType::class);
        $search = $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){
            $bivouac = $bivouacRepo->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
                
        );
        }

        return $this->render('main/index.html.twig', [
            'bivouacs' => $bivouac ,
            'tag' => $tagsRepo->findAll(),
            'totalBivouac' => $bivouacRepo->findAll(),
            'form' => $form->createView(),
            

            //dd($tagsRepo->findAll())
        ]);
    }

    
}
