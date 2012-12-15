<?php
namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table("Item")
 */
class Item extends Entity
{
	/**
	 * Allowed types.
	 */
	const HELMET = 'helmet';
	const BUCKLER = 'buckler';
	const GLOVES = 'gloves';
	const LEGGINGS = 'leggings';
	const SWORD = 'sword';
	const SHIELD = 'shield';

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
	 * @ORM\Column(type="string", length=100)
	 *
	 * @Assert\NotBlank()
	 * @Assert\MaxLength(100)
	 */
	protected $type;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100)
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
	protected $intelligence = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $dexterity = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $mana = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $strength = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $requiredIntelligence = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $requiredDexterity = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $requiredMana = 0;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 *
	 * @Assert\NotBlank()
	 * @Assert\Min(0)
	 */
	protected $requiredStrength = 0;

	/**
	 * @var bool
	 *
	 * @ORM\Column(type="boolean")
	 */
	protected $weared = false;

	/**
	 * @var object
	 *
	 * @ORM\ManyToOne(targetEntity="Player", inversedBy="item")
	 */
	protected $player;

	/**
	 * Returns allowed types.
	 *
	 * @return array
	 */
	public static function getTypes()
	{
		return array(
			self::HELMET,
			self::BUCKLER,
			self::GLOVES,
			self::LEGGINGS,
			self::SWORD,
			self::SHIELD,
		);
	}
}
