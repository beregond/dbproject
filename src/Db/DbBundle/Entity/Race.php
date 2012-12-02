<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Race")
 */
Class Race
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
	 * @ORM\OneToMany(targetEntity="Player", mappedBy="Race")
	 */
	protected $players;

	public function __construct()
	{
		$this->players = new ArrayCollection();
	}
}

