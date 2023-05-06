<?php
namespace App\Controller;

use App\Entity\User;;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PropertySearchType;
use App\Form\UserType;
use App\Entity\PropertySearch;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class IndexController extends AbstractController
{


    /**
     *@Route("/",name="user_list")
     */
    public function home(Request $request)
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
        //initialement le tableau des user est vide,
        //c.a.d on affiche les user que lorsque l'utilisateur
        //clique sur le bouton rechercher
        $users= [];

        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'user tapé dans le formulaire
            $username = $propertySearch->getUsername();
            if ($username!="")
                 //si on a fourni un nom d'User on affiche tous les Users ayant ce username
                  $users= $this->getDoctrine()->getRepository(User::class)->findBy(['username' => $username] );
                   else
                  //si si aucun nom n'est fourni on affiche tous les articles
                  $users= $this->getDoctrine()->getRepository(User::class)->findAll();
        }
                return $this->render('users/index.html.twig',[ 'form' =>$form->createView(), 'users' => $users]);
 }




    /**
     * @Route("/user/save")
     */
    public function save() {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername('User 3');

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('user enregisté avec id   '.$user->getId());
    }


    /**
     * @Route("/user/new", name="new_user")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $user = new User();

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }
        return $this->render('users/new.html.twig',['form' => $form->createView()]);
    }


    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function show($id) {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('users/show.html.twig', array('user' => $user));
    }


    /**
     * @Route("/user/edit/{id}", name="edit_user")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('users/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/delete/{id}",name="delete_user")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('user_list');
    }






}