<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Color;

class ColorController extends AbstractController
{
    /**
     * @Route("/color/add/{color_name}", name="color")
     */
    public function index(EntityManagerInterface $em, $color_name): Response
    {
        // création d'un objet couleur
        //$em = $this->getDoctrine()->getManager();
        $clr = new Color();
        $clr->setName($color_name);
        // ajout des propriétés
        $em->persist($clr);

        // Execution de la requete
        $em->flush();

        // Encodage de operation en json
        $response = new Response();
        $response->setContent(json_encode([
            'opération' => 'insert',
            'résultat' => true,
            'type_objet' => 'color',
            'id_objet' => $clr->getId(),
        ]));
        $response->headers->set('Content-Type', 'application/json');
        # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;
        return $response;
    }
}
