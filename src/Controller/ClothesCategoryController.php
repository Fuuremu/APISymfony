<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ClothesCategory;
use App\Service\SecurityService;

class ClothesCategoryController extends AbstractController
{
    /**
     * @Route("/{token}/clothes/category/add/{cat_name}", name="add_clothes_category")
     */
    public function index(EntityManagerInterface $em, SecurityService $secser, $token, $cat_name): Response
    {
        // Securité
        $autorise = $secser->CheckToken($token);
        if(!is_bool($autorise)) {
            return $autorise;
        }

        // Vérifier si categorie existe ou pas
        $samecategory = False;
        $repClothesCat = $this->getDoctrine()->getRepository(ClothesCategory::Class);
        $existing_cat = null;
        $existing_cat = $repClothesCat->findOneBy(array('name' => $cat_name));
        //dump($existing_cat);
        if(is_null($existing_cat))
        {
          $cat = new ClothesCategory();
          $cat->setName($cat_name);
          // Persistance et sauvegarde
          $em->persist($cat);
          $em->flush();
        } else {
          $samecategory = True;
        }

        $response = new Response();
        if(!$samecategory) {
          //echo "Dans samecategory true";
          // Encodage de operation en json
          $response->setContent(json_encode([
              'opération' => 'insert',
              'résultat' => true,
              'type_objet' => 'clothes_category',
              'id_objet' => $cat->getId(),
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
