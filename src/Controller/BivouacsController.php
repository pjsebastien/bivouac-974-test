<?php

namespace App\Controller;

use App\Entity\Bivouac;
use App\Repository\BivouacRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/details/{slug}", name="details")
     */
    public function details($slug, BivouacRepository $bivouacsRepo)
    {
        $bivouac = $bivouacsRepo->findOneBy(['slug' => $slug]);

        if (!$bivouac){
            throw new NotFoundHttpException('Aucun bivouac trouvé');
        }
        return $this->render('bivouacs/details.html.twig', compact('bivouac'));
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
