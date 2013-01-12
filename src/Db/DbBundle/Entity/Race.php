<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table("Race")
 * @UniqueEntity("name")
 */
class Race extends Entity
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
	 * @ORM\Column(type="string", length=100, nullable=false, unique=true)
	 *
	 * @Assert\NotBlank()
	 * @Assert\MaxLength(100)
	 */
	protected $name;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $intelligence;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $dexterity;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $mana;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $strength;

	public function __toString()
	{
		return $this->getName();
	}
}
