<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("Player")
 */
class Player
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
        protected $mana;
        /**
		* @ORM\Column(type="integer")
		*/
		protected $intelligence;
        /**
		* @ORM\Column(type="integer")
		*/
		protected $experience_points;
        /**
		* @ORM\Column(type="integer")
		*/
		protected $dexterity;
        /**
		* @ORM\Column(type="integer")
		*/
		protected $Strenght;
		/**
		 * @ORM\ManyToOne(targetEntity="User", inversedBy="Player")
		 */
		protected $user;
		/**
		 * @ORM\OneToMany(targetEntity="Item", inversedBy="Player")
		 */
		 protected $item;
		 
		 public function __construct()
		{
			$this->item = new ArrayCollection();
			$this->quest = new ArrayCollection();
		}
		/**
		 * @ORM\ManyToOne(targetEntity="Class", inversedBy="Player")
		 */
		protected $Class;
				/**
		 * @ORM\ManyToOne(targetEntity="Race", inversedBy="Player")
		 */
		protected $Race;
		/**
		 * @ManyToMany(targetEntity="Quest", mappedBy="Player")
		 */
		private $Quest;
}
