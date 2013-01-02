<?php

namespace Db\DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Gneral class for all entities.
 */
abstract class Entity
{
	/**
	 * Magic getter and setter for entity.
	 *
	 * @throws \Exception
	 * @param string $method
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		if (preg_match('/^set/', $method)) {
			$prop = lcfirst(preg_replace('/^set/', '', $method));

			if ($this->$prop instanceof ArrayCollection) {
				throw new \Exception('You can\'t overwrite "'.$prop.'" property.');
			}

			$this->$prop = array_shift($arguments);
		} elseif (preg_match('/^get/', $method)) {
			$prop = lcfirst(preg_replace('/^get/', '', $method));
			if (!property_exists(get_class($this), $prop)) {
				throw new \Exception(sprintf('There\'s no property named "%s"', $prop));
			}
			return $this->$prop;
		} else {
			$vars = array_keys(get_object_vars($this));
			if (in_array($method, $vars)) {
				return call_user_func_array(array($this, 'get' . ucfirst($method)), $arguments);
			}
			throw new \Exception('Method "'.$method.'" is not defined.');
		}
	}

	/**
	 * Triggered while accessing entity property.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		return call_user_func(array($this, 'get' . ucfirst($name)));
	}

	/**
	 * Triggered while setting entity property.
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		return call_user_func(array($this, 'set' . ucfirst($name)), $value);
	}
}
