<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\ContactType;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Developer;
use AppBundle\Entity\Project;
use AppBundle\Entity\User;

class MainController extends Controller 
{
    private $session;

    public function __construct() {
		$this->session = new Session();
    }
    
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository(Project::class);
        $projects = $repository->findAll();
        
        return $this->render('@App/index.html.twig', array("projects" => $projects));
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
                date_default_timezone_set('Europe/Madrid');
                $em = $this->getDoctrine()->getManager();
                $contact->setEmail($form->get("email")->getData());
                $contact->setMessage($form->get("message")->getData());
                $contact->setIsRead(false);
                $date = new \DateTime;
                $contact->setDate($date);
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

    public function adminAction() {
        $project_repository = $this->getDoctrine()->getRepository(Project::class);
        $developer_repository = $this->getDoctrine()->getRepository(Developer::class);
        $email_repository = $this->getDoctrine()->getRepository(Contact::class);

        $total_projects = sizeof($project_repository->findAll());
        $total_profiles = sizeof($developer_repository->findAll());

        $criteria_email = array('isRead' => '0');
        $total_emails = sizeof($email_repository->findBy($criteria_email));

        return $this->render('@App/dashboard.html.twig', 
            array("projects" => $total_projects, 
                  "profiles" => $total_profiles, 
                  "emails" => $total_emails
                ));
    }

    public function inboxAction() {
        $user_repository = $this->getDoctrine()->getRepository(User::class);
        $users = $user_repository->findBy(array('isactive' => 1));

        foreach($users as $u) {
            $user_emails[] = array('email' => $u->getEmail());
        }
        
        if(isset($user_emails)) 
            return $this->render('@App/inbox.html.twig', array('user_emails' => $user_emails));
        else
           return $this->render('@App/inbox.html.twig');
    }

    public function getJsonEmailsAction() {
        $email_repository = $this->getDoctrine()->getRepository(Contact::class);
        $em = $this->getDoctrine()->getManager();

        $email_query = $em
            ->getRepository(Contact::class)
            ->createQueryBuilder('e')
            ->addOrderBy('e.date', 'DESC')
            ->getQuery()
            ->execute()
        ;

        foreach ($email_query as $email) {
            $emails[] = array(
                'id' => $email->getId(),
                'email' => $email->getEmail(),
                'message' => $email->getMessage(),
                'isRead' => $email->getIsRead(),
                'date' => $email->getDate()->format('d-m-Y H:i')
                );
        }
        if(isset($emails)) return new JsonResponse($emails);
        else return new JsonResponse();
    }

    public function unReadEmailAction(Request $request = null) {
        $id_emails = $request->request->get('ids');
        if($id_emails){
            $entityManager = $this->getDoctrine()->getManager();
            $email_repository = $entityManager->getRepository(Contact::class);

            foreach ($id_emails as $id) {
                $email = $email_repository->find($id);
                $email->setIsRead(0);
                $entityManager->flush();
            } 
        }
        return $this->render('@App/inbox.html.twig');
    }

    public function readEmailAction(Request $request = null) {
        $id_emails = $request->request->get('ids');
        if($id_emails){
            $entityManager = $this->getDoctrine()->getManager();
            $email_repository = $entityManager->getRepository(Contact::class);

            foreach ($id_emails as $id) {
                $email = $email_repository->find($id);
                $email->setIsRead(1);
                $entityManager->flush();
            } 
        }
        return $this->render('@App/inbox.html.twig');
    }

    public function deleteEmailAction(Request $request = null) {
        $id_emails = $request->request->get('ids');
        if($id_emails){
            $entityManager = $this->getDoctrine()->getManager();
            $email_repository = $entityManager->getRepository(Contact::class);

            foreach ($id_emails as $id) {
                $email = $email_repository->find($id);
                $entityManager->remove($email);
                $entityManager->flush();
            }  
        }
        return $this->render('@App/inbox.html.twig');
    }

    public function unreadEmailIdAction(Request $request = null) {

        $id_email = $request->request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $email_repository = $entityManager->getRepository(Contact::class);
        $email = $email_repository->find($id_email);
        $email->setIsRead(0);
        $entityManager->flush();

        return $this->render('@App/inbox.html.twig');
    }

    public function readEmailIdAction(Request $request = null) {

        $id_email = $request->request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $email_repository = $entityManager->getRepository(Contact::class);
        $email = $email_repository->find($id_email);
        $email->setIsRead(1);
        $entityManager->flush();

        return $this->render('@App/inbox.html.twig');
    }

    public function deleteEmailIdAction(Request $request = null) {

        $id_email = $request->request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $email_repository = $entityManager->getRepository(Contact::class);
        $email = $email_repository->find($id_email);
        $entityManager->remove($email);
        $entityManager->flush();

        return $this->render('@App/inbox.html.twig');
    }

    public function getEmailIdAction(Request $request = null) {
        $id_email = $request->request->get('id');
        $email_repository = $this->getDoctrine()->getRepository(Contact::class);
        $email = $email_repository->find($id_email);

        $data[] = array('email' => $email->getEmail());

        return new JsonResponse($data);
    }

    public function sendEmailAction(\Swift_Mailer $mailer){
        $message = (new \Swift_Message('Hello Email'))
        ->setSubject('Mensaje de la web')
        ->setFrom('symfonypruebas18@gmail.com')
        ->setTo('salvaaragon94@gmail.com')
        ->setBody('Me llamo Eusebio');

        $mailer->send($message);

        return new JsonResponse();
    }

}