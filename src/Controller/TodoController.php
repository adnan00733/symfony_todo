<?php
// src/Controller/TodoController.php
namespace App\Controller;


use App\Entity\TodoModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

// class TodoController
class TodoController extends AbstractController
{
    public function index(): Response
    {
        $data = [];
        
        $query = $this->getDoctrine()
        ->getRepository(TodoModel::class)
        ->createQueryBuilder('id') 
        ->getQuery(); 
        
        $todosList = []; 
        $todos = $query->getArrayResult();
        if($todos) {
            foreach ($todos as $key => $todo) {
                $todosList[] = [
                    'id' => $todo['id'], 
                    'title' => $todo['title'],
                    'date_created' => $todo['date_created']->format('Y-m-d'),
                    'delete' => '/todo/delete/'.$todo["id"],
                ];
            }
        }
        
        $number = random_int(0, 100);
        $data['number'] = $number;
        $data['todosList'] = $todosList;
        return $this->render('todo/list.html.twig', $data);
    }

    public function add(Request $request) {
        $todo = new TodoModel();

        $form = $this->createFormBuilder($todo)
          ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('description', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
          ))
          ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
		
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) { 
          $todo->setDateCreated(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
                    
          $todo = $form->getData();
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($todo);
          $entityManager->flush();
  
          return $this->redirectToRoute('todo_list');
        }
  
        return $this->render('todo/add.html.twig', array(
          'form' => $form->createView()
        ));

    }

    public function delete(Request $request, $id) {
      $todo = $this->getDoctrine()->getRepository(TodoModel::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($todo);
      $entityManager->flush();

      $response = new Response();
      $response->send();
    }

    public function view($id) {
      $todo = $this->getDoctrine()->getRepository(TodoModel::class)->find($id);

      return $this->render('todo/view.html.twig', array('todo' => $todo));
    }

    public function edit(Request $request, $id) {
      $todo = new TodoModel();
      $todo = $this->getDoctrine()->getRepository(TodoModel::class)->find($id);
      
      $form = $this->createFormBuilder($todo)
        ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('description', TextareaType::class, array(
          'required' => false,
          'attr' => array('class' => 'form-control')
        ))
        ->add('save', SubmitType::class, array(
          'label' => 'Update',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('todo_list');
      }

      return $this->render('todo/edit.html.twig', array(
        'form' => $form->createView()
      ));
    }
    

}
