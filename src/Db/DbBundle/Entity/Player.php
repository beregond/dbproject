<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table("Player")
 * @UniqueEntity("name")
 */
class Player extends Entity
{
	/**
	 * @var int
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100, unique=true)
	 *
	 * @Assert\NotBlank()
	 * @Assert\MinLength(3)
	 * @Assert\MaxLength(100)
	 * @Assert\Regex("/^[\w]*$/")
	 */
	protected $name;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $mana;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $intelligence;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $experience_points;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $dexterity;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $strength;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="players")
	 */
	protected $user;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Item", mappedBy="player")
	 */
	protected $item;

	/**
	 * @var UserClass
	 *
	 * @ORM\ManyToOne(targetEntity="UserClass")
	 */
	protected $class;

	/**
	 * @var Race
	 *
	 * @ORM\ManyToOne(targetEntity="Race", inversedBy="Player")
	 */
	protected $race;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="Quest", mappedBy="Player")
	 */
	protected $quest;

	/**
	 * @ORM\OneToOne(targetEntity="Place")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	protected $place;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->item = new ArrayCollection();
		$this->quest = new ArrayCollection();
	}
}
