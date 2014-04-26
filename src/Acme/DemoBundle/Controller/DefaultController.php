<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function loginAction()
    {
        return $this->redirect('/', 301);
    }

    /**
     * @return Response
     */
    public function logoutAction()
    {
        $token = $this->get('security.context')->getToken();
        $token->setAuthenticated(false);
        //$this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return $this->redirect('/', 301);
    }
}