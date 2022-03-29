<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ClothesCategory;
use App\Entity\Color;
use App\Entity\Clothes;
use App\Service\SecurityService;
use Doctrine\ORM\EntityManagerInterface;

class ClothesController extends AbstractController
{
    /**
     * @Route("/{token}/clothes/add/{cloth_name}/{id_clothcat}/{id_color}", name="add_clothes")
     */
    public function add(EntityManagerInterface $em, SecurityService $secser, $token, $cloth_name, $id_clothcat, $id_color): Response
    {

      //Securité
      $autorise = $secser->CheckToken($token);
      if(!is_bool($autorise)) {
          return $autorise;
      }

      //Flag de réalisation de l'opération
      $canbeadded = True;

      // Création d'un clothes
      $clothe = new Clothes();
      $clothe->setName($cloth_name);

      // Vérification de l'existence de la Couleur
      $rep_color = $this->getDoctrine()->getRepository(Color::class);
      $c = null;
      $c = $rep_color->find($id_color);
      if(!is_null($c)) {
        // Ok la couleur existe
        $clothe->setColor($c);
      } else {
        $canbeadded = False;
      }

      // Vérification de l'existence de catégorie
      $rep_clo_cat = $this->getDoctrine()->getRepository(ClothesCategory::class);
      $cat = null;
      $cat = $rep_clo_cat->find($id_clothcat);
      if(!is_null($cat)) {
        // Ok la categorie existe
        $clothe->setClothesCategory($cat);
      } else {
        $canbeadded = False;
      }

      // Préparation de la réponse json
      $response = new Response();

      if($canbeadded) {
        // On insère
        $em->persist($clothe);
        $em->flush();
        // On retourne la reponse
        $response->setContent(json_encode([
            'opération' => 'insert',
            'résultat' => true,
            'type_objet' => 'clothes',
            'id_objet' => $clothe->getId(),
        ]));
      } else {
        // On retourne la reponse
        $response = $this->generateErrorJson('insert', 'clothes');
      }

      $response->headers->set('Content-Type', 'application/json');
      # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;
      return $response;
    }

    private function generateErrorJson($operation, $entity): Response {
      $response = new Response();
      $response->setContent(json_encode([
          'opération' => $operation,
          'résultat' => false,
          'type_objet' => $entity,
          'id_objet' => null,
      ]));
      return $response;
    }

    /**
     * @Route("/{token}/clothes/{id_clothe}", name="get_clothes")
     */
    public function getClothes(EntityManagerInterface $em, SecurityService $secser, $token, $id_clothe = ""): Response
    {
        //Securité
        $autorise = $secser->CheckToken($token);
        if(!is_bool($autorise)) {
            return $autorise;
        }

        // Vérification id_clothe
        $return_all_clothes = False;
        if($id_clothe == "") {
          $return_all_clothes = True;
        }

        // Traitement
        if($return_all_clothes) {
          $res = $this->getDoctrine()->getRepository(Clothes::class)->findAll();
        } else {
          $res = $this->getDoctrine()->getRepository(Clothes::class)->findBy($id_clothe);
        }
        dump($res);
        return new Response("En attendant");
    }

}
