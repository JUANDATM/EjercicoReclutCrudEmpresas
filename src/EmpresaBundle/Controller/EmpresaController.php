<?php

namespace EmpresaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use EmpresaBundle\Entity\Post;

class EmpresaController extends Controller
{
    /**
     * @Route("/Empresas", name ="Empresas_inicio")
     */
    public function TodasAction()
    {
        $repository = $this->getDoctrine()->getRepository('EmpresaBundle:Empresa');
        $empresa = $repository -> findAll();
        return $this->render('EmpresaBundle:Default:index.html.twig',array("empresa" => $empresa));
    }

}


        