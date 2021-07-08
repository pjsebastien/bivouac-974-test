<?php

namespace App\Controller;

use App\Entity\Bivouac;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\BivouacRepository;
use App\Repository\CategoriesRepository;
use App\Repository\CommentRepository;
use App\Repository\RegionRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/bivouacs", name="bivouacs_")
     * @package App\Controller
     */

class BivouacsController extends AbstractController
{
    /**
     * @Route("/", name="liste")
     * @return voidk
     */
    public function index(BivouacRepository $bivouacsRepo,CategoriesRepository $CatRepo,RegionRepository $RegionRepo, Request $request){
        //On définit le nombre d'élément par package
        $limit = 6;
        //On récupère le num de page
        $page = (int)$request->query->get("page", 1);

        //On récupère les filtres
        $filtersCat = $request->get("categories");
        //il faut laisser region sans s car c'est le name
        $filtersReg = $request->get("region");
        
        //On recup les bivouacs en fonction du filtre
        $bivouacs = $bivouacsRepo->getPaginatedBivouac($page, $limit, $filtersCat, $filtersReg);
        //On récup le total de bivouac
        $total= $bivouacsRepo->getTotalBivouac($filtersCat, $filtersReg);
        
        //On vérifie si on a une requête ajax
        //Si on en a une on envoie les données en json
        if($request->get('ajax')){
            return new JsonResponse([
                'content' =>$this->renderView('bivouacs/_bivouacCard.html.twig', compact('bivouacs', 'total', 'limit', 'page'))
            ]);
        }

        //On récupère toute les catégories
        $categories= $CatRepo->findAll();
        $regions = $RegionRepo->findAll();
        
        //On ajoute dans le compact pour pouvoir les utiliser en front
        return $this->render('bivouacs/index.html.twig', compact('bivouacs', 'total', 'limit', 'page','categories','regions'));

    }


    /**
     * @Route("/details/{slug}", name="details")
     */
    public function details($slug, BivouacRepository $bivouacsRepo,Request $request, CommentRepository $commentRepo)
    {
        $bivouac = $bivouacsRepo->findOneBy(['slug' => $slug]);
        $comment = new Comment();
        $formComment = $this->createForm(CommentFormType::class, $comment);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setCreatedAt(new DateTime());
            $comment->setBivouac($bivouac);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();


            return $this->redirectToRoute('bivouacs_details', ['slug' => $bivouac->getSlug()]);
        }

        if (!$bivouac){
            throw new NotFoundHttpException('Aucun bivouac trouvé');
        }
        return $this->render('bivouacs/details.html.twig', [
            'bivouac' => $bivouac,
            'comment_form' => $formComment->createView()           
        ]);
    }
    /**
     * @Route("/favoris/ajout/{id}", name="ajout_favoris")
     */
    public function ajoutFavoris(Bivouac $bivouac)
    {

        if (!$bivouac){
            throw new NotFoundHttpException('Aucun bivouac trouvé');
        }
        $bivouac->addFavori($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($bivouac);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }
    /**
     * @Route("/favoris/retrait/{id}", name="retrait_favoris")
     */
    public function retraitFavoris(Bivouac $bivouac)
    {
        if (!$bivouac){
            throw new NotFoundHttpException('Aucun bivouac trouvé');
        }
        $bivouac->removeFavori($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($bivouac);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }
}
