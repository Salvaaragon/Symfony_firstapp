<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\ContactType;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Developer;

class MainController extends Controller 
{
    public function indexAction() {
        return $this->render('@App/index.html.twig');
    }

    public function aboutUsAction() {

        $repository = $this->getDoctrine()->getRepository(Developer::class);
        $developers = $repository->findAll();

        return $this->render('@App/bio.html.twig', array("developers" => $developers));
    }

    public function contactAction() {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        return $this->render('@App/contact.html.twig', array("form"=>$form->createView()));
    }

    public function loginAction() {
        return $this->render('@App/login.html.twig');
    }
}