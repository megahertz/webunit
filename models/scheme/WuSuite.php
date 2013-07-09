<?php

class WuSuite implements IteratorAggregate
{
	public $name;
	public $testsCount;

	private $_tests = array();
	private $_currentTest;

	public function createTest($name = null)
	{
		$test = new WuTest();
		$test->name = $name;

		$this->_tests[] = $test;
		$this->_currentTest = $test;

		return $test;
	}

	/**
	 * @return WuTest
	 */
	public function getCurrentTest()
	{
		return $this->_currentTest;
	}

	/**
	 * @return ArrayIterator|WuTest[]
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->_tests);
	}

	public function isPassed()
	{
		foreach ($this->getIterator() as $test) {
			if (!$test->isPassed()) {
				return false;
			}
		}
		return true;
	}

	public function getCountPassed()
	{
		$count = 0;
		foreach ($this->getIterator() as $test) {
			$count += $test->isPassed();
		}
		return $count;
	}

	public function getCountFailure()
	{
		$count = 0;
		foreach ($this->getIterator() as $test) {
			$count += !$test->isPassed();
		}
		return $count;
	}

	public function getTestsCount()
	{
		return count($this->getIterator());
	}

	public function getStatus()
	{
		$count = $this->getTestsCount();
		$pass  = $this->getCountPassed();

		if (0 == $count && 0 == $pass) {
			return WuTest::STATUS_SKIPPED;
		} else if ($pass < $count) {
			return WuTest::STATUS_FAILURE;
		} else {
			return WuTest::STATUS_PASS;
		}
	}
}