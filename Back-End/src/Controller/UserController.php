<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route("/user", name: 'getuser', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine,Request $request)
    {
       /* $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(['id' => $id]);*/
        $dd = $request->request->get('password');
        // Verifying a password
          /*  $isPasswordValid = password_verify($password,$user->getPassword());
            if ($isPasswordValid) {
                $statut =  'Password is valid';
            } else {
                $statut =  'Password is not valid';
            }
        return new JsonResponse(array('dd' => $dd));*/
    }


    
    #[Route("/user/{id}/{password}", name: 'getuser', methods: ['GET'])]
    public function getcandidat(ManagerRegistry $doctrine,int $id,string $password)
    {
       // $dd = $request->request->get('password');
        
       $repository = $doctrine->getRepository(User::class);
       $user = $repository->findOneBy(['id' => $id]);

       $isPasswordValid = password_verify($password,$user->getPassword());
       if ($isPasswordValid) {
           $statut =  'Password is valid';
       } else {
           $statut =  'Password is not valid';
       }
        return new JsonResponse([
            'email' =>$user->getEmail(),
            'statut' =>$statut
    ]);

    }
    
    /**
     * @Route("/api/user/change-password/{email}", methods={"POST"})
     */
    public function changePassword(ManagerRegistry $doctrine,Request $request, string $email)
    {
        // Get the user with the given email address from your database
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $email]);

        // Check if the user exists
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        // Get the new password from the request body
        $newPassword = $request->request->get('password');

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Set the user's new hashed password
        $user->setPassword($hashedPassword);


        // Save the updated user object to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // Return a success response
        return new JsonResponse(['success' => true]);
    }


}
