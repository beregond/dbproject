<?php

namespace Db\DbBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Db\DbBundle\Entity;
use Db\DbBundle\Util\Paginator;
use Db\DbBundle\Form\DeleteType;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="index")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function indexAction(Request $requst)
	{
		return array();
	}

	/**
	 * @Route("/users", name="users")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function usersAction(Request $request)
	{
		$view = array('menu' => 'users');

		$users = $this
			->getDoctrine()
			->getEntityManager()
			->createQueryBuilder()
			->select('u')
			->from('DbBundle:User', 'u')
			->orderBy('u.id')
		;

		$users = new Paginator($users);
		$users->page($request->get('page', 1));
		$view['users'] = $users;

		$view['deleteform'] = $this->createForm(new DeleteType())->createView();

		return $view;
	}

	/**
	 * Adding user.
	 *
	 * @Route("/adduser", name="adduser")
	 * @Template("DbBundle::form.html.twig")
	 *
	 * @param Request $request
	 * @return array|RedirectResponse
	 */
	public function addUserAction(Request $request)
	{
		$user = new Entity\User();
		return $this->userAction($request, $user);
	}

	/**
	 * Edit user.
	 *
	 * @Route("/user/{user}", name="edituser")
	 * @Template("DbBundle::form.html.twig")
	 *
	 * @param Request $request
	 * @param int $user
	 * @return array|RedirectResponse
	 */
	public function editUserAction(Request $request, $user)
	{
		if (!$user = $this->getDoctrine()->getRepository('DbBundle:User')->find($user)) {
			return $this->redirect($this->generateUrl("users"));
		}

		return $this->userAction($request, $user, true);
	}

	/**
	 * General method to add and edit user.
	 *
	 * @param Request $request
	 * @param Entity\User $user
	 * @param bool $edit
	 * @return array|RedirectResponse
	 */
	private function userAction(Request $request, Entity\User $user, $edit = false)
	{
		$view = array('menu' => 'users');

		$form = $this
			->createFormBuilder($user)
			->add('name', 'text', array('label' => 'Imię'))
			->add('surname', 'text', array('label' => 'Nazwisko'))
			->add('email', 'email', array('label' => 'Adres email'))
			->getForm()
		;

		if ($request->isMethod('POST')) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($user);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');

				return $this->redirect($this->generateUrl("users"));
			}
		}

		$view['form'] = $form->createView();
		$view['title'] = $edit ? "Edycja użytkownika {$user->getName()} {$user->getSurname()}" : "Dodaj nowego użytkownika";

		return $view;
	}

	/**
	 * Delete user.
	 *
	 * @Route("/deleteuser/{user}", name="deleteuser")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @param int $user
	 * @return RedirectResponse
	 */
	public function deleteUserAction(Request $request, $user)
	{
		if ($user = $this->getDoctrine()->getRepository('DbBundle:User')->find($user)) {
			$form = $this->createForm(new DeleteType());
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->remove($user);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');
			}
		}
		return $this->redirect($this->generateUrl("users"));
	}
}
