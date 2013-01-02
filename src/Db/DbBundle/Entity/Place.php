<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Place")
 */
class Place extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="NPC", mappedBy="Place")
	 */
	protected $npc;

	/**
	 * @ORM\ManyToMany(targetEntity="Mob", mappedBy="Place")
	 */
	protected $Mob;

	public function __construct()
	{
		$this->npc = new ArrayCollection();
		$this->mob = new ArrayCollection();
	}
}
