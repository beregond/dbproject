<?php

namespace Db\DbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Db\DbBundle\Entity;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="index")
	 * @Template()
	 */
	public function indexAction(Request $requst)
	{
		return array();
	}

	/**
	 * @Route("/users", name="users")
	 * @Template()
	 */
	public function usersAction(Request $request)
	{
		$view = array('menu' => 'users');

		return $view;
	}

	/**
	 * @Route("/adduser", name="adduser")
	 * @Template()
	 */
	public function addUserAction(Request $request)
	{
		$view = array('menu' => 'users');

		$user = new Entity\User();
		$form = $this->createFormBuilder($user)
			->getForm()
		;

		$view['form'] = $form;

		return $view;
	}
}
