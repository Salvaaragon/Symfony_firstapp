<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\ContactType;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Developer;

class MainController extends Controller 
{
    private $session;

    public function __construct() {
		$this->session = new Session();
    }
    
    public function indexAction() {
        return $this->render('@App/index.html.twig');
    }

    public function aboutUsAction() {

        $repository = $this->getDoctrine()->getRepository(Developer::class);
        $developers = $repository->findAll();

        return $this->render('@App/bio.html.twig', array("developers" => $developers));
    }

    public function contactAction(Request $request = null) {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $contact->setEmail($form->get("email")->getData());
                $contact->setMessage($form->get("message")->getData());
                $em->persist($contact);
                $flush = $em->flush();
                if($flush == null) {
                    $this->get('session')->getFlashBag()->add(
                        'success_send',
                        'Su mensaje se ha enviado correctamente. 
                        Recibirá una respuesta al email proporcionado en la mayor brevedad posible.'
                    );
                }
                else {
                    $this->get('session')->getFlashBag()->add(
                        'error_send',
                        'Error al enviar el mensaje.'
                    );
                }
            }
            else {
                $this->get('session')->getFlashBag()->add(
                    'error_send',
                    'Error al enviar el mensaje. Compruebe los datos introducidos.'
                );
            }
            return $this->redirectToRoute("contact");
        }
        return $this->render('@App/contact.html.twig', array("form"=>$form->createView()));
    }

    public function loginAction() {
        return $this->render('@App/login.html.twig');
    }
}