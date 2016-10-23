<?php

namespace Rocket\APIBundle\Controller;

use Rocket\APIBundle\Exception\APIException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RocketController extends Controller
{
    private $errors = array(
        0 => 'OK',
        1 => 'No NOTAM found',
        2 => 'API request version incorrect',
        3 => 'Client query incomplete or defective',
        8 => 'Incorrect username or password',
        9 => 'Unknown error on server side'
    );

    public function indexAction()
    {
        return $this->render('RocketAPIBundle:Default:index.html.twig');
    }

    public function getByCodeAction($code)
    {
        if (!preg_match('/[a-zA-Z]{4}/', $code)) {
            APIException::wrongValue('Code should contains only letters');
        }

        /* @var \Rocket\APIBundle\Services\ApiManager $apiManager */
        $apiManager = $this->container->get('rocket.api_manager');

        $responseXML = $apiManager->soapRequst($code,
            $this->getParameter('rocket.api.usr'),
            $this->getParameter('rocket.api.pwd'),
            $this->getParameter('rocket.api.notam')
        );
        $items = array();

        if ($responseXML->RESULT == 0 && $responseXML->NOTAMSET) {

            $i = 0;
            foreach ($responseXML->NOTAMSET->NOTAM as $item) {
                $params = explode('/', (string)$item->ItemQ);
                $items[$i] = $this->getParams($params[7]);
                $items[$i]['description'] = (string)$item->ItemE;
                $i++;
            }
        }

        return new JsonResponse(array(
            'items' => $items,
            'result' => $this->errors[intval($responseXML->RESULT)] ?? 'error'
        ));
    }


    protected function getParams($latLng)
    {
        $result = array();
        if (preg_match("/^(-?\d+(?:\.\d+)?)\s*([NSEW]?)\s*(-?\d+(?:\.\d+)?)\s*([NSEW]?)$/", $latLng, $matches)) {

            $result['lat'] = $this->DMStoDEC(substr($matches[1], 0 , 2), substr($matches[1], -2), $matches[2]);

            $result['lng'] = $this->DMStoDEC(substr($matches[3], 0 , 3), substr($matches[3], -2), $matches[4]);

        }

        return $result;
    }

    protected function DMStoDEC($deg = 0,$min = 0, $nsew)
    {
        $direction = 1;
        if ($nsew == "S" || $nsew == "W") {
            $direction = -1;
        }

        return $deg+(($min*60)/3600) * $direction;
    }
}
