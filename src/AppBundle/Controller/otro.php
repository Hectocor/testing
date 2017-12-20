<?php

namespace AppBundle\Controller;

use AppBundle\Entity\otroClassController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class otro extends Controller
{
    /**
     * @Route("/otro/index", name="otro_list")
     */
    
    public function listAction()
    {
        $var_otros = $this->getDoctrine()
                ->getRepository('AppBundle:otroClassController')
                ->findAll();
        
        return $this->render('otro/index.html.twig', array('var_otros' => $var_otros));
    }
    
     /**
     * @Route("/otro/create", name="otro_create")
     */
    public function createAction(Request $request)
    {
        $actividad = new otroClassController;
        
        $form = $this->createFormBuilder($actividad)
                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('priority', ChoiceType::class, array('choices' => array('Baja' => 'Baja', 'Normal' => 'Normal', 'Alta' => 'Alta'),'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('date', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Crear Actividad', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //Obtener la información
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $date = $form['date']->getData();
            
            $ahora = new\DateTime('now');
            
            $actividad->getName($name);
            $actividad->setCategory($category);
            $actividad->setDescription($description);
            $actividad->setPriority($priority);
            $actividad->setDate($date);
            $actividad->setCreateDate($ahora);

            $em = $this->getDoctrine()->getManager();
           
            $em->persist($actividad);
            $em->flush();
            
            $this->addFlash(
                    'notice',
                    'Actividad añadida'
                    );
            return $this->redirectToRoute('otro_list');
        }
        return $this->render('otro/create.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
     /**
     * @Route("/otro/edit/{id}", name="otro_edit")
     */
    public function editAction($id, Request $request) {
        $var_otro = $this->getDoctrine()
                ->getRepository('AppBundle:otroClassController')
                ->find($id);

        $ahora = new\DateTime('now');
        
        $var_otro->getName($var_otro->getName());
        $var_otro->setCategory($var_otro->getCategory());
        $var_otro->setDescription($var_otro->getDescription());
        $var_otro->setPriority($var_otro->getPriority());
        $var_otro->setDate($var_otro->getDate());
        $var_otro->setCreateDate($ahora);


        $form = $this->createFormBuilder($var_otro)
                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('priority', ChoiceType::class, array('choices' => array('Baja' => 'Baja', 'Normal' => 'Normal', 'Alta' => 'Alta'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('date', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Modificar Actividad', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Obtener la información
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $date = $form['date']->getData();
 

            
            $em = $this->getDoctrine()->getManager();
            $var_otro= $em->getRepository('AppBundle:otroClassController')->find($id);
                    
            $var_otro->getName($name);
            $var_otro->setCategory($category);
            $var_otro->setDescription($description);
            $var_otro->setPriority($priority);
            $var_otro->setDate($date);
            $var_otro->setCreateDate($ahora);

            $em->flush();

            $this->addFlash(
                    'notice', 'Actividad modificada'
            );
            return $this->redirectToRoute('otro_list');
        }
        return $this->render('otro/edit.html.twig', array('var_otro' => $var_otro, 'form' => $form->createView()));
    }

    /**
     * @Route("/otro/details/{id}", name="otro_details")
     */
    public function detailsAction($id)
    {
        $var_otro = $this->getDoctrine()
                ->getRepository('AppBundle:otroClassController')
                ->find($id);
        
        return $this->render('otro/details.html.twig', array('var_otro' => $var_otro));
    }
    
    
    
    /**
     * @Route("/otro/delete/{id}", name="otro_delete")
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $var_otro = $em->getRepository('AppBundle:otroClassController')->find($id);
        
        $em->remove($var_otro);
        $em->flush();
        
        $this->addFlash(
                    'notice', 'Actividad eliminada'
            );
            return $this->redirectToRoute('otro_list');
        
    }

}
