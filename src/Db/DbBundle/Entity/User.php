<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Users")
 */
class User
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
	 * @ORM\Column(type="string", length=100)
	 */
	protected $surname;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $email;

	/**
	 * @ORM\OneToMany(targetEntity="Player", mappedBy="user")
	 */
	protected $players;

	public function __construct()
	{
		$this->players = new ArrayCollection();
	}
	/**
     * @ORM\OneToOne(targetEntity="Place", inversedBy="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $place;
}

?>
