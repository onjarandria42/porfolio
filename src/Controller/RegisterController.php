<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{

    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }
    
    #[Route('/register', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $hashPassword ): Response
    {
    $user=new User();
    $form=$this->createForm(RegisterType::class, $user);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $form->getData();
        $password=$form->get('password')->getData();
        $hashPassword= $hashPassword->hashPassword($user,$password);
        $user->setPassword($hashPassword);
        $this->entityManager->persist($user);


    }

    return $this->render('register/index.html.twig',[
        'form'=>$form->createView()
    ]);

    }
}
