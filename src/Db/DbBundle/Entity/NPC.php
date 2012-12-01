<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("NPC")
 */
Class NPC
{
	/**
	 * @ORM\ManyToOne(targetEntity="Place", inversedBy="NPC")
	 */
	protected $Place;
	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $name;
	 /**
     * @ManyToMany(targetEntity="Quest", inversedBy="NPC")
     * @JoinTable(name="Quest_NPC")
     */
    private $quest;

    public function __construct() {
        $this->quest = new ArrayCollection();
    }
}
