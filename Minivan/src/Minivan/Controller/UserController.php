<?php
namespace Minivan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Application\Controller\FaController;
use ZfcUser\Entity\User;
use Minivan\Entity\Profile;
use Zend\Crypt\Password\Bcrypt;
use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;
use Zend\Stdlib\InitializableInterface;


class UserController extends FaController
{

    public function indexAction()
    {
        $this->allow_admin();
        //return new ViewModel();
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
	
	public function listAction(){
        $this->allow_admin();
        $user = $this->em->getRepository('ZfcUser\Entity\User')->findAll();
        $view = new ViewModel(array('users'=>$user));
        $view->setTerminal(true);
        return $view;
    }
	
	public function deleteAction(){
        $this->allow_admin();
        $userRepo = $this->em->getRepository('ZfcUser\Entity\User');
        $user = $userRepo->find($_GET['user_id']);
		
		$remove_user_email = $user->getEmail();
        $this->em->remove($user);
        $this->em->flush();
		$profileRepo = $this->em->getRepository('Minivan\Entity\Profile');
        $profile = $profileRepo->findOneByEmail($remove_user_email);
		$this->em->remove($profile);
        $this->em->flush();
        $return = array("id"=>$_GET['user_id'],'is_success'=>1,"flash"=>"Usuario ha sido eliminado");
        return new JsonModel($return);
    }
	
	public function createAction(){
        $this->allow_admin();
        $user = $this->em->getRepository('ZfcUser\Entity\User')->findBy(array('email'=>$_GET['user']['email']));
        if(!$user){
            $options = $this->getServiceLocator()->get('zfcuser_module_options');
            $this->bcrypt = new Bcrypt();
            $this->bcrypt->setCost($options->getPasswordCost());
            $cryptPassword = $this->bcrypt->create($_GET['user']['password']);
            $user = new User();
            $user->setUsername($_GET['user']['username']);
            $user->setEmail($_GET['user']['email']);
            $user->setPassword($cryptPassword);
            $this->em->persist($user);
            $this->em->flush();
            $profile = new Profile();
            $profile->setEmail($_GET['user']['email']);
            $profile->setResource($_GET['profile']['type']);
            $this->em->persist($profile);
            $this->em->flush();
		    
            $return = array("id"=>$_GET['user']['email'],'is_success'=>1,"flash"=>"Usuario ha sido creado");
        }else{
            $return = array('invalid_form'=>1,'error_list'=>array("Ya existe:".$_GET['user']['email']));
        }
        return new JsonModel($return);
    }

}