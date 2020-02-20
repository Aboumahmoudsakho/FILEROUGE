<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Profil;
use App\Entity\Partenaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api")
 */
class CreationCompteController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/creation/compte", name="creation_compte")
     */
    public function creation_compte_partenaire(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        $userconnct= $this->tokenStorage->getToken()->getUser();
        $val = json_decode($request->getContent());
       // var_dump($val);die;
         if(isset($val->Ninea,$val->email,$val->montant))
         {
            $dateCreate=new \DateTime();
            $depot = new Depot();
            $user =new User();
            $compte = new Compte();
            $partenaire = new Partenaire();
            // affectation des class
            
             //partenaire

            $partenaire->setNinea($val->Ninea);
            $partenaire->setEmail($val->email);    
     
            $em->persist($partenaire);
            $em->flush(); 
            $rolerep = $this->getDoctrine()->getRepository(Profil::class);
            $role = $rolerep->find($val->profil);
            // user
            $user->setUsername($val->username);
            $user->setPassword($passwordEncoder->encodePassword($user,$val->password));
            $user->setProfil($role);
            $user->setPartenaire($partenaire);
            
            $em->persist($user);
            $em->flush(); 
                  //gener num compte

            $an = Date('y');
            $cont = $this->getLastCompte();
            $long = strlen($cont);
            $ninea2 = substr($partenaire->getNinea() , -2);
            $numCompte = str_pad("MF".$an.$ninea2, 11-$long, "0").$cont; 
            
            //compte
                
            $compte->setNumc($numCompte);
            $compte->setSoldes(0);
            $compte->setCreatedAt($dateCreate);
            $compte->setCreateur($userconnct);
            $compte->setProprietaire($partenaire);

             $em->persist($compte);
            $em->flush(); 

               //depot
               $depot->setDeposerAt($dateCreate);
               $depot->setMontant($val->montant);
               $depot->setCcrediteur($compte);
               $depot->setDepositeur($userconnct);

               $em->persist($depot);
               $em->flush();

                   //mis a jour le depot
             $nouveau = ($val->montant+$compte->getSoldes());
             $compte->setSoldes($nouveau);
             $em->persist($compte);
             $em->flush();
             
             $data = [
             'status' => 201,
             'message' => 'Le compte de partenaire a été créé avec un depot initial de:'.$val->montant
         ];
 
         return new JsonResponse($data, 201);
         }
         $data = [
            'status' => 500,
            'message' => 'renseigner tout les champs'
        ];
         return new JsonResponse($data, 500);
    }
    public function getLastCompte(){
        $ripo = $this->getDoctrine()->getRepository(Compte::class);
        $compte = $ripo->findBy([], ['id'=>'DESC']);
        if(!$compte){
            $cont= 1;
        }else{
            $cont = ($compte[0]->getId()+1);
        }
        return $cont;
      }

      /**
      * @Route("/cpt_partenaire_exist", name="compte_partenaire_ex", methods={"POST","PUT"})
      */
     public function partenaier_exist(Request $request, EntityManagerInterface $em)
     {
           //utilisateur qui connecte
           $userconnct= $this->tokenStorage->getToken()->getUser();
           $val = json_decode($request->getContent());
           //dd($val->Ninea);
           if(isset($val->Ninea,$val->montant))
           {
               $repoattribut =$this->getDoctrine()->getRepository(Partenaire::class);
               $partenaire = $repoattribut->findOneBy(['Ninea'=>$val->Ninea]);
              if($partenaire)
              {
                if($val->montant > 0)
                {
                   $datej=new \DateTime();
                   $depot=new Depot();
                   $compte=new Compte();
                 
                  // num compte

                       $an = Date('y');
                   $cont = $this->getLastCompte();
                   $long = strlen($cont);
                   $ninea2 = substr($partenaire->getNinea() , -2);
                   $numCompte = str_pad("MF".$an.$ninea2, 11-$long, "0").$cont;

                   $compte->setNumc($numCompte);
                   $compte->setSoldes(0);
                   $compte->setCreatedAt($datej);
                   $compte->setCreateur($userconnct);
                   $compte->setProprietaire($partenaire);
                
                   $numecompte=$compte;
                   $em->persist($compte);
                   $em->flush();
                   ###depot ###
                   $repCompt= $this->getDoctrine()->getRepository(Compte::class);
                   $depCompte = $repCompt->findOneBy(['Numc'=>$numecompte]);
                   $depot->setDeposerAt($datej);
                   $depot->setMontant($val->montant);
                   $depot->setCcrediteur($numecompte);
                   $depot->setDepositeur($userconnct);
                   $em->persist($depot);
                   $em->flush();
                   //mis a jour le depot
                       $nouveau = ($val->montant+$compte->getSoldes());
                       $compte->setSoldes($nouveau);
                       $em->persist($compte);
                       $em->flush();

                   $data = [
                       'status' => 201,
                       'message' => 'Le compte  a été créé avec un depot initial de:'.$val->montant
                   ];
           
                   return new JsonResponse($data, 201);
                }
                $data = [
                   'status' => 500,
                   'message' => 'veiller saisie le montant  '
               ];
                return new JsonResponse($data, 500);
              }
              $data = [
               'status' => 500,
               'message' => "desole le ninea n'exist pas"
           ];
            return new JsonResponse($data, 500);
           }
           $data = [
               'status' => 500,
               'message' => 'veuillez saisie le ninea'
           ];
            return new JsonResponse($data, 500);
     }
     /** 
     *  @Route("/depot", name="nouveau_depot", methods={"POST","PUT"})
     */

    public function faire_depot(Request $request, EntityManagerInterface $em)
    {
         //utilisateur qui connecte
         $userconnct= $this->tokenStorage->getToken()->getUser();
         $valeur = json_decode($request->getContent());
         if($valeur->montant>0)
         {
            $dateday=new \DateTime();
            $depot=new Depot();                  

            $repCompt= $this->getDoctrine()->getRepository(Compte::class);
            $depCompte = $repCompt->findOneById($valeur->id);
            $depot->setDeposerAt($dateday);
            $depot->setMontant($valeur->montant);
            $depot->setCcrediteur($depCompte);
            $depot->setDepositeur($userconnct);

            $em->persist($depot);
            $em->flush();
        //mis a jour le depot
            $nouveau = ($valeur->montant+$depCompte->getSoldes());
            $depCompte->setSoldes($nouveau);
            $em->persist($depCompte);
            $em->flush();

            $data = [
                'status' => 201,
                'message' => "vous avez faire un depot d'un montant de:".$valeur->montant
            ];
    
            return new JsonResponse($data, 201);

        }
         $data = [
        'status' => 500,
        'message' => 'le compte n\existe pas'
        ];

        return new JsonResponse($data, 500);
     }
}
