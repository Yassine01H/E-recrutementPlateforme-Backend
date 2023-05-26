<?php

namespace App\Controller;
use App\Entity\Demande;
use App\Entity\JobOffer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Recruiter;
use App\Entity\Training;
use App\Repository\RecruiterRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
class RecruiterController extends AbstractController
{

    public function __invoke(Request $request, UserRepository $userRepo)
    {
       
        $user = $userRepo->findById($request->request->get('user'));

        $recruiter = new Recruiter();
        $recruiter->setFirstName($request->request->get('first_name'));
        $recruiter->setLastName($request->request->get('last_name'));
        $recruiter->setWebSite($request->request->get('web_site'));
        $recruiter->setCompanyName($request->request->get('company_name'));
        $recruiter->setCompanyAdress($request->request->get('company_adress'));
        $recruiter->setPhone($request->request->get('phone'));
        $recruiter->setCompanyDescription($request->request->get('company_description'));
        $recruiter->setActivityArea($request->request->get('activity_area'));

        
        $recruiter->setImgProfile($request->files->get('imgLogo'));

        $recruiter->setUser($user);
        return $recruiter;
    }

    #[Route('/getrecruiters', name: 'getrecruiters')]
    public function allcandidats(ManagerRegistry $doctrine){
 
     $repository = $doctrine->getRepository(Recruiter::class);
     $recruiters = $repository->findAll();
     return new JsonResponse(array('recruiters' => $recruiters));
    }


    #[Route("/recruiter/{id}", name: 'getrecruiter', methods: ['GET'])]
    public function getRecruiter(ManagerRegistry $doctrine,int $id)
    {
        $repository = $doctrine->getRepository(Recruiter::class);
        $recruiter = $repository->findOneBy(['user' => $id]);
        
       return new JsonResponse(
        ['id' => $recruiter->getId(),
        'first_name' => $recruiter->getFirstName(),
        'last_name' => $recruiter->getLastName(),
        'web_site' => $recruiter->getWebSite(),
        'company_name' => $recruiter->getCompanyName(),
        'company_adress' => $recruiter->getCompanyAdress(),
        'phone' => $recruiter->getPhone(),
        'logo' => $recruiter->getLogo(),
        'company_description' => $recruiter->getCompanyDescription(),
       
        ]
    );
    }

    #[Route("/joboffres/{id}", name: 'getjoboffres', methods: ['GET'])]
    public function getJoboffres(ManagerRegistry $doctrine,int $id)
    {
        $repository = $doctrine->getRepository(JobOffer::class);
        $JobOffres = $repository->findBy(['Recruiter' => $id]);
        $data = [];
        foreach ($JobOffres as $JobOffre) {
            $data[] = [
                'id' => $JobOffre->getId(),
                 'CONTRACT'=>$JobOffre->getCONTRACT(),
                 'City' =>$JobOffre->getCity(),
                 'Country'=>$JobOffre->getCountry(),
                 'CurrencyPosition'=>$JobOffre->getCurrencyPosition(),
                 'FullAdress'=>$JobOffre->getFullAdress(),
                 'Qualifications'=>$JobOffre->getQualifications(),
                 'SalaryMax'=>$JobOffre->getSalaryMax(),
                 'salaryMin'=>$JobOffre->getSalaryMin(),
                 'State'=>$JobOffre->getState(),
                 'description'=>$JobOffre->getDescription(),
                 'email'=>$JobOffre->getEmail(),
                 'expeience'=>$JobOffre->getExpeience(),
                 'fullAdress'=>$JobOffre->getFullAdress(),
                 'salary'=>$JobOffre->getSalary(),
                 'titlejob'=>$JobOffre->getTitlejob()
            ];
        }
        return new JsonResponse($data);
    }


    #[Route("/edit-recruiter/{id}", name: 'putrecruiter',methods: ['POST'])]
    public function editrecruiter(Request $request,ManagerRegistry $doctrine, int $id): Response
    {
       

        $entityManager = $doctrine->getManager();
        $recruiter = new Recruiter();
        $recruiter = $entityManager->getRepository(Recruiter::class)->find($id);


        if (!$recruiter) {
            return $this->json('No candidat found for id' . $id, 404);
        }

        $firstname = $request->request->get("first_name");
        if(isset($firstname)){
            $recruiter->setFirstName($request->request->get("first_name"));
        }

        $last_name =$request->request->get('last_name');
        if(isset($last_name)){
            $recruiter->setLastName($request->request->get('last_name'));
        }

        $phone =$request->request->get('phone');
        if(isset($phone)){
            $recruiter->setPhone($request->request->get('phone'));
        }

        $web_site = $request->request->get('web_site');
        if(isset($web_site)){ 
            $recruiter->setWebSite($request->request->get('web_site'));
        }

        $company_name = $request->request->get('company_name');
        if(isset($company_name)){
            $recruiter->setCompanyName($request->request->get('company_name'));
        }

        $company_adress = $request->request->get('company_adress');
        if(isset($company_adress)){
            $recruiter->setCompanyAdress($request->request->get('company_adress'));
        }

        $company_description = $request->request->get('company_description');
        if(isset($company_description)){
        $recruiter->setCompanyDescription($request->request->get('company_description'));
        }
        $activity_area = $request->request->get('activity_area');
        if(isset($activity_area)){
            $recruiter->setActivityArea($request->request->get('activity_area'));
        }

        $imgLogo = $request->files->get('imgLogo');
        if(isset($imgLogo)){
            //dd("ok");
            $recruiter->setImgProfile($imgLogo);
        }

        $recruiter->setUpdatedAt(\DateTimeImmutable::createFromMutable(new \DateTime()));
        
        $entityManager->flush();
        $data =  [
            'id' => $recruiter->getId()
        ];
       return new JsonResponse($data);      
    }

    
    #[Route('/recruiters/search', name: 'app_recruiters_search')]
    public function index(Request $request, RecruiterRepository $recRepo): JsonResponse
    {
        $tabRequest = [];
        $tabPostedDate = [];
        if (
              $request->query->get('dateposted1') == "false"
            && $request->query->get('dateposted2') == "false"
            && $request->query->get('dateposted3') == "false"
            && $request->query->get('dateposted4') == "false"
            && $request->query->get('dateposted5') == "false"

        ) {
            $employers = $recRepo->findAll();
            $data = [];
            foreach ($employers as $employer) {
                $data[] = [
                    'id' => $employer->getId(),
                    'first_name' => $employer->getFirstName(),
                    'last_name' => $employer->getLastName(),
                    'web_site' => $employer->getWebSite(),
                    'company_name' => $employer->getCompanyName(),
                    'company_adress' => $employer->getCompanyAdress(),
                    'activity_area' => $employer->getActivityArea(),
                    'phone' => $employer->getPhone(),
                    'logo' => $employer->getLogo(),
                    'company_description' => $employer->getCompanyDescription(),
                    'user' => $employer->getUser()->getid(),
                    'created_at' => $employer->getCreatedAt()
                ];
            }
            return new JsonResponse($data);
        } else {
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


            if (isset($PostedDate)) {
                $tabRequest['created_at'] =  date("Y-m-d h:i", time() - 60 * 60 * $valPostedDate);
            }


            //
            //



            $sqlRequest = "SELECT * FROM recruiter WHERE ";

            

            if (isset($tabRequest['created_at'])) {
                $sqlRequest .= " created_at BETWEEN   '" . $tabRequest['created_at'] . "'  AND '" . date("Y-m-d h:i") . "' ";
            }
           // dd($sqlRequest);

            $employers = $recRepo->findByQuery($sqlRequest);
            //dd($jobOffres);



            //dd($tabRequest);
            //dd($sqlRequest);



            $data = [];
            foreach ($employers as $employer) {
                $data[] = [
                    'id' => $employer['id'],
                    'first_name' =>$employer['first_name'] ,
                    'last_name' => $employer['last_name'],
                    'web_site' =>$employer['web_site'],
                    'company_name' =>$employer['company_name'] ,
                    'company_adress' => $employer['company_adress'],
                    'activity_area' =>$employer['activity_area'],
                    'phone' =>$employer['phone'],
                    'logo' => $employer['logo'],
                    'company_description' =>$employer['company_description'],
                  //  'user' => $employer->getUser()->getid(),
                  'created_at' => ['date' => $employer['created_at']]
                ];
            }
            return new JsonResponse($data);
        } //End Else getAll







    }
}