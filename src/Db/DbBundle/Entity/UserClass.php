<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Class")
 */
Class UserClass
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
	 * @ORM\OneToMany(targetEntity="Player", mappedBy="Class")
	 */
	protected $players;

	public function __construct()
	{
		$this->players = new ArrayCollection();
	}
}

 
?>
