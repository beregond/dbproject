<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Mob")
 */
Class Mob
{
	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $name;
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $intelligence;
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $dexterity;
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $mana;
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $strenght;
	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $description;
	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $race;
	/**
     * @ManyToMany(targetEntity="Place", inversedBy="users")
     * @JoinTable(name="users_place")
     */
    private $place;

    public function __construct() {
        $this->place = new ArrayCollection();
    }
}

