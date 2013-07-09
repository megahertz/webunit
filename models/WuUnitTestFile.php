<?php
class WuUnitTestFile extends SplFileInfo
{
	public function getClassName()
	{
		return $this->getBasename('.php');
	}

	public function getRelativePath()
	{
		$base = WuHelpers::getUnitTestsPath();
		$path = str_replace($base, '', $this->getPath());
		if ($path && DIRECTORY_SEPARATOR == $path[0]) {
			$path = substr($path, 1);
		}
		return $path;
	}

	public function getRelativePathName()
	{
		$path = $this->getRelativePath();
		if ($path) {
			$path .= DIRECTORY_SEPARATOR;
		}
		return $path . $this->getBasename();
	}

	public static function fromRelativePathName($pathName)
	{
		$base = WuHelpers::getUnitTestsPath();
		return new self($base . DIRECTORY_SEPARATOR . $pathName);
	}
}