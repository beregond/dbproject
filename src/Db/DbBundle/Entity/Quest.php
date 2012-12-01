<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Quest")
 */
Class Quest
{
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
     * @ManyToMany(targetEntity="Player", inversedBy="Quest")
     * @JoinTable(name="Player_Quest")
     */
    private $Player;
	/**
	 * @ManyToMany(targetEntity="NPC", mappedBy="Quest")
	 */
	private $npc;

    public function __construct() {
        $this->Player = new ArrayCollection();
        $this->npc = new ArrayCollection();
    }

}
