<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ClothesCategory;
use App\Service\SecurityService;
use Service\SecurityService;

class ClothesCategoryController extends AbstractController
{
    /**
     * @Route("/{token}/clothes/category/{category}", name="add_clothes_category")
     */
    public function index(EntityManagerInterface $em, SecurityService $secser, $category): Response
    {
        // Securité
        $autorise =

        // Vérifier si categorie existe ou pas
        $samecategory = False;
        $repClothesCat = $this->getDoctrine()->getRepository('ClothesCategory::Class');
        $existing_cat = null;
        $existing_cat = $repClothesCat->findOneBy(array('name' => $category));
        if(isNull($existing_cat))
        {
          $cat = new ClothesCategory();
          $cat->setName($category);
          // Persistance et sauvegarde
          $em->persist($cat);
          $em->flush();
        }
        $response = new Response();
        if($samecategory) {
          // Encodage de operation en json
          $response->setContent(json_encode([
              'opération' => 'insert',
              'résultat' => true,
              'type_objet' => 'clothes_category',
              'id_objet' => $clr->getId(),
          ]));

        } else {
          // Encodage de operation en json
          $response->setContent(json_encode([
              'opération' => 'insert',
              'résultat' => false,
              'type_objet' => 'clothes_category',
              'id_objet' => null,
          ]));
        }

        $response->headers->set('Content-Type', 'application/json');
        # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;
        return $response;
    }
}
