<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEditController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository
    ) {}

    #[Route(path: '/users/{id}/edit', name: 'user_edit', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function edit(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );
            $this->userRepository->upgradePassword($user, $hashedPassword);

            $roles = [$form->get('roles')->getData()];
            $user->setRoles($roles);

            $this->userRepository->save($user, true);

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form, 'user' => $user]);
    }
}
