<?php
Yii::import('webunit.models.scheme.*');

class WuLog implements PHPUnit_Framework_TestListener
{
	/**
	 * @var WuSuitesCollection
	 */
	private $_collection;

	public function __construct()
	{
		$this->_collection = new WuSuitesCollection();
	}

	/**
	 * An error occurred.
	 *
	 * @param  PHPUnit_Framework_Test $test
	 * @param  Exception $e
	 * @param  float $time
	 */
	public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		$this->writeCase(
			WuTest::STATUS_ERROR,
			$time,
			PHPUnit_Util_Filter::getFilteredStacktrace($e, false),
			$e->getMessage(),
			$test
		);
	}

	/**
	 * A failure occurred.
	 *
	 * @param  PHPUnit_Framework_Test $test
	 * @param  PHPUnit_Framework_AssertionFailedError $e
	 * @param  float $time
	 */
	public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
	{
		$this->writeCase(
			WuTest::STATUS_FAILURE,
			$time,
			PHPUnit_Util_Filter::getFilteredStacktrace($e, false),
			$e->getMessage(),
			$test
		);
	}

	/**
	 * Incomplete test.
	 *
	 * @param  PHPUnit_Framework_Test $test
	 * @param  Exception $e
	 * @param  float $time
	 */
	public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		$this->writeCase(
			WuTest::STATUS_INCOMPLETE,
			$time,
			PHPUnit_Util_Filter::getFilteredStacktrace($e, false),
			$e->getMessage(),
			$test
		);
	}

	/**
	 * Skipped test.
	 *
	 * @param  PHPUnit_Framework_Test $test
	 * @param  Exception $e
	 * @param  float $time
	 * @since  Method available since Release 3.0.0
	 */
	public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		$this->writeCase(
			WuTest::STATUS_SKIPPED,
			$time,
			PHPUnit_Util_Filter::getFilteredStacktrace($e, false),
			$e->getMessage(),
			$test
		);
	}

	/**
	 * A test suite started.
	 *
	 * @param  PHPUnit_Framework_TestSuite $suite
	 * @since  Method available since Release 2.2.0
	 */
	public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
	{
		$this->_collection->createSuite($suite->getName(), count($suite));
	}

	/**
	 * A test suite ended.
	 *
	 * @param  PHPUnit_Framework_TestSuite $suite
	 * @since  Method available since Release 2.2.0
	 */
	public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
	{
	}

	/**
	 * A test started.
	 *
	 * @param  PHPUnit_Framework_Test $test
	 */
	public function startTest(PHPUnit_Framework_Test $test)
	{
		$this->_collection->getCurrentSuite()->createTest(PHPUnit_Util_Test::describe($test));
	}

	/**
	 * A test ended.
	 *
	 * @param  PHPUnit_Framework_Test $test
	 * @param  float $time
	 */
	public function endTest(PHPUnit_Framework_Test $test, $time)
	{
		if ($this->_collection->getCurrentTest()->isPassed()) {
			$this->writeCase(WuTest::STATUS_PASS, $time, array(), '', $test);
		}
	}

	/**
	 * @param string $status
	 * @param float  $time
	 * @param array  $trace
	 * @param string $message
	 * @param PHPUnit_Framework_Test $test
	 */
	protected function writeCase($status, $time, array $trace = array(), $message = '', $test = null)
	{
		$output = '';
		if (null !== $test && $test->hasOutput()) {
			$output = $test->getActualOutput();
		}

		if ($t = $this->_collection->getCurrentTest()) {
			$t->status  = self::u($status);
			$t->time    = self::u($time);
			$t->trace   = self::u($trace);
			$t->message = self::u($message);
			$t->output  = self::u($output);
		}
	}

	/**
	 * @return WuSuitesCollection
	 */
	public function getData()
	{
		return $this->_collection;
	}

	/**
	 * Convert input to utf
	 * @param $input
	 * @return string
	 */
	private function u($input)
	{
		if (is_array($input)) {
			array_walk_recursive($input, function(&$input) {
				if (is_string($input)) {
					$input = PHPUnit_Util_String::convertToUtf8($input);
				}
			});
			return $input;
		} else {
			return PHPUnit_Util_String::convertToUtf8($input);
		}
	}
}