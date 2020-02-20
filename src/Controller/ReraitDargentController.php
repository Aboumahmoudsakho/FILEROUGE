<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ReraitDargentController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     *@Route("/api/transaction/retrait", name="retrait", methods={"POST"})
     */
    public function retrait(Request $request,EntityManagerInterface $manager, AffectationRepository $affectationRepository, CompteRepository $compteRipo, TransactionRepository $transactionRepository)
    {   
        $values = json_decode($request->getContent());
        $code = $transactionRepository->findOneBy(array("codeEnvoi" => $values->CodeEnvoi));
        if($code){
            $userRetrait = $this->tokenStorage->getToken()->getUser();
            $dateRetrait = new \DateTime();
            $userAffcete = $affectationRepository->findOneBy(array("useraffecter"=>$userRetrait));
            $comRetrait =  $code->getFrais()*20/100;
            
            if(!$userAffcete){
                $data = [
                    'status' => 500,
                    'message' => 'Aucun compte n\'est affecté à cet utlisateur . '];
        
                return new JsonResponse($data, 500);
        
            }
            $compte = $userAffcete->getComptconcerne();
            $compte = $compteRipo->findOneBy(array("id"=>$compte));
            
            if($code->getEtat()=== true){
                
                $data = [
                    'status' => 201,
                    'message' => 'Ce code est enoyé déja retiré '];
        
                return new JsonResponse($data, 201); 
            }
            
            $code->setRetraitAt($dateRetrait)
                    ->setEtat(true)
                    ->setNINB($values->NINB)
                    ->setCmptc($compte)
                    ->setComissionretrait($comRetrait)
                    ->setdonneur($userRetrait);
            $manager->persist($code);
            ##### Mise à jour du solde #######
            
            $NouveauSolde = ($compte->getSoldes() + $code->getMontant() );
            
            $compte->setSoldes($NouveauSolde);
            $manager->persist($compte);
            $manager->flush();
            $data = [
                'status' => 201,
                'message' => 'Vous avez retiré '. $code->getMontant()];
    
                return new JsonResponse($data, 201);

       }else {
        $data = [
            'status' => 201,
            'message' => 'Le code saisit est incorrect ...' ];

            return new JsonResponse($data, 201);
       }
    
    }
}
