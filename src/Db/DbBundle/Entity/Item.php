<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Item")
 */
class Item
{
	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $type;
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
	protected $strenght
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $required_intelligence;
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $required_dexterity;
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $required_mana;
	/**
	* @ORM\Column(type="Integer")
	*/
	protected $required_strenght;
	/**
	* @ORM\ManyToOne(targetEntity="Player", inversedBy="Item")
	*/
	protected $player;
}
?>
