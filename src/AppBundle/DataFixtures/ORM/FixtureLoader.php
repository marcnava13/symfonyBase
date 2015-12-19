<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Users;
use AppBundle\Entity\Groups;
use AppBundle\Entity\ContextGallery;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
 
class FixtureLoader implements FixtureInterface, ContainerAwareInterface {

   private $container;
 
   public function load(ObjectManager $manager) {
      // Cargamos los datos para los roles de los usuarios
      $this->dataGroupUser($manager);    

      // Cargamos los datos para los contextos de la galería
      $this->dataContextGallery($manager);

      // Get our userManager, you must implement `ContainerAwareInterface`
      $userManager = $this->container->get('fos_user.user_manager');
      $date = new \DateTime(date('Y-m-d H:i:s'));

      // Create our user and set details
      $user = $userManager->createUser();
      $user->setUsername('admin');
      $user->setEmail('admin@domain.com');
      $user->setPlainPassword('admin');
      $user->setEnabled(true);
      $user->setRoles(array('ROLE_ADMIN'));
      $user->setCreatedAt($date);
      $user->setModifiedAt($date);
      $user->setCreatedBy(1);

      // Update the user
      $userManager->updateUser($user, true);

      $date = new \DateTime(date('Y-m-d H:i:s'));

      // Create our user and set details
      $user = $userManager->createUser();
      $user->setUsername('test');
      $user->setEmail('test@domain.com');
      $user->setPlainPassword('test');
      $user->setEnabled(true);
      $user->setRoles(array('ROLE_USER'));
      $user->setCreatedAt($date);
      $user->setModifiedAt($date);
      $user->setCreatedBy(1);

      // Update the user
      $userManager->updateUser($user, true);
   }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

   /**
    * Método para cargar usuarios de prueba
    */
   private function loadUsers(ObjectManager $manager, $username, $email, $password, $roles){
      $date = new \DateTime(date('Y-m-d H:i:s'));

      $user = new Users();

      $user->setSalt(md5(uniqid(null, true)));
      $encoder = $this->container->get('security.password_encoder');
      $pass = $encoder->encodePassword($password, $user->getSalt());
      
      $user->setUsername($username);
      $user->setEmail($email);
      $user->setPassword($pass);
      $user->setActive(1);
      $user->setRoles($roles);
      $user->setCreatedAt($date);
      $user->setModifiedAt($date);
      $user->setCreatedBy(1);

      $manager->persist($user);
      unset($user);
      $manager->flush();
   }

   /**
    * Método para cargar los datos de los grupos de los usuarios
    */
   private function dataGroupUser(ObjectManager $manager){
      $arr_context = array('SuperAdmin' => array('ROLE_ADMIN'), 'Administrador' => array('ROLE_MODERATOR'), 'Registrado' => array('ROLE_USER'));
      $date = new \DateTime(date('Y-m-d H:i:s'));

      foreach ($arr_context as $key => $value) {
         $context = new Groups();
         $context->setName($key);
         $context->setRoles($value);
         $context->setCreatedAt($date);
         $context->setModifiedAt($date);
         $context->setCreatedBy(1);
         $manager->persist($context);
         unset($context);
      }

      $manager->flush();
   }

   /**
    * Método para cargar los datosde los contexto de Recurso en la Galería
    */
   private function dataContextGallery(ObjectManager $manager){
      $arr_context = array('Foto', 'Video');
      $date = new \DateTime(date('Y-m-d H:i:s'));

      foreach ($arr_context as $key => $value) {
         $context = new ContextGallery();
         $context->setType($value);
         $context->setCreatedAt($date);
         $context->setModifiedAt($date);
         $context->setCreatedBy(1);
         $manager->persist($context);
         unset($context);
      }

      $manager->flush();
   }
 
}