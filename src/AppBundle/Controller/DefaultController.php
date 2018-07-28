<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    public function firstpageAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/mypage.html.twig');
    }

    public function bioAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/bio.html.twig');
    }
}
