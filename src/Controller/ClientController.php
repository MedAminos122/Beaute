<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/Menu/client", name="client")
     */
    public function index()
    {
        return $this->render('client/client_menu.html.twig', [
            'titre' => 'Menu client',
        ]);
    }
    /**
     * @Route("/client/ajouter", name="addClient")
     */
    public function addClient(Request $request,EntityManagerInterface $manager){
        $client=new Client();
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($client);
            $manager->flush();
            echo "<script>alert('client ajouté');</script>";
            return $this->redirectToRoute('client');
        }
        return $this->render('client/ajouter_client.html.twig',['form'=>$form->createView()]);
    } 
    
    
    /**
     * @Route("/client/listeclient", name="listClient") , methods={"GET"})
     */
    public function listClient(ClientRepository $rep){
        $clients=$rep->findAll();
        return $this->render('client/liste_clients.html.twig',['clients'=>$clients]);
    }


    /**
     * @Route("/client/update/{id}", name="updateClient")
     */
    public function updateClient(Client $client,Request $request,EntityManagerInterface $manager){
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($client);
            $manager->flush();
            echo "<script>alert('Client est mis à jour');</script>";
            return $this->redirectToRoute('client');
        }
        return $this->render('client/client_update.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/client/delete/{id}", name="deleteClient") , methods={"DELETE"})
     */
    public function deleteClient(Client $client,EntityManagerInterface $manager){
        if($client!=null){
        $manager->remove($client);
        $manager->flush();
        echo "<script>alert('Client est supprimé');</script>";
        return $this->redirectToRoute('client');
    }
        
    
    return $this->redirectToRoute('listClient');
        }

        /**
         * @Route("/client/{id}/reservations", name="ClientReservations")
         */
        public function clientReservations(Client $client){
            $reservations=$client->getReservations();
            return $this->render('client/client_reservations.html.twig',['reservations'=>$reservations]);
        }

        /**
         * @Route("/home", name="home")
         */
        public function home(){
            return $this->render('home.html.twig');
        }



        /**
         * @Route("/client/{id}/detail", name="clientDetails")
         */
        public function clientDetails(Client $client){
            return $this->render("client/client_detail.html.twig",["client"=>$client]);
        }

}
