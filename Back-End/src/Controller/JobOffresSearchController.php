<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobOffresSearchController extends AbstractController
{
    #[Route('/job/offres/search', name: 'app_job_offres_search')]
    public function index(Request $request, JobOfferRepository $jobRepo): JsonResponse
    {
        $tabContract = [];
        $tabExperience = [];
        $tabRequest = [];

        $tabPostedDate = [];
        if (
            $request->query->get('fullTime') == "false"
            && $request->query->get('partTime') == "false"
            && $request->query->get('freelancer') == "false"
            && $request->query->get('temporary') == "false"
            && $request->query->get('oneLessExperience') == "false"
            && $request->query->get('twoExperience') == "false"
            && $request->query->get('threeExperience') == "false"
            && $request->query->get('fourExperience') == "false"
            && $request->query->get('fiveExperience') == "false"
            && $request->query->get('dateposted1') == "false"
            && $request->query->get('dateposted2') == "false"
            && $request->query->get('dateposted3') == "false"
            && $request->query->get('dateposted4') == "false"
            && $request->query->get('dateposted5') == "false"
            && $request->query->get('stwhere') == ""
            && $request->query->get('stwhat') == ""
        ) {
            $jobOffres = $jobRepo->findAll();
            $data = [];
            foreach ($jobOffres as $jobOffre) {
                $data[] = [
                    'id' => $jobOffre->getId(),
                    'titlejob' => $jobOffre->getTitlejob(),
                    'expeience' => $jobOffre->getExpeience(), //Experience
                    'FullAdress' => $jobOffre->getFullAdress(),
                    'email' => $jobOffre->getEmail(),
                    'contract' => $jobOffre->getCONTRACT(), //JobType
                    'created_at' => $jobOffre->getCreatedAt()
                ];
            }
            return new JsonResponse($data);
        } else {


            if ($request->query->get('fullTime') != "false") {
                $tabContract[] = "Full-time";
            }
            if ($request->query->get('partTime') != "false") {
                $tabContract[] = "Part-Time";
            }
            if ($request->query->get('freelancer') != "false") {
                $tabContract[] = "freelance";
            }
            if ($request->query->get('temporary') != "false") {
                $tabContract[] = "Temporary";
            }


            if ($request->query->get('oneLessExperience') != "false") {
                $tabExperience[] = 1;
            }
            if ($request->query->get('twoExperience') != "false") {
                $tabExperience[] = 2;
            }
            if ($request->query->get('threeExperience') != "false") {
                $tabExperience[] = 3;
            }
            if ($request->query->get('fourExperience') != "false") {
                $tabExperience[] = 4;
            }
            if ($request->query->get('fiveExperience') != "false") {
                $tabExperience[] = 5;
            }

            if (
                $request->query->get('dateposted1') == "false"
                && $request->query->get('dateposted2') == "false"
                && $request->query->get('dateposted3') == "false"
                && $request->query->get('dateposted4') == "false"
                && $request->query->get('dateposted5') == "false"
            ) {
            }

            if ($request->query->get('dateposted1') != "false") {
                $tabPostedDate[] = 1;
            }
            if ($request->query->get('dateposted2') != "false") {
                $tabPostedDate[] = 2;
            }
            if ($request->query->get('dateposted3') != "false") {
                $tabPostedDate[] = 3;
            }
            if ($request->query->get('dateposted4') != "false") {
                $tabPostedDate[] = 4;
            }
            if ($request->query->get('dateposted5') != "false") {
                $tabPostedDate[] = 5;
            }


            if (count($tabPostedDate) > 0) {
                $PostedDate = max($tabPostedDate);
                // seconde * minute * heurs
                // 1 * 1
                // 2 * 24
                // 3  * 24 * 7
                // 4  * 24 * 14
                // 5  * 24 * 30
                date_default_timezone_set('Africa/Tunis');
                if ($PostedDate == 1) {
                    $valPostedDate = 1;
                } else if ($PostedDate == 2) {
                    $valPostedDate = 24;
                } else if ($PostedDate == 3) {
                    $valPostedDate = 24 * 7;
                } else if ($PostedDate == 4) {
                    $valPostedDate = 24 * 14;
                } else if ($PostedDate == 5) {
                    $valPostedDate = 24 * 30;
                }
            }



            if (count($tabContract) > 0) {
                $tabRequest['contract'] = $tabContract;
            }

            if (count($tabExperience) > 0) {
                $tabRequest['expeience'] =  $tabExperience;
            }

            if (isset($PostedDate)) {
                $tabRequest['created_at'] =  date("Y-m-d h:i", time() - 60 * 60 * $valPostedDate);
            }


            //
            //



            $sqlRequest = "SELECT * FROM job_offer WHERE ";

            if ($request->query->get('stwhat') != "") {
                $sqlRequest .= "titlejob LIKE '%" . $request->query->get('stwhat') . "%'";
            }
            if ($request->query->get('stwhere') != "") {
                if ($request->query->get('stwhat') != "") {
                    $sqlRequest .= " and ";
                }
                $sqlRequest .= "full_adress LIKE '%" . $request->query->get('stwhere') . "%'";
            }

            
            if (isset($tabRequest['contract'])) {
                if ($request->query->get('stwhat') != "" || $request->query->get('stwhere') != "") {
                    $sqlRequest .= " and ";
                }
                $sqlRequest .= " contract in (";
                foreach ($tabRequest['contract'] as $contract) {
                    $sqlRequest .= "'$contract' ,";
                }
                $sqlRequest = rtrim($sqlRequest, ", ");
                $sqlRequest .= ")";
            }
            // $tabExperience
            if (isset($tabRequest['expeience'])) {
                if (isset($tabRequest['contract'])) {
                    $sqlRequest .= " and ";
                }
                $sqlRequest .= " expeience in (";
                foreach ($tabRequest['expeience'] as $expeience) {
                    $sqlRequest .= "$expeience ,";
                }
                $sqlRequest = rtrim($sqlRequest, ", ");
                $sqlRequest .= ")";
            }
            if (isset($tabRequest['created_at'])) {
                if (isset($tabRequest['expeience']) || isset($tabRequest['contract'])) {
                    $sqlRequest .= " and ";
                }
                $sqlRequest .= " created_at BETWEEN   '" . $tabRequest['created_at'] . "'  AND '" . date("Y-m-d h:i") . "' ";
            }
            //dd($sqlRequest);

            $jobOffres = $jobRepo->findByQuery($sqlRequest);
            //dd($jobOffres);



            //dd($tabRequest);
            //dd($sqlRequest);



            $data = [];
            foreach ($jobOffres as $jobOffre) {
                $data[] = [
                    'id' => $jobOffre['id'],
                    'titlejob' => $jobOffre['titlejob'],
                    'expeience' => $jobOffre['expeience'], //Experience
                    'FullAdress' => $jobOffre['full_adress'],
                    'email' => $jobOffre['email'],
                    'contract' => $jobOffre['contract'],
                    'created_at' => ['date' => $jobOffre['created_at']]
                ];
            }

            return new JsonResponse($data);
        } //End Else getAll







    }
}
