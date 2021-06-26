<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    /**
     * @Route("/listeClasse", name="liste")
     */
    public function list(ClassroomRepository $classroomRepo){
        $listeClasse = $classroomRepo->findAll();
        return $this->render('classroom/list.html.twig',[
            'liste' => $listeClasse

        ]);
        }
        
    /**
     * @Route("/deleteById/{id}", name="deleteById")
     */
    public function deleteById($id, ClassroomRepository $classroomRepo, EntityManagerInterface $entityManager){
        $classe = $classroomRepo -> find($id);
        if(!$classe){
            throw $this-> createNotFoundException("classe non trouve ! ");
        }
        $entityManager->remove($classe);
        $entityManager->flush();

        return $this->redirectToRoute('liste');



        
    }
}
