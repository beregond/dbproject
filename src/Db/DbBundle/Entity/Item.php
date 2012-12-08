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
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $type;
	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $name;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $intelligence;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $dexterity;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $mana;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $strenght;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $required_intelligence;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $required_dexterity;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $required_mana;
	/**
	* @ORM\Column(type="integer")
	*/
	protected $required_strenght;
	/**
	* @ORM\ManyToOne(targetEntity="Player", inversedBy="item")
	*/
	protected $player;
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $weared = false;
}

