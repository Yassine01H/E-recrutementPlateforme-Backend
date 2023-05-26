<?php

namespace App\Controller;

use App\Entity\Demande;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
 
    #[Route('/review-Offerrecruiter/{id}')]
    public function ReviewOfferRecruiter(ManagerRegistry $doctrine,int $id){
        $repository = $doctrine->getRepository(Demande::class);
        $trainings = $repository->findBy(['Recruiter' => $id]);
        $data = [];
        foreach ($trainings as $training) {
            $data[] = [
                'id' => $training->getId(),
                'statut' => $training->getStatut(),
                'Joboffer' => $training->getJoboffer(),
                'fullName' => $training->getFullName(), 
                'emailAddress' => $training->getEmailAddress(),
                'message' => $training->getMessage(),
                'candidat' => $training->getCandidat()->getId()
            ];
        }
        return new JsonResponse($data);
    }

        #[Route('/review-Offercandidat/{id}' )]
        public function ReviewOfferCandidat(ManagerRegistry $doctrine,int $id){
            $repository = $doctrine->getRepository(Demande::class);
            $trainings = $repository->findBy(['candidat' => $id]);
            $data = [];
            foreach ($trainings as $training) {
                $data[] = [
                    'id' => $training->getId(),
                    'statut' => $training->getStatut(),
                    'Joboffer' => $training->getJoboffer(),
                    'fullName' => $training->getFullName(), 
                    'emailAddress' => $training->getEmailAddress(),
                    'message' => $training->getMessage()
                  
                ];
            }
            return new JsonResponse($data);}
}
