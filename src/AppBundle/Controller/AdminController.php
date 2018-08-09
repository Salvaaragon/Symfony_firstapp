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
                'github' => $developer->getGithub(),
                'image' => $developer->getImage()
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
        $image = $request->files->get('image');

        $id = $request->request->get('id');
        
        if ($id != null) {
            
            $dev_repository = $entityManager->getRepository(Developer::class);
            $developer = $dev_repository->find($id[0]);
            $developer->setName($name);
            $developer->setSurname($surname);
            $developer->setPersonalInformation($pinfo);
            $developer->setLinkedin($linkedin);
            $developer->setTwitter($twitter);
            $developer->setGithub($github);
            if ($image != null) {

                $fileName = uniqid().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('media_directory'),
                    $fileName
                );
                $developer->setImage($fileName);
            }

            $entityManager->flush();
        }else {
            $developer->setName($name);
            $developer->setSurname($surname);
            $developer->setPersonalInformation($pinfo);
            $developer->setLinkedin($linkedin);
            $developer->setTwitter($twitter);
            $developer->setGithub($github);

            $fileName = uniqid().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('media_directory'),
                $fileName
            );
            $developer->setImage($fileName);

            $entityManager->persist($developer);
            $entityManager->flush();
        }

        return new Response();
    }

    public function deleteDeveloperAction(Request $request = null) {

        $id_developers = $request->request->get('ids');

        if($id_developers){
            $entityManager = $this->getDoctrine()->getManager();
            $developer_repository = $entityManager->getRepository(Developer::class);

            foreach ($id_developers as $id) {
                $email = $developer_repository->find($id);
                $entityManager->remove($email);
                $entityManager->flush();
            }  
        }
        return new Response();
    }
}