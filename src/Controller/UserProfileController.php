<?php

namespace App\Controller;

use App\Entity\UserProfile;
use App\Form\UserProfileType;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class UserProfileController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em)
    {
        
    }
    #[Route('/', name: 'app_profile_show', methods: ['GET'])]
    public function show(UserProfileRepository $repo): Response
    {
        $user = $this->getUser();
        $profile = $repo->findOneBy(['user' => $user]);

        if (!$profile) {
            return $this->json(['message' => 'Profil introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($profile);
    }

    #[Route('/edit', name: 'app_profile_edit', methods: ['POST', 'PUT'])]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile() ?? new UserProfile();
        $profile->setUser($user);

        $form = $this->createForm(UserProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($profile);
            $em->flush();

            return $this->json(['message' => 'Profil mis à jour avec succès']);
        }

        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }
}
