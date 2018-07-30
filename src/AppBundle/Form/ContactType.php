<?php 
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder 
            ->add('email',TextType::class,array("label"=>"Correo electrónico","required"=>"required",
                "attr"=>array("class" => "form-control contact_email")))
            ->add('message',TextareaType::class,array("label"=>"Mensaje","required"=>"required",
                "attr"=>array("class" => "form-control contact_message")))
            ->add('save',SubmitType::class,array("label"=>"Enviar",
                "attr" => array("class" => "btn btn-danger btn-lg contact_btn")))
        ;
    }
}