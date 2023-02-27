<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function manageUser(UserRepository $userRepository): Response
    {
        return $this->render('user/manage.html.twig', ['users' => $userRepository->findBy([], ['username' => 'asc'])]);
    }
    #[Route('/user/modify/{id}', name: 'app_modify_user')]
    public function modifyUser(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $isLandfill = $form->get('isLandfill')->getData();
            $user->setIsLandfill($isLandfill);
            $isAdmin = $form->get('isAdmin')->getData();
            if ($isAdmin) {
                $user->setRoles(["ROLE_ADMIN"]);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/modify.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/user/delete/{id}', name: 'app_delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_user');
    }
}
