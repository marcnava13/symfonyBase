<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;

class ApiCoreController extends Controller
{
    /**
     * @return array()
     * @View()
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:Users')->findAll();

        return array('data' => $users);
    }
}