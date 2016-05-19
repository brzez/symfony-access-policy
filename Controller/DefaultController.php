<?php

namespace Brzez\AccessPolicyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BrzezAccessPolicyBundle:Default:index.html.twig');
    }
}
