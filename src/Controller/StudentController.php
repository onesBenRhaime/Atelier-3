<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    //Get All Student from the database : import StudentRepository from :use App\Repository\StudentRepository 
    #[Route('/student/all', name: 'all_student')]
    public function getAll( StudentRepository $repo): Response
    {
        $Students= $repo->findAll();
        return $this->render('student/students.html.twig', [
            'Students' => $Students,
        ]);
    }

    #[Route('/student/{id}', name: 'student_get')]
    public function getStudentById(StudentRepository $repo,$id) : Response {
        $student = $repo->find($id);
        return $this->render('student/detail.html.twig',["student"=>$student]);
    }

    #[Route('/removeStudent/{id}', name: 'student_remove')]
    public function removeClub(ManagerRegistry $doctrine,$id) :Response {
        $em = $doctrine->getManager();
        $repo= $doctrine->getRepository(Student::class);
        $student = $repo->find($id);
        $em->remove($student);
        $em->flush();
        return  $this->redirectToRoute('all_student');
    }

}
