<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Repository\TarifRepository;
use App\Repository\TransactionRepository;

class EnvoiDargentController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

    }
    /**
     * @Route("/api/transaction/envoi", name="envoi", methods={"POST"})
     */
    public function envoi(Request $request,EntityManagerInterface $manager, AffectationRepository $affectationRepository, CompteRepository $compteRipo, TarifRepository $tarifRepository)    {
        $userEnvoi = $this->tokenStorage->getToken()->getUser();
        $values = json_decode($request->getContent());
        $userPartenaire = $userEnvoi->getPartenaire();
        $userAffcete = $affectationRepository->findOneBy(array("useraffecter"=>$userEnvoi));
        
        if($userAffcete){
            $compte = $userAffcete->getComptconcerne();
            $compte = $compteRipo->findOneBy(array("id"=>$compte));
    
        }
        elseif($compte = $compteRipo->findOneBy(array("numCompte" => $values->numCompte))){
         if($values->numCompte != $userPartenaire){
            $compte;
        }   
        }else{
            $data = [
                'status' => 500,
                'message' => 'Aucun compte n\'est affecté à cet utlisateur . '];
    
            return new JsonResponse($data, 500);
        }
        
        $tarif = $tarifRepository->findAll();
        
            foreach ($tarif as $res)
            {
                $res->getBornsup();
                $res->getBorninf();
                $res->getFrais();
                if($values->montant >= $res->getBorninf() && $values->montant <= $res->getBornsup() ){
                    $frais =  $res->getFrais();

                }
                
            }
        if($values->montant > $compte->getSoldes()){
            $data = [
                'status' => 201,
                'message' => "Opération échouée, le solde est insuffisant ... "
            ];
    
                return new JsonResponse($data, 201);
        }
        $comEtat = $frais * 30/100;
        $comSysteme = $frais * 40/100 ;
        $comEnvoi = $frais * 10/100 ;
        $comRetrait = $frais * 20/100 ;
        $code = rand(0,999999999) +1 ;
            
        $envoi = new Transaction();
        $dateEnvoi = new \DateTime();
         #### Faire un envoi ####
        if($values){
            
            $envoi->setNomcompE($values->NomcompE)
                    ->setTelephoneE($values->telephoneE)
                    ->setNIN($values->NIN)
                    ->setEnvoyerAt($dateEnvoi)
                    ->setNomcompB($values->NomcompB)
                    ->setTelephoneB($values->telephoneB)
                    ->setMontant($values->montant)
                    ->setFrais($frais)
                    ->setComissionEtat($comEtat)
                    ->setComissionEnvoi($comEnvoi)
                    ->setComissionSystem($comSysteme)
                    ->setCmptD($compte)
                    ->setEnvoyeur($userEnvoi)
                    ->setCodeEnvoi($code);           
            $manager->persist($envoi);
            
            ##### Mise à jour du solde #######

            $NouveauSolde = ($compte->getSoldes() - $values->montant );
            $compte->setSoldes($NouveauSolde);
            $manager->persist($compte);
            $manager->flush();
            $data = [
                'status' => 201,
                'message' => 'Vous avez enoyé '.$values->montant. ' à '. $values->NomcompB];
    
                return new JsonResponse($data, 201);
        }else{
            $data = [
                'status' => 500,
                'message' => 'Veuillez saisir tous les champs ... '
                ] ;
    
                return new JsonResponse($data, 500);
        }
       
    }
    
}