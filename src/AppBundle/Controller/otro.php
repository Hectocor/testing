<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class otro extends Controller
{
    /**
     * @Route("/otro/index", name="otro_list")
     */
    
    public function listAction()
    {
        return $this->render('otro/index.html.twig');
    }
    
     /**
     * @Route("/otro/create", name="otro_create")
     */
    public function createAction(Request $request)
    {
        return $this->render('otro/create.html.twig');
    }
    
     /**
     * @Route("/otro/edit/{id}", name="otro_edit")
     */
    public function editAction($id, Request $request)
    {
        return $this->render('otro/edit.html.twig');
    } 
    
    /**
     * @Route("/otro/details/{id}", name="otro_details")
     */
    public function detailsAction($id)
    {
        return $this->render('otro/details.html.twig');
    }
    
    
}
