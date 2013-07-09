<?php
/**
 * Class WuController
 * @property WebunitModule $module
 */
class WuController extends CController
{
	public $layout='/layouts/tests';

	public function getPageTitle()
	{
		if($this->action->id==='index')
			return 'Webunit: a Web-based phpunit test runner for Yii';
		else
			return 'Webunit - '.ucfirst($this->action->id).' test';
	}

	public function actionIndex()
	{
		$this->layout = 'tests';
		$this->render('index');
	}

	public function actionUnit($test)
	{
		$unit = new WuTestRunner();
		$unit->addTest(WuUnitTestFile::fromRelativePathName($test));
		$this->render('unit', array(
			'data'     => $unit->run(),
			'testName' => $test
		));
	}

	public function actionWeb($test)
	{
		$unit = new WuTestRunner();
		$unit->addTest(WuWebTestFile::fromRelativePathName($test));
		echo $unit->run();
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=Yii::createComponent('webunit.models.WuLoginForm');

		// collect user input data
		if(isset($_POST['WuLoginForm']))
		{
			$model->attributes=$_POST['WuLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->createUrl('webunit/default/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirect(Yii::app()->createUrl('webunit/default/index'));
	}

	/**
	 * Returns a value indicating whether the call stack is from application code.
	 * @param array $trace the trace data
	 * @return boolean whether the call stack is from application code.
	 */
	public function __isCoreCode($trace)
	{
		if (isset($trace['file'])) {
			$systemPath = realpath(dirname(__FILE__) . '/..');
			return $trace['file'] === 'unknown' || strpos(realpath($trace['file']), $systemPath . DIRECTORY_SEPARATOR) === 0;
		}
		return false;
	}

	/**
	 * Renders the source code around the error line.
	 * @param string $file source file path
	 * @param integer $errorLine the error line number
	 * @param integer $maxLines maximum number of lines to display
	 * @return string the rendering result
	 */
	protected function renderSourceCode($file,$errorLine,$maxLines)
	{
		$errorLine--;	// adjust line number to 0-based from 1-based
		if($errorLine<0 || ($lines=@file($file))===false || ($lineCount=count($lines))<=$errorLine)
			return '';

		$halfLines=(int)($maxLines/2);
		$beginLine=$errorLine-$halfLines>0 ? $errorLine-$halfLines:0;
		$endLine=$errorLine+$halfLines<$lineCount?$errorLine+$halfLines:$lineCount-1;
		$lineNumberWidth=strlen($endLine+1);

		$output='';
		for($i=$beginLine;$i<=$endLine;++$i)
		{
			$isErrorLine = $i===$errorLine;
			$code=sprintf("<span class=\"ln".($isErrorLine?' error-ln':'')."\">%0{$lineNumberWidth}d</span> %s",$i+1,CHtml::encode(str_replace("\t",'    ',$lines[$i])));
			if(!$isErrorLine)
				$output.=$code;
			else
				$output.='<span class="error">'.$code.'</span>';
		}
		return '<div class="code"><pre>'.$output.'</pre></div>';
	}

	/**
	 * Converts arguments array to its string representation
	 *
	 * @param array $args arguments array to be converted
	 * @return string string representation of the arguments array
	 */
	protected function argumentsToString($args)
	{
		$count=0;

		$isAssoc=$args!==array_values($args);

		foreach($args as $key => $value)
		{
			$count++;
			if($count>=5)
			{
				if($count>5)
					unset($args[$key]);
				else
					$args[$key]='...';
				continue;
			}

			if(is_object($value))
				$args[$key] = get_class($value);
			elseif(is_bool($value))
				$args[$key] = $value ? 'true' : 'false';
			elseif(is_string($value))
			{
				if(strlen($value)>64)
					$args[$key] = '"'.substr($value,0,64).'..."';
				else
					$args[$key] = '"'.$value.'"';
			}
			elseif(is_array($value))
				$args[$key] = 'array('.$this->argumentsToString($value).')';
			elseif($value===null)
				$args[$key] = 'null';
			elseif(is_resource($value))
				$args[$key] = 'resource';

			if(is_string($key))
			{
				$args[$key] = '"'.$key.'" => '.$args[$key];
			}
			elseif($isAssoc)
			{
				$args[$key] = $key.' => '.$args[$key];
			}
		}
		$out = implode(", ", $args);

		return $out;
	}
}