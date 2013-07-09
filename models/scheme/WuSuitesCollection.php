<?php

class WuSuitesCollection implements IteratorAggregate
{
	private $_collection = array();
	private $_currentSuite = null;

	public function createSuite($name = '', $testsCount = 0)
	{
		$suite = new WuSuite();
		$suite->name = $name;
		$suite->testsCount = 0;

		$this->_currentSuite = $suite;
		$this->_collection[] = $suite;

		return $suite;
	}

	/**
	 * @return WuSuite
	 */
	public function getCurrentSuite()
	{
		return $this->_currentSuite;
	}

	public function getCurrentTest()
	{
		if ($this->_currentSuite) {
			return $this->getCurrentSuite()->getCurrentTest();
		}
		return null;
	}

	/**
	 * @return ArrayIterator|WuSuite[]
	 */
	public function getIterator()
	{
		$tests = array_filter($this->_collection, function(WuSuite $suite) {
			return $suite->name || $suite->getTestsCount();
		});
		return new ArrayIterator($tests);
	}
}