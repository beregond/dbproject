<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Quest")
 */
class Quest extends Entity
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
	 * @ORM\Column(type="string", length=100)
	 */
	protected $reward;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $description;

	 /**
	 * @ORM\ManyToMany(targetEntity="Player", inversedBy="Quest")
	 * @ORM\JoinTable(name="Player_Quest")
	 */
	protected $Player;

	/**
 	 * @ORM\ManyToMany(targetEntity="NPC", mappedBy="Quest")
 	 */
	protected $npc;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->Player = new ArrayCollection();
		$this->npc = new ArrayCollection();
	}
}
