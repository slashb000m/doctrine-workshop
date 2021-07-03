<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/addClass",name="addClass")
     */
    public function addClass(EntityManagerInterface $em,Request $request){
       //$em=$this->getDoctrine()->getManager();
       $classe=new Classroom();
       /**$form=$this->createFormBuilder($classe)
                  ->add('name',TextType::class) //<label>name</label>
                  //<input type="texte">
                  ->add('Ajouter',SubmitType::class)
           ->getForm();
        * */
        $form=$this->createForm(ClassroomType::class,$classe);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($classe);
            $em->flush();
            return $this->redirectToRoute("liste");
        }

        return $this->render("classroom/Add.html.twig",['formA'=>$form->createView()]);
    }

}
