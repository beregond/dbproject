<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Mob")
 */
class Mob extends Entity
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
	protected $strength;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $description;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $race;

	/**
	 * @ORM\ManyToMany(targetEntity="Place", inversedBy="users")
	 * @ORM\JoinTable(name="users_place")
	 */
	protected $place;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->place = new ArrayCollection();
	}
}
