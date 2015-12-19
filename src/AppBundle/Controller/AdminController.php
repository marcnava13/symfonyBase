<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use AppBundle\Entity\Users as Users;
use AppBundle\Entity\Groups as Groups;
use AppBundle\Entity\Gallery as Gallery;

class AdminController extends BaseAdminController
{
    /**
     * Allows applications to modify the entity associated with the item being
     * created before persisting it.
     *
     * @param object $entity
     */
    protected function prePersistEntity($entity)
    {
        if ($entity instanceof Gallery) {
            if (null !== $entity->getFile()) {
                $entity->setPath($this->uploadFile($entity->getFile()));
                $entity->setFile();
            }
        }
        
        $entity->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $entity->setModifiedAt(new \DateTime(date('Y-m-d H:i:s')));
        $entity->setCreatedBy(12);
    }

    /**
     * Allows applications to modify the entity associated with the item being
     * edited before persisting it.
     *
     * @param object $entity
     */
    protected function preUpdateEntity($entity)
    {
        $entity->setModifiedAt(new \DateTime(date('Y-m-d H:i:s')));
    }

    /**
     *  Métodos para permitir subida de archivos
     */
    private function uploadFile($file){
        $filename = sha1(uniqid(mt_rand(), true));
        $path = $filename.'.'.$file->guessExtension();

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $file->move($this->getUploadRootDir(), $path);

        return $path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // resources should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads';
    }


}