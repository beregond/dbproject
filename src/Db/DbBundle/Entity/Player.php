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
	 * @ORM\Column(type="integer", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	protected $mana = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	protected $intelligence = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 */
	protected $experience_points = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	protected $dexterity = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer", nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	protected $strength = 0;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="players", cascade={"persist"})
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

	public function __toString()
	{
		return $this->getName();
	}

	public function getSummaryIntelligence()
	{
		$sum = 0;
		foreach ($this->getItem() as $item) {
			if ($item->getWeared()) {
				$sum += $item->getIntelligence();
			}
		}
		$sum += $this->getIntelligence() + $this->getClass()->getIntelligence() + $this->getRace()->getIntelligence();
		return $sum;
	}

	public function getSummaryMana()
	{
		$sum = 0;
		foreach ($this->getItem() as $item) {
			if ($item->getWeared()) {
				$sum += $item->getMana();
			}
		}
		$sum += $this->getMana() + $this->getClass()->getMana() + $this->getRace()->getMana();
		return $sum;
	}

	public function getSummaryDexterity()
	{
		$sum = 0;
		foreach ($this->getItem() as $item) {
			if ($item->getWeared()) {
				$sum += $item->getDexterity();
			}
		}
		$sum += $this->getDexterity() + $this->getClass()->getDexterity() + $this->getRace()->getDexterity();
		return $sum;
	}

	public function getSummaryStrength()
	{
		$sum = 0;
		foreach ($this->getItem() as $item) {
			if ($item->getWeared()) {
				$sum += $item->getStrength();
			}
		}
		$sum += $this->getStrength() + $this->getClass()->getStrength() + $this->getRace()->getStrength();
		return $sum;
	}
}
