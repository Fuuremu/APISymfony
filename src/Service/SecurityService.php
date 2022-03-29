<?php
// src/Service/SecurityService.php
namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class SecurityService
{
    public function CheckToken($token)
    {
        if($token != 12345) {

            $response = new Response();
            $response->setContent(json_encode([
                'error' => 'error',
                'résultat' => false,
                'errorMessage' => 'Le token est invalide',
            ]));
            $response->headers->set('Content-Type', 'application/json');
            # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;
            return $response;
        } else {
            return true;
        }
    }
    /*
    public function CheckHeadersContentType($headers, $contentType)
    {
        if(0 !== strpos($headers, $contentType))
        {
            $response = new Response();
            $response->setContent(json_encode([
                'error' => 'error',
                'résultat' => false,
                'errorMessage' => "Le body reçu n'est pas du json.",
            ]));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            return true;
        }
    }

    public function CheckValidJson($json) {
        $res = json_decode($json, JSON_OBJECT_AS_ARRAY);
        if(is_null($res)) {
            $response = new Response();
            $response->setContent(json_encode([
                'error' => 'error',
                'résultat' => false,
                'errorMessage' => "Le json n'est pas valide.",
            ]));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            return $res;
        }
    }
    */
}
