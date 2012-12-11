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
	 * @Template("DbBundle::form.html.twig")
	 */
	public function addUserAction(Request $request)
	{
		$view = array('menu' => 'users');

		$user = new Entity\User();
		$form = $this->createFormBuilder($user)
			->add('name', 'text', array('label' => 'Imię'))
			->add('surname', 'text', array('label' => 'Nazwisko'))
			->add('email', 'email', array('label' => 'Adres email'))
			->getForm()
		;

		if ($request->isMethod('POST')) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em  = $this->getDoctrine()->getEntityManager();
				$em->persist($user);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Użytkownik dodany!');

				return $this->redirect($this->generateUrl("users"));
			}
		}

		$view['form'] = $form->createView();

		return $view;
	}
}
