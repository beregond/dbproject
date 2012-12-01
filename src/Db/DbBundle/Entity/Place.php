<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Place")
 */
Class Place
{
	/**
    * @OneToOne(targetEntity="Place", mappedBy="user")
    */
    private $user;
	/**
	 * @ORM\OneToMany(targetEntity="NPC", mappedBy="Place")
	 */
	protected $npc;/**
     * @ManyToMany(targetEntity="Mob", mappedBy="Place")
     */
    private $Mob;

	public function __construct()
	{
		$this->npc = new ArrayCollection();
		$this->mob = new ArrayCollection();
	}
	

}
?>
