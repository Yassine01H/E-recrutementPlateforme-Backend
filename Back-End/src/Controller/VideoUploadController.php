<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
class VideoUploadController
{
   public function __invoke(Request $request): User
   {
    dd($request);

   }

/*
   #[Route('/getvideos', name: 'getvideos')]
   public function allvideos(ManagerRegistry $doctrine){

    $repository = $doctrine->getRepository(Video::class);
    $videos = $repository->findAll();


    return new JsonResponse(array('videos' => $videos));
   }


*/

}
