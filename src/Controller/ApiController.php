<?php

namespace App\Controller;

use App\Entity\Bivouac;
use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $bivouacs = $em->getRepository(Bivouac::class)->findBy(array('active' => true), array('created_at' => 'DESC'));
        $regions = $em->getRepository(Region::class)->findAll();

        $data = array();
        foreach ($bivouacs as $key => $bivouac) {
            $data[$key]['id'] = $bivouac->getId();
            $data[$key]['slug'] = $bivouac->getSlug();
            $data[$key]['title'] = $bivouac->getTitle();
            $data[$key]['lon'] = $bivouac->getLon();
            $data[$key]['lat'] = $bivouac->getLat();
            $data[$key]['content'] = $bivouac->getContent();
            $data[$key]['adresse'] = $bivouac->getAdresse();
            $data[$key]['itineraire'] = $bivouac->getItineraire();
            $data[$key]['prix'] = $bivouac->getPrix();
            $data[$key]['lien'] = $bivouac->getLien();
            $data[$key]['createdAt'] = $bivouac->getCreatedAt();
            $data[$key]['categorie'] = $bivouac->getCategories()->getName();
            $data[$key]['image'] = $bivouac->getCategories()->getImage();

        }
        return new JsonResponse($data);
    }
}
