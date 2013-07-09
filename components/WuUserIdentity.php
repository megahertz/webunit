<?php

class WuUserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 * @throws CException
	 */
	public function authenticate()
	{
		$password=Yii::app()->getModule('webunit')->password;
		if($password===null)
			throw new CException('Please configure the "password" property of the "webunit" module.');
		elseif($password===false || $password===$this->password)
			$this->errorCode=self::ERROR_NONE;
		else
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
		return !$this->errorCode;
	}
}