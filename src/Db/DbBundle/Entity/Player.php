<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Player")
 */
class Player extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $mana;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $intelligence;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $experience_points;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $dexterity;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $Strenght;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="player")
	 */
	protected $user;

	/**
	 * @ORM\OneToMany(targetEntity="Item", mappedBy="player")
	 */
	protected $item;

	/**
	 * @ORM\ManyToOne(targetEntity="UserClass", inversedBy="Player")
	 */
	protected $Class;

			/**
	 * @ORM\ManyToOne(targetEntity="Race", inversedBy="Player")
	 */
	protected $Race;

	/**
	 * @ORM\ManyToMany(targetEntity="Quest", mappedBy="Player")
	 */
	protected $Quest;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->item = new ArrayCollection();
		$this->quest = new ArrayCollection();
	}
}
