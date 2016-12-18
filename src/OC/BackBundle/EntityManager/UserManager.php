<?php


namespace OC\BackBundle\EntityManager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserManager
{
    protected $em;

    // Constructeur
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    // Supprime un utilsateur
    public function deleteUser($id)
    {
        $user = $this->em->getRepository('OCBackBundle:User')->find($id);

        if (!$user != null) {
            throw new NotFoundHttpException('User not found. ');
        }

        $this->em->remove($user);

        $this->em->flush();
    }

}