<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="players")
	 */
	protected $user;
}
