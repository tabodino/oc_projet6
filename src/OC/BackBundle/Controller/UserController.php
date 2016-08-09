<?php
/**
 * Created by PhpStorm.
 * User: jm
 * Date: 03/06/16
 * Time: 15:27
 */

namespace OC\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{

    /**
     * @Route("/profil", name="oc_back_profile")
     */
    public function profileAction()
    {
        // Surchage template formulaire fosuserbundle
        $form = $this->get('fos_user.change_password.form.factory')->createForm();

        return $this->render('OCBackBundle:User:profile.html.twig', array('form' => $form->createView()));
    }



    /**
     * @Route("/utilisateurs", name="oc_back_users")
     */
    public function listUsersAction()
    {
        // Récupération utilisateurs FOSUserBundle
        $users = $this->get('fos_user.user_manager')->findUsers();

        return $this->render('OCBackBundle:User:listUsers.html.twig', array('users' => $users));
    }


    /**
     * @Route("/utilisateur/supprime/{id}", name="oc_back_delete_user")
     */
    public function deleteUserAction($id)
    {
        // Récupère le user manager
        $this->get('oc_back_user.manager')->deleteUser($id);

        return $this->redirectToRoute('oc_back_users');
    }
}