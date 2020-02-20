<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $role_super_admin = new Profil();
        $role_super_admin->setLibelle("SUPER_ADMIN");
        $manager->persist($role_super_admin);

        $role_admin = new Profil();
        $role_admin->setLibelle("ADMIN");
        $manager->persist($role_admin);

        $role_caissier = new Profil();
        $role_caissier->setLibelle("CAISSIER");
        $manager->persist($role_caissier);

        $role_partenaire = new Profil();
        $role_partenaire->setLibelle("PARTENAIRE");
        $manager->persist($role_partenaire);

        $role_admin_partenaire = new Profil();
        $role_admin_partenaire->setLibelle("ADMIN_PARTENAIRE");
        $manager->persist($role_admin_partenaire);

        $role_caissier_partenaire = new Profil();
        $role_caissier_partenaire->setLibelle("CAISSIER_PARTENAIRE");
        $manager->persist($role_caissier_partenaire);

        $user = new User();
        $user->setProfil( $role_super_admin )
            ->setusername('Alfi')
            ->setPassword($this->encoder->encodePassword( $user,"user123"));
        $manager->persist($user);
        $manager->flush();
    }
}