<?php

namespace App\Controller;

use App\Entity\Bivouac;
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

        $data = array();
        foreach ($bivouacs as $key => $bivouac) {
            $data[$key]['id'] = $bivouac->getId();
            $data[$key]['slug'] = $bivouac->getSlug();
            $data[$key]['title'] = $bivouac->getTitle();
            $data[$key]['lon'] = $bivouac->getLon();
            $data[$key]['lat'] = $bivouac->getLat();
            $data[$key]['categorie'] = $bivouac->getCategories()->getName();

        }
        return new JsonResponse($data);
    }
}
