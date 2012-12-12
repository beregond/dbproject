<?php

namespace Db\DbBundle\Util;

use Doctrine\ORM\Tools\Pagination;

/**
 * Class to make pagination (based on \Doctrine\ORM\Query(Builder)) easier.
 */
class Paginator implements \Countable, \IteratorAggregate
{
	/**
	 * Reference to Doctrine's Paginator.
	 *
	 * @var \Doctrine\ORM\Tools\Pagination\Paginator
	 */
	protected $_paginator;

	/**
	 * Reference to input query.
	 *
	 * @var \Doctrine\ORM\QueryBuilder
	 */
	protected $_query;

	/**
	 * Page number.
	 *
	 * @var int
	 */
	protected $_page;

	/**
	 * Amount of results per page.
	 *
	 * @var int
	 */
	protected $_perpage;

	/**
	 * Param for paginator.
	 *
	 * @var bool
	 */
	protected $_fetchJoinCollection;

	/**
	 * Inner cache.
	 *
	 * @var array
	 */
	protected $_cache = array();

	/**
	 * Constructor.
	 *
	 * @param $query
	 * @param int $page = 1
	 * @param int $perpage = 20
	 * @param bool $fetchJoinCollection = true
	 * @return null
	 */
	public function __construct($query, $page = 1, $perpage = 20, $fetchJoinCollection = true)
	{
		$this->_query = $query;
		$this->_fetchJoinCollection = $fetchJoinCollection;
		$this->page($page);
		$this->perPage($perpage);
	}

	/**
	 * Initializing paginator project.
	 *
	 * @return null
	 */
	public function init()
	{
		if (isset($this->_cache['inited']) and $this->_cache['inited']) {
			return;
		}

		if ($this->_perpage > 0) {
			$this->_query->setMaxResults($this->_perpage);
			if ($this->_page > 0) {
				$this->_query->setFirstResult(($this->_page - 1) * $this->_perpage);
			}
		}

		$this->_paginator = new Pagination\Paginator($this->_query, $this->_fetchJoinCollection);
		$this->_cache['inited'] = true;
	}

	/**
	 * Counts amount of results.
	 *
	 * Implementation of \Countable interface. What's important it counts results on current page, not like
	 * Doctrine Paginator all results.
	 *
	 * @return int
	 */
	public function count()
	{
		if (!isset($this->_cache['count'])) {
			$this->init();
			$x = 0;
			$all = count($this->_paginator);
			if ($this->_perpage < 1 or $all == 0) {
				$x = $all;
			} else {
				if ($this->getPage() == $this->countPages()) {
					$x = ($r = $all % $this->_perpage) ? $r : $this->_perpage;
				} else {
					$x = $this->_perpage;
				}
			}

			$this->_cache['count'] = $x;
		}
		return $this->_cache['count'];
	}

	/**
	 * Counts pages.
	 *
	 * @return int
	 */
	public function countPages()
	{
		if (!isset($this->_cache['countpages'])) {
			if ($this->_perpage < 1) {
				$x = 1;
			} else {
				$this->init();
				$x = ceil($this->_paginator->count()/$this->_perpage);
			}

			$this->_cache['countpages'] = $x;
		}
		return $this->_cache['countpages'];
	}

	/**
	 * Returns iterator of paginator
	 *
	 * Implementation of \IteratorAggregate interface
	 *
	 * @return \Traversable
	 */
	public function getIterator()
	{
		$this->init();
		return $this->_paginator->getIterator();
	}

	/**
	 * Sets current page.
	 *
	 * @return null
	 */
	public function page($page)
	{
		$page = (int) $page;
		$all = $this->countPages();
		if ($page > $all) {
			$page = $all;
		}
		if ($page < 1) {
			$page = 1;
		}

		$this->_page = $page;
		$this->resetCache();
	}

	/**
	 * Alias for page().
	 *
	 * @return null
	 */
	public function setPage($page)
	{
		return $this->page($page);
	}

	/**
	 * Returns current page.
	 *
	 * @return int
	 */
	public function getPage()
	{
		return $this->_page;
	}

	/**
	 * Sets amount of results per page.
	 *
	 * @param int $perpage
	 * @return null
	 */
	public function perPage($perpage)
	{
		$this->_perpage = $perpage;
		$this->resetCache();
	}

	/**
	 * Get amount of results per page.
	 *
	 * @return int
	 */
	public function getPerpage()
	{
		return $this->_perpage;
	}

	/**
	 * Reseting inner cache.
	 *
	 * @return null
	 */
	protected function resetCache()
	{
		$this->_cache = array();
	}

	/**
	 * Creating array with numeration.
	 *
	 * @return array
	 */
	public function getNumeration()
	{
		$result = array();
		$startpage = 1;
		$endpage = $this->countPages();
		$page = $this->getPage();

		if ($startpage >= $endpage) {
			return array();
		}

		$numeration = array();
		$all = $endpage - $startpage + 1;

		$numeration[] = array('title' => $startpage, 'page' => $startpage);
		if ($all <= 5) {
			for($i = $startpage + 1; $i < $endpage; $i++) {
				$numeration[] = array('title' => $i, 'page' => $i);
			}
		} elseif ($startpage > $page - 3) {
			for($i = $startpage + 1; $i <= $startpage + 3; $i++) {
				$numeration[] = array('title' => $i, 'page' => $i);
			}
			$numeration[] = array('title' => '...');
		} elseif ($endpage < $page + 3) {
			$numeration[] = array('title' => '...');
			for($i = $endpage - 3; $i < $endpage; $i++) {
				$numeration[] = array('title' => $i, 'page' => $i);
			}
		} else {
			$numeration[] = array('title' => '...');
			for($i = $page - 1; $i <= $page + 1; $i++) {
				$numeration[] = array('title' => $i, 'page' => $i);
			}
			$numeration[] = array('title' => '...');
		}
		$numeration[] = array('title' => $endpage, 'page' => $endpage);

		$result['numeration'] = $numeration;
		$result['active'] = $page;

		return $result;
	}

	/**
	 * Returns start index.
	 *
	 * @return int
	 */
	public function getStartIndex()
	{
		return ($this->getPage() - 1) * $this->getPerPage();
	}
}
