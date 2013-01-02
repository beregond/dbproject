<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table("Users")
 * @UniqueEntity("email")
 */
class User extends Entity
{
	/**
	 * @var int
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\MaxLength(100)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\MaxLength(100)
	 */
	protected $surname;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100, unique=true, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 * @Assert\MaxLength(100)
	 */
	protected $email;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Player", mappedBy="user")
	 */
	protected $players;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->players = new ArrayCollection();
	}

	/**
	 * Stringify.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->getName();
	}
}
