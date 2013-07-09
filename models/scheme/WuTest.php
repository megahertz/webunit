<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megahertz
 * Date: 09.07.13
 * Time: 5:02
 * To change this template use File | Settings | File Templates.
 */

class WuTest
{
	const STATUS_PASS       = 'pass';
	const STATUS_ERROR      = 'error';
	const STATUS_FAILURE    = 'failure';
	const STATUS_INCOMPLETE = 'incomplete';
	const STATUS_SKIPPED    = 'skipped';

	public $name;
	public $status = self::STATUS_PASS;
	public $time;
	public $message;
	public $trace;
	public $output;

	public function isPassed()
	{
		return self::STATUS_PASS == $this->status;
	}

	public function getTestName()
	{
		list($class, $method) = explode('::', $this->name);
		return $method;
	}
}