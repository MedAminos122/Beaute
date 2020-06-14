<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    /**
     * @Route("/Menu/reservation", name="reservation")
     */
    public function index()
    {
        return $this->render('reservation/Menu_reservation.html.twig', [
            'titre' => 'Menu Reservation',
        ]);
    }


    /**
     * @Route("/reservation/ajouter", name="addReservation")
     */
    public function addReservation(Request $request,EntityManagerInterface $manager){
        $reservation=new Reservation();
        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($reservation);
            $manager->flush();
            return $this->redirectToRoute('reservation');
        }
        return $this->render('reservation/ajouter_reservation.html.twig',['form'=>$form->createView()]);
    }


    /**
     * @Route("/reservation/listereservation", name="listReservation")
     */
    public function listReservation(ReservationRepository $rep){
        $reservations=$rep->findAll();
        return $this->render("reservation/liste_reservation.html.twig",['reservations'=>$reservations]);
    }

    /**
     * @Route("/reservation/update/{id}", name="updateReservation")
     */
    public function updateReservation(Reservation $reservation,Request $request,EntityManagerInterface $manager){
        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($reservation);
            $manager->flush();
        }
        return $this->render("reservation/update_reservation.html.twig",['form'=>$form->createView()]);
    }

    /**
     * @Route("/reservation/delete/{id}", name="deleteReservation") , methods={"DELETE"})
     */
    public function deleteReservation(Reservation $reservation,EntityManagerInterface $manager){
        if($reservation!=null){
            $manager->remove($reservation);
            $manager->flush();
            echo "<script>alert('La reservation est supprimé');</script>";}
            return $this->redirectToRoute('listReservation');
    }

    /**
     * @Route("/reservation/ajouter/{id}", name="addReservationpar")
     */
    public function addReservationpar(Client $client,Request $request,EntityManagerInterface $manager){
        $reservation=new Reservation();
        $reservation->setCli($client);
        $form=$this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($reservation);
            $manager->flush();
            return $this->redirectToRoute('client');
        }
        return $this->render('reservation/ajouter_reservation.html.twig',['form'=>$form->createView()]);
    }
}
