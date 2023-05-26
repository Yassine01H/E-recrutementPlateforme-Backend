<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Candidat;
use App\Entity\Competence;
use App\Entity\Language;
use App\Entity\LicensesAndCertifications;
use App\Entity\Training;
use App\Repository\CandidatRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatController extends AbstractController
{


    public function __invoke(Request $request, UserRepository $userRepo)
    {
        $user = $userRepo->findById($request->request->get('user'));

        $candidat = new Candidat();
        $candidat->setFirstName($request->request->get('first_name'));
        $candidat->setLastName($request->request->get('last_name'));
        $candidat->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', $request->request->get('date_of_birth')));
        $candidat->setPhone($request->request->get('phone'));
        $candidat->setAddress($request->request->get('address'));
        $candidat->setJob($request->request->get('job'));
        $candidat->setProfileTitle($request->request->get('profileTitle'));
        $candidat->setImgProfile($request->files->get('imgProfile'));

        $candidat->setUser($user);
        return $candidat;
    }

  

    #[Route('/getcandidats', name: 'getcandidats')]
    public function allcandidats(ManagerRegistry $doctrine){
 
     $repository = $doctrine->getRepository(Candidat::class);
     $candidats = $repository->findAll();
     return new JsonResponse(array('candidats' => $candidats));
    }


    #[Route("/candidatID/{id}", name: 'getcandidatID', methods: ['GET'])]
    public function getcandidatID(ManagerRegistry $doctrine,int $id)
    {
        $repository = $doctrine->getRepository(Candidat::class);
        $candidat = $repository->findOneBy(['id' => $id]);
        $user = $candidat->getUser();
       return new JsonResponse(
        [
            'id' => $candidat->getId(),
            'user' => $user->getId()
        ]
    );
    }

    #[Route("/candidat/{id}", name: 'getcandidat', methods: ['GET'])]
    public function getcandidat(ManagerRegistry $doctrine,int $id)
    {
        $repository = $doctrine->getRepository(Candidat::class);
        $candidat = $repository->findOneBy(['user' => $id]);
        
       return new JsonResponse(
        ['id' => $candidat->getId(),
        'first_name' => $candidat->getFirstName(),
        'last_name' => $candidat->getLastName(),
        'date_of_birth' => $candidat->getDateOfBirth(),
        'phone' => $candidat->getPhone(),
        'address' => $candidat->getAddress(),
        'job' => $candidat->getJob(),
        'profileTitle' => $candidat->getProfileTitle(),
        'imgProfilePath' => $candidat->getImgProfilePath(),    
        ]
    );
    }

    #[Route("/trainings/{id}", name: 'getEducations', methods: ['GET'])]
    public function getEducations(ManagerRegistry $doctrine,int $id){
        $repository = $doctrine->getRepository(Training::class);
        $trainings = $repository->findBy(['candidat' => $id]);
        $data = [];
        foreach ($trainings as $training) {
            $data[] = [
                'id' => $training->getId(),
                'createdAt' => $training->getCreatedAt(),
                'description' => $training->getDescription(),
                'diploma' => $training->getDiploma(),
                'endDate' => $training->getEndDate(),
                'end_date' => $training->getEndDate(),
                'fieldOfStudy' => $training->getFieldOfStudy(),
                'field_of_study' => $training->getFieldOfStudy(),
                'school' => $training->getSchool(),
                'startDate' => $training->getEndDate(),
                'start_date' => $training->getEndDate(),
                'updatedAt' => $training->getUpdatedAt(),
            ];
        }
        return new JsonResponse($data);
    }
    

    #[Route("/license-And-Certification/{id}", name: 'getLicenseAndCertification', methods: ['GET'])]
    public function getLicenseAndCertifications(ManagerRegistry $doctrine,int $id){
        $repository = $doctrine->getRepository(LicensesAndCertifications::class);
        $licenseAndCertifications = $repository->findBy(['candidat' => $id]);
        $data = [];
        foreach ($licenseAndCertifications as $licenseAndCertification) {
            $data[] = [
                'id' => $licenseAndCertification->getId(),
                'dateOfIssue' => $licenseAndCertification->getDateOfIssue(),
                'date_of_issue' => $licenseAndCertification->getDateOfIssue(),
                'degreeUrl' => $licenseAndCertification->getDegreeUrl(),
                'degree_url' => $licenseAndCertification->getDegreeUrl(),
                'iddegree' => $licenseAndCertification->getIddegree(),
                'issuingBody' => $licenseAndCertification->getIssuingBody(),
                'issuing_body' => $licenseAndCertification->getIssuingBody(),
                'name' => $licenseAndCertification->getName(),
                'createdAt' => $licenseAndCertification->getCreatedAt(),
                'updatedAt' => $licenseAndCertification->getUpdatedAt(),
            ];
        }
        return new JsonResponse($data);
    }
    
    #[Route("/skills/{id}", name: 'getskills', methods: ['GET'])]
    public function getskills(ManagerRegistry $doctrine,int $id){
        $repository = $doctrine->getRepository(Competence::class);
        $skills = $repository->findBy(['candidat' => $id]);
        $data = [];
        foreach ($skills as $skill) {
            $data[] = [
                'id' => $skill->getId(),
                'competenceName'=>$skill->getCompetenceName(),

            ];
        }
        return new JsonResponse($data);
    }
    
    #[Route("/languages/{id}", name: 'getlanguages', methods: ['GET'])]
    public function getlanguages(ManagerRegistry $doctrine,int $id){
        
        $repository = $doctrine->getRepository(Language::class);
        $languages = $repository->findBy(['candidat' => $id]);
        $data = [];
        foreach ($languages as $language) {
            $data[] = [
                'id' => $language->getId(),
                'languageName' => $language->getLanguageName(),
                'level' => $language->getLevel(),
            ];
        }
        return new JsonResponse($data);
    }
    






    #[Route("/edit-candidat/{id}", name: 'putcadidat',methods: ['POST'])]
    public function edit(Request $request,ManagerRegistry $doctrine, int $id): Response
    {
       

        $entityManager = $doctrine->getManager();
        $candidat = new Candidat();
        $candidat = $entityManager->getRepository(Candidat::class)->find($id);
        


        if (!$candidat) {
            return $this->json('No candidat found for id' . $id, 404);
        }

        $firstname = $request->request->get("first_name");
        if(isset($firstname)){
            $candidat->setFirstName($request->request->get("first_name"));
        }
        $last_name =$request->request->get('last_name');
        if(isset($last_name)){
            $candidat->setLastName($request->request->get('last_name'));
        }
        $phone =$request->request->get('phone');
        if(isset($phone)){
            $candidat->setPhone($request->request->get('phone'));
        }

        $address = $request->request->get('address');
        if(isset($address)){
            $candidat->setAddress($request->request->get('address'));
        }

        $job = $request->request->get('job');
        if(isset($job)){
            $candidat->setJob($request->request->get('job'));
        }

        $profileTitle = $request->request->get('profileTitle');
        if(isset($profileTitle)){
            $candidat->setProfileTitle($request->request->get('profileTitle'));
        }

        $imgProfile = $request->files->get("imgProfile");
        if(isset($imgProfile)){
            //dd("ok");
            $candidat->setImgProfile($request->files->get('imgProfile'));
        }
        
        $candidat->setUpdatedAt(\DateTimeImmutable::createFromMutable(new \DateTime()));
        $entityManager->flush();
        $data =  [
            'id' => $candidat->getId()
        ];
       return new JsonResponse($data);        
    }



    #[Route('/candidats/search', name: 'app_candidats_search')]
    public function index(Request $request, CandidatRepository $recRepo): JsonResponse
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
            $candidats = $recRepo->findAll();
            $data = [];
            foreach ($candidats as $candidat) {
                $data[] = [
                    'id' => $candidat->getId(),
                    'first_name' => $candidat->getFirstName(),
                    'last_name' => $candidat->getLastName(),
                    'imgProfilePath' => $candidat->getImgProfilePath(),   
                    'job' => $candidat->getJob(),
                    'address' => $candidat->getAddress(),
                    'profileTitle'=> $candidat->getProfileTitle(),
                    'user' => $candidat->getUser()->getid(),
                    'created_at' => $candidat->getCreatedAt()
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



            $sqlRequest = "SELECT * FROM candidat WHERE ";

            

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
                    'imgProfilePath' => $employer['img_profile_path'],
                    'job' => $employer['job'],
                    'address' => $employer['address'],
                    'profileTitle'=> $employer['profile_title'],
                    'created_at' => ['date' => $employer['created_at']]           
                ];
            }
            return new JsonResponse($data);
        } //End Else getAll







    }
}
