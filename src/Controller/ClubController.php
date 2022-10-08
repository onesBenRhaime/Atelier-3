<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClubRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Club;


class ClubController extends AbstractController
{

    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    #[Route ('/club/get/{nom}',name:'app_club_getName')]
    public function getName($nom):Response{
        return  $this->render('club/detail.html.twig',['nom'=> $nom]);
    }


    #[Route ('/club/list',name:"app_club_list")]
    public function list():Response{  

        $formations = array(

            array('ref' => 'form147', 'Titre' => 'Formation Symfony
           4','Description'=>'formation pratique',
            'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
           'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
            'Description'=>'formation theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
            'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
            'Description'=>'formation
           theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
            'nb_participants'=>12
        
        ));
           
        return $this->render('club/list.html.twig', [
            'formations' => $formations,
        
        ]);
    }

    #[Route('/club/all', name: 'app_club_all')]
    public function getClubs( ClubRepository $repo) :Response
    {
        $clubs = $repo->findAll();
        return $this->render('club/clubs.html.twig', [
            'clubs' => $clubs,
        ]);
    }


    #[Route('/club/{id}', name: 'app_club_get')]
    public function getClubById( ClubRepository $repo , $id) :Response
    {
        $club = $repo->find($id);
        return $this->render('club/detailsClub.html.twig', [
            'club' => $club,
        ]);
    }

//Methode 1

    // #[Route('/club/remove/{id}', name: 'app_club_club')]
    // public function removeClub( ManagerRepository $doctrine , $id, ClubRepository $repo) :Response
    // {
    //     $em= $doctrine->getManager();
    //     $club = $repo->find($id);
    //     $em->remove($club);
    //     $em->fluch();
    //     return $this->redirectToRoute('club_get_all');
    // }

//Methode 2
    #[Route('/club/remove/{id}', name: 'app_club_remove')]
    public function removeClub( ManagerRegistry $doctrine , $id) :Response
    {
        $em= $doctrine->getManager();
        $repo= $doctrine->getRepository(Club::class);
        $club = $repo->find($id);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('club_get_all');
    }

}



