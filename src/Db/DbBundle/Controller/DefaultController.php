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
		return array('menu' => 'index');
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
		$view['parameters'] = $request->query->all();

		return $view;
	}

	/**
	 * Add user.
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
			return $this->redirect($this->generateUrl('users'));
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

				return $this->redirect($this->generateUrl('users', $request->query->all()));
			}
		}

		$view['form'] = $form->createView();
		$view['backurl'] = 'users';
		$view['parameters'] = $request->query->all();
		$view['title'] = $edit ? "Edycja użytkownika {$user->getName()} {$user->getSurname()}" : "Dodaj nowego użytkownika";

		if ($edit) {
			$view['deleteurl'] = 'deleteuser';
			$view['deleteform'] = $this->createForm(new DeleteType())->createView();
			$view['deleteparameters'] = $view['parameters'];
			$view['deleteparameters']['user'] = $user->getId();
		}

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
		return $this->redirect($this->generateUrl('users'));
	}

	/**
	 * Show list of items.
	 *
	 * @Route("/items", name="items")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function itemsAction(Request $request)
	{
		$view = array('menu' => 'items');

		$items = $this
			->getDoctrine()
			->getEntityManager()
			->createQueryBuilder()
			->select('i')
			->from('DbBundle:Item', 'i')
			->orderBy('i.id')
		;

		$items = new Paginator($items);
		$items->page($request->get('page', 1));
		$view['items'] = $items;

		$view['deleteform'] = $this->createForm(new DeleteType())->createView();
		$view['parameters'] = $request->query->all();

		return $view;
	}

	/**
	 * Add item.
	 *
	 * @Route("/additem", name="additem")
	 * @Template("DbBundle::form.html.twig")
	 *
	 * @param Request $request
	 * @return array|RedirectResponse
	 */
	public function addItemAction(Request $request)
	{
		$item = new Entity\Item();
		return $this->itemAction($request, $item);
	}

	/**
	 * Edit item.
	 *
	 * @Route("/item/{item}", name="edititem")
	 * @Template("DbBundle::form.html.twig")
	 *
	 * @param Request $request
	 * @param int $item
	 * @return array|RedirectResponse
	 */
	public function editItemAction(Request $request, $item)
	{
		if (!$item = $this->getDoctrine()->getRepository('DbBundle:Item')->find($item)) {
			return $this->redirect($this->generateUrl('items'));
		}

		return $this->itemAction($request, $item, true);
	}

	/**
	 * General method to add and edit item.
	 *
	 * @param Request $request
	 * @param Entity\Item $item
	 * @param bool $edit
	 * @return array|RedirectResponse
	 */
	private function itemAction(Request $request, Entity\Item $item, $edit = false)
	{
		$view = array('menu' => 'items');

		$form = $this
			->createFormBuilder($item)
			->add('type', 'choice', array('choices' => array_combine(Entity\Item::getTypes(), Entity\Item::getTypes())))
			->add('name', 'text', array('label' => 'Nazwa'))
			->add('player', 'entity', array('label' => 'Gracz', 'class' => 'DbBundle:Player'))
			->add('intelligence', 'number', array('label' => 'Inteligencja'))
			->add('requiredIntelligence', 'number', array('label' => 'Wymagana inteligencja'))
			->add('dexterity', 'number', array('label' => 'Zręczność'))
			->add('requiredDexterity', 'number', array('label' => 'Wymagana zręczność'))
			->add('mana', 'number', array('label' => 'Mana'))
			->add('requiredMana', 'number', array('label' => 'Wymagana mana'))
			->add('strength', 'number', array('label' => 'Siła'))
			->add('requiredStrength', 'number', array('label' => 'Wymagana siła'))
			->add('weared', 'checkbox', array('label' => 'Noszone', 'required' => false))
			->getForm()
		;

		if ($request->isMethod('POST')) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($item);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');

				return $this->redirect($this->generateUrl('items', $request->query->all()));
			}
		}

		$view['form'] = $form->createView();
		$view['backurl'] = 'items';
		$view['parameters'] = $request->query->all();
		$view['title'] = $edit ? "Edycja itemu {$item->getName()}" : "Dodaj nowy item";

		if ($edit) {
			$view['deleteurl'] = 'deleteitem';
			$view['deleteform'] = $this->createForm(new DeleteType())->createView();
			$view['deleteparameters'] = $view['parameters'];
			$view['deleteparameters']['item'] = $item->getId();
		}

		return $view;
	}

	/**
	 * Delete item.
	 *
	 * @Route("/deleteitem/{item}", name="deleteitem")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @param int $item
	 * @return RedirectResponse
	 */
	public function deleteItemAction(Request $request, $item)
	{
		if ($item = $this->getDoctrine()->getRepository('DbBundle:Item')->find($item)) {
			$form = $this->createForm(new DeleteType());
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->remove($item);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');
			}
		}
		return $this->redirect($this->generateUrl('items'));
	}

	/**
	 * Show list of players.
	 *
	 * @Route("/players", name="players")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function playersAction(Request $request)
	{
		$view = array('menu' => 'players');

		$players = $this
			->getDoctrine()
			->getEntityManager()
			->createQueryBuilder()
			->select('p')
			->from('DbBundle:Player', 'p')
			->orderBy('p.id')
		;

		$players = new Paginator($players);
		$players->page($request->get('page', 1));
		$view['players'] = $players;

		$view['deleteform'] = $this->createForm(new DeleteType())->createView();
		$view['parameters'] = $request->query->all();

		return $view;
	}

	/**
	 * Add player.
	 *
	 * @Route("/addplayer", name="addplayer")
	 * @Template("DbBundle::form.html.twig")
	 *
	 * @param Request $request
	 * @return array|RedirectResponse
	 */
	public function addPlayerAction(Request $request)
	{
		$player = new Entity\Player();

		if ($user = $this->getDoctrine()->getRepository('DbBundle:User')->find($request->get('user', false))) {
			$player->setUser($user);
		}

		return $this->playerAction($request, $player);
	}

	/**
	 * Edit player.
	 *
	 * @Route("/player/{player}", name="editplayer")
	 * @Template("DbBundle::form.html.twig")
	 */
	public function editPlayerAction(Request $request, $player)
	{
		if (!$player = $this->getDoctrine()->getRepository('DbBundle:Player')->find($player)) {
			return $this->redirect($this->generateUrl('players'));
		}

		return $this->playerAction($request, $player, true);
	}

	/**
	 * General method to add and edit player.
	 *
	 * @param Request $request
	 * @param Entity\Player $player
	 * @param bool $edit
	 * @return array|RedirectResponse
	 */
	public function playerAction(Request $request, $player, $edit = false)
	{
		$view = array('menu' => 'players');

		$form = $this
			->createFormBuilder($player)
			->add('user', 'entity', array('label' => 'Użytkownik', 'class' => 'DbBundle:User'))
			->add('name', 'text', array('label' => 'Imię postaci'))
			->add('class', 'entity', array('label' => 'Klasa', 'class' => 'DbBundle:UserClass'))
			->add('race', 'entity', array('label' => 'Rasa', 'class' => 'DbBundle:Race'))
			->add('mana', 'number', array('label' => 'Mana'))
			->add('intelligence', 'number', array('label' => 'Inteligencja'))
			->add('dexterity', 'number', array('label' => 'Zręczność'))
			->add('strength', 'number', array('label' => 'Siła'))
			->getForm()
		;

		if ($request->isMethod('POST')) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($player);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');

				return $this->redirect($this->generateUrl('players', $request->query->all()));
			}
		}

		$view['form'] = $form->createView();
		$view['backurl'] = 'players';
		$view['parameters'] = $request->query->all();
		$view['title'] = $edit ? "Edycja gracza {$player->getName()}" : "Dodaj nowego gracza";

		if ($edit) {
			$view['deleteurl'] = 'deleteplayer';
			$view['deleteform'] = $this->createForm(new DeleteType())->createView();
			$view['deleteparameters'] = $view['parameters'];
			$view['deleteparameters']['player'] = $player->getId();
		}

		return $view;
	}

	/**
	 * Delete player.
	 *
	 * @Route("/deleteplayer/{player}", name="deleteplayer")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @param int $player
	 * @return RedirectResponse
	 */
	public function deletePlayerAction(Request $request, $player)
	{
		if ($player = $this->getDoctrine()->getRepository('DbBundle:Player')->find($player)) {
			$form = $this->createForm(new DeleteType());
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->remove($player);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');
			}
		}
		return $this->redirect($this->generateUrl('players'));
	}

	/**
	 * Show list of races.
	 *
	 * @Route("/races", name="races")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function racesAction(Request $request)
	{
		$view = array('menu' => 'races');

		$races = $this
			->getDoctrine()
			->getEntityManager()
			->createQueryBuilder()
			->select('i')
			->from('DbBundle:Race', 'i')
			->orderBy('i.id')
		;

		$races = new Paginator($races);
		$races->page($request->get('page', 1));
		$view['races'] = $races;

		$view['deleteform'] = $this->createForm(new DeleteType())->createView();
		$view['parameters'] = $request->query->all();

		return $view;
	}

	/**
	 * Add race.
	 *
	 * @Route("/addrace", name="addrace")
	 * @Template("DbBundle::form.html.twig")
	 *
	 * @param Request $request
	 * @return array|RedirectResponse
	 */
	public function addRaceAction(Request $request)
	{
		$race = new Entity\Race();
		return $this->raceAction($request, $race);
	}

	/**
	 * Edit race.
	 *
	 * @Route("/race/{race}", name="editrace")
	 * @Template("DbBundle::form.html.twig")
	 */
	public function editRaceAction(Request $request, $race)
	{
		if (!$race = $this->getDoctrine()->getRepository('DbBundle:Race')->find($race)) {
			return $this->redirect($this->generateUrl('players'));
		}

		return $this->raceAction($request, $race, true);
	}

	/**
	 * General method to add and edit race.
	 *
	 * @param Request $request
	 * @param Entity\Player $race
	 * @param bool $edit
	 * @return array|RedirectResponse
	 */
	public function raceAction(Request $request, $race, $edit = false)
	{
		$view = array('menu' => 'races');

		$form = $this
			->createFormBuilder($race)
			->add('name', 'text', array('label' => 'Nazwa klasy'))
			->add('dexterity', 'number', array('label' => 'Zręczność'))
			->add('intelligence', 'number', array('label' => 'Inteligencja'))
			->add('mana', 'number', array('label' => 'Mana'))
			->add('strength', 'number', array('label' => 'Siła'))
			->getForm()
		;

		if ($request->isMethod('POST')) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($race);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');

				return $this->redirect($this->generateUrl('races', $request->query->all()));
			}
		}

		$view['form'] = $form->createView();
		$view['backurl'] = 'races';
		$view['parameters'] = $request->query->all();
		$view['title'] = $edit ? "Edycja rasy {$race->getName()}" : "Dodaj nową rasę";

		if ($edit) {
			$view['deleteurl'] = 'deleterace';
			$view['deleteform'] = $this->createForm(new DeleteType())->createView();
			$view['deleteparameters'] = $view['parameters'];
			$view['deleteparameters']['race'] = $race->getId();
		}

		return $view;
	}

	/**
	 * Delete race.
	 *
	 * @Route("/deleterace/{race}", name="deleterace")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @param int $race
	 * @return RedirectResponse
	 */
	public function deleteRaceAction(Request $request, $race)
	{
		if ($race = $this->getDoctrine()->getRepository('DbBundle:Race')->find($race)) {
			$form = $this->createForm(new DeleteType());
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->remove($race);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');
			}
		}
		return $this->redirect($this->generateUrl('players'));
	}

	/**
	 * Show list of classes.
	 *
	 * @Route("/classes", name="classes")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function classesAction(Request $request)
	{
		$view = array('menu' => 'classes');

		$classes = $this
			->getDoctrine()
			->getEntityManager()
			->createQueryBuilder()
			->select('i')
			->from('DbBundle:UserClass', 'i')
			->orderBy('i.id')
		;

		$classes = new Paginator($classes);
		$classes->page($request->get('page', 1));
		$view['classes'] = $classes;

		$view['deleteform'] = $this->createForm(new DeleteType())->createView();
		$view['parameters'] = $request->query->all();

		return $view;
	}

	/**
	 * Add class.
	 *
	 * @Route("/addclass", name="addclass")
	 * @Template("DbBundle::form.html.twig")
	 *
	 * @param Request $request
	 * @return array|RedirectResponse
	 */
	public function addClassAction(Request $request)
	{
		$class = new Entity\UserClass();
		return $this->classAction($request, $class);
	}

	/**
	 * Edit race.
	 *
	 * @Route("/class/{class}", name="editclass")
	 * @Template("DbBundle::form.html.twig")
	 */
	public function editClassAction(Request $request, $class)
	{
		if (!$class = $this->getDoctrine()->getRepository('DbBundle:UserClass')->find($class)) {
			return $this->redirect($this->generateUrl('classes'));
		}

		return $this->classAction($request, $class, true);
	}

	/**
	 * General method to add and edit class.
	 *
	 * @param Request $request
	 * @param Entity\Player $class
	 * @param bool $edit
	 * @return array|RedirectResponse
	 */
	public function classAction(Request $request, $class, $edit = false)
	{
		$view = array('menu' => 'classes');

		$form = $this
			->createFormBuilder($class)
			->add('name', 'text', array('label' => 'Nazwa klasy'))
			->add('dexterity', 'number', array('label' => 'Zręczność'))
			->add('intelligence', 'number', array('label' => 'Inteligencja'))
			->add('mana', 'number', array('label' => 'Mana'))
			->add('strength', 'number', array('label' => 'Siła'))
			->getForm()
		;

		if ($request->isMethod('POST')) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($class);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');

				return $this->redirect($this->generateUrl('classes', $request->query->all()));
			}
		}

		$view['form'] = $form->createView();
		$view['backurl'] = 'classes';
		$view['parameters'] = $request->query->all();
		$view['title'] = $edit ? "Edycja klasy {$class->getName()}" : "Dodaj nową klasę";

		if ($edit) {
			$view['deleteurl'] = 'deleterace';
			$view['deleteform'] = $this->createForm(new DeleteType())->createView();
			$view['deleteparameters'] = $view['parameters'];
			$view['deleteparameters']['class'] = $class->getId();
		}

		return $view;
	}

	/**
	 * Delete class.
	 *
	 * @Route("/deleterace/{class}", name="deleteclass")
	 * @Method({"POST"})
	 *
	 * @param Request $request
	 * @param int $class
	 * @return RedirectResponse
	 */
	public function deleteClassAction(Request $request, $class)
	{
		if ($class = $this->getDoctrine()->getRepository('DbBundle:UserClass')->find($class)) {
			$form = $this->createForm(new DeleteType());
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->remove($class);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Zapisano zmiany.');
			}
		}
		return $this->redirect($this->generateUrl('classes'));
	}

	/**
	 * Show list of players that are owned by particular user.
	 *
	 * @Route("/players/{user}", name="userplayers")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function userPlayersAction(Request $request, $user)
	{
		if (!$user = $this->getDoctrine()->getRepository('DbBundle:User')->find($user)) {
			return $this->redirect($this->generateUrl('users'));
		}

		$view = array('menu' => 'players');

		$players = $this
			->getDoctrine()
			->getEntityManager()
			->createQueryBuilder()
			->select('p')
			->from('DbBundle:Player', 'p')
			->where('p.user =' . $user->getId())
			->orderBy('p.id')
		;

		$players = new Paginator($players);
		$players->page($request->get('page', 1));
		$view['players'] = $players;
		$view['user'] = $user;

		$view['deleteform'] = $this->createForm(new DeleteType())->createView();
		$view['parameters'] = $request->query->all();

		return $view;
	}

	/**
	 * Show certain player.
	 *
	 * @Route("/showplayer/{player}", name="showplayer")
	 * @Template()
	 *
	 * @param Request $request
	 * @return array
	 */
	public function showPlayerAction(Request $request, $player)
	{
		if (!$player = $this->getDoctrine()->getRepository('DbBundle:Player')->find($player)) {
			return $this->redirect($this->generateUrl('players'));
		}

		return array('menu' => 'players', 'player' => $player);
	}
}
