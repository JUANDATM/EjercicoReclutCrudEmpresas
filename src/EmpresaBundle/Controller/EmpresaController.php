<?php

namespace EmpresaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EmpresaBundle\Entity\Post;
use EmpresaBundle\Entity\Empresa;
use App\Repository\EmpresaRepository;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
/**
     * @Route("/Empresas", name ="Empresas")
     */
    class EmpresaController extends Controller
{
    /**
     * @Route("/catalogoEmpresas", name ="catalogoEmpresas")
     */
    public function TodasAction()
    {
        $repository = $this->getDoctrine()->getRepository('EmpresaBundle:Empresa');
        $empresa = $repository -> findAll();
        return $this->render('EmpresaBundle:Default:index.html.twig',array("empresa" => $empresa));
    }
      /**
     * @Route("/adminEmpresas", name ="admin-Empresas",methods ={"GET"})
     */
    public function AdminEmpresasAction()
    {
        $repository = $this->getDoctrine()->getRepository('EmpresaBundle:Empresa');
        $empresa = $repository -> findAll();
        return $this->render('EmpresaBundle:Default:AdminEmpresas.html.twig',array("empresa" => $empresa));
    }
  /**
     * @Route("/adminUsuarios", name ="admin-Usuarios")
     */
    public function AdminUsuariosAction()
    {
        $repository = $this->getDoctrine()->getRepository('EmpresaBundle:Usuarios');
        $usuario = $repository -> findAll();
        return $this->render('EmpresaBundle:Default:AdminUsuarios.html.twig',array("usuario" => $usuario));
    }
    private function serializeEmpresa(Empresa $empresa){
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($empresa, 'json');
        return $jsonContent;
    }
    /**
     * @Route("/new", name="empresa_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $data = $request->request->get('data');
        print_r($data);
        die();
        $empresa = new Empresa();
        $empresa->setNombreEmpresa($data['nombre']);
        $empresa->setDireccion($data['direccion']);
        $empresa->setTelefono($data['telefono']);
        $empresa->setDescripcion($data['descipcion']);
        $empresa->setImagen($data['imagen']);
        $empresa->setVisitas($data['visitas']);
        $existente = $this->getDoctrine()->getRepository(Empresa::class)->findOneBy(array('id'=>$empresa->getId()));
        if($existente == NULL){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($empresa);
           $entityManager->flush();
        }
        $dataResponse = $this->serializeEmpresa($empresa);
        $response = new Response($dataResponse);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
       
    }

}


        