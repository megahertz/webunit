<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megahertz
 * Date: 08.07.13
 * Time: 21:19
 * To change this template use File | Settings | File Templates.
 */

class WuTestRunner
{
	/**
	 * @var WuUnitTestFile[]
	 */
	private $_cases = array();

	public function addTest(WuUnitTestFile $file)
	{
		$this->_cases[] = $file;
	}

	public function run()
	{
		$suite = new PHPUnit_Framework_TestSuite();
		foreach ($this->_cases as $test) {
			$suite->addTestFile($test->getPathname());
		}

		$result = new PHPUnit_Framework_TestResult();
		$log = new WuLog();
		$result->addListener($log);
		try {
			$suite->run($result);
		} catch (Exception $e) {

		}
		return $log->getData();
	}
}