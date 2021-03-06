<?php


namespace App\DataPersister;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Persister implements  ContextAwareDataPersisterInterface
 {
    private $userPasswordEncoder;
    public function __construct(EntityManagerInterface $entitymanager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entitymanager;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
        // TODO: Implement supports() method.
    }
   public function  persist($data, array $context = [])
   {
    
    if ($data->getPassword()) {
        $data->setPassword(
            $this->userPasswordEncoder->encodePassword($data, $data->getPassword())
        );
        $data->eraseCredentials();
    }
      


       $this->entityManager->persist($data);
       $this->entityManager->flush();
   }

   public function  remove($data, array $context = [])
   {
    $this->entityManager->remove($data);
    $this->entityManager->flush();
       // TODO: Implement remove() method.
   }
 }