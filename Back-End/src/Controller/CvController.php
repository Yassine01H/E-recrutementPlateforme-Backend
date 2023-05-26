<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Repository\CandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class CvController extends AbstractController
{
    public function __invoke(Request $request, CandidatRepository $userRepo)
    {   
       $cv = new Cv();
       $candidat = $userRepo->findById($request->request->get('candidat'));
       $cv->setTitleCv($request->request->get('TitleCV'));
       $cv->setCv($request->files->get('cv'));
       $cv->setCandidat($candidat);
   //    $cv->setTitleCv($request->request->get('imgcv'));
        return $cv;
    }

    #[Route("/cv/{id}", name: 'getcv', methods: ['GET'])]
    public function getcv(ManagerRegistry $doctrine,int $id)
    {
        $repository = $doctrine->getRepository(Cv::class);
        $cv = $repository->findBy(['candidat' => $id]);

        $cvData = [];
        foreach ($cv as $cvItem) {
            $cvData[] = [
                'id' => $cvItem->getId(),
                'imgcv' => $cvItem->getImgCv(),
                'title_cv' => $cvItem->getTitleCv(),
            ];
        }

        return new JsonResponse($cvData);
    }

    #[Route('/getcvs', name: 'getcvs')]
    public function allcandidats(ManagerRegistry $doctrine){
 
     $repository = $doctrine->getRepository(Cv::class);
     $cvs = $repository->findAll();
 
 
     return new JsonResponse (array('cv' => $cvs));
    }

    
}
