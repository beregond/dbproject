<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("NPC")
 */
class NPC extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Place", inversedBy="NPC")
	 */
	protected $place;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $name;

	 /**
	 * @ORM\ManyToMany(targetEntity="Quest", inversedBy="NPC")
	 * @ORM\JoinTable(name="Quest_NPC")
	 */
	private $quest;

	public function __construct()
	{
		$this->quest = new ArrayCollection();
	}
}
