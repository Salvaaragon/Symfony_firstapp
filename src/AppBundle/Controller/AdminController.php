<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\ContactType;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Developer;
use AppBundle\Entity\Project;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;


class AdminController extends Controller 
{
    public function developerAction() {
        return $this->render('@App/developers.html.twig');
    }

    public function getJsonDeveloperAction() {
        $developer_repository = $this->getDoctrine()->getRepository(Developer::class);
        $developer_query = $developer_repository->findAll();
        foreach ($developer_query as $developer) {
            $developers[] = array(
                'id' => $developer->getId(),
                'name' => $developer->getName(),
                'surname' => $developer->getSurname(),
                'personalInformation' => $developer->getPersonalInformation(),
                'linkedin' => $developer->getLinkedin(),
                'twitter' => $developer->getTwitter(),
                'github' => $developer->getGithub()
                );
        }
        return new JsonResponse($developers);
    }

    public function saveDeveloperAction(Request $request = null) {
        
        $developer = new Developer();
        $entityManager = $this->getDoctrine()->getManager();

        $name = $request->request->get('name');
        $surname = $request->request->get('surname');
        $pinfo = $request->request->get('pinformation');
        $linkedin = $request->request->get('linkedin');
        $twitter = $request->request->get('twitter');
        $github = $request->request->get('github');

        $developer->setName($name);
        $developer->setSurname($surname);
        $developer->setPersonalInformation($pinfo);
        $developer->setLinkedin($linkedin);
        $developer->setTwitter($twitter);
        $developer->setGithub($github);
        $developer->setImage("default_bio.png");

        $entityManager->persist($developer);
        $entityManager->flush();

        return new Response();
    }
}