<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/Menu/service", name="service")
     */
    public function index()
    {
        return $this->render('service/Menu_service.html.twig', [
            'titre' => 'Menu Service',
        ]);
    }

    /**
     * @Route("/service/ajouter" , name="addService")
     */
    public function addService(Request $request,EntityManagerInterface $manager){
        $service=new Service();
        $form=$this->createForm(ServiceType::class,$service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute("listService");
        }
        return $this->render("service/ajouter_service.html.twig",['form'=>$form->createView()]);

    }

    /**
     * @Route("/service/listeservice" , name="listService")
     */
    public function serviceList(ServiceRepository $rep){
        $services=$rep->findAll();
        return $this->render('service/liste_service.html.twig',['services'=>$services]);

    }

    /**
     * @Route("/service/update/{id}", name="updateService")
     */
    public function serviceUpdate(Service $service,Request $request,EntityManagerInterface $manager){
        $form=$this->createForm(ServiceType::class,$service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($service);
            $manager->flush();
            return $this->redirectToRoute("listService");
        }
        return $this->render('service/service_update.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/service/delete/{id}", name="deleteService")
     */
    public function serviceDelete(Service $service,EntityManagerInterface $manager){
        if($service!= null){
        $manager->remove($service);
        $manager->flush();
        }
        return $this->redirectToRoute("listService");
    }
}
