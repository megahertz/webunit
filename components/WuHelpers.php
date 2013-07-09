<?php

class WuHelpers
{
	const TEST_TYPE_UNIT = 'unit';
	const TEST_TYPE_WEB  = 'web';

	/**
	 * @return WebunitModule
	 */
	public static function getModule()
	{
		return Yii::app()->getModule('webunit');
	}

	/**
	 * @param string $type
	 * @param string $path
	 * @return WuUnitTestFile[]|WuWebTestFile[]
	 */
	public static function findTestFiles($type = self::TEST_TYPE_UNIT, $path = null)
	{
		if (null === $path) {
			if (self::TEST_TYPE_UNIT === $type) {
				$path = self::getUnitTestsPath();
			} else {
				$path = self::getWebTestPath();
			}
		}

		$path = realpath($path);
		$tests = array();

		$directory = new RecursiveDirectoryIterator($path);
		$flattened = new RecursiveIteratorIterator($directory);
		$files = new RegexIterator($flattened, '/^.+Test.+\.php$/Di');

		foreach($files as $f) {
			$tests[] = self::TEST_TYPE_UNIT === $type ? new WuUnitTestFile($f) : new WuWebTestFile($f);
		}

		return $tests;
	}

	public static function getUnitTestsPath()
	{
		return Yii::getPathOfAlias(self::getModule()->pathUnitTests);
	}

	public static function getWebTestPath()
	{
		return Yii::getPathOfAlias(self::getModule()->pathWebTests);
	}
}