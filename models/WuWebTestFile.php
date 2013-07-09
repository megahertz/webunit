<?php

class WuWebTestFile extends WuUnitTestFile
{
	public function getRelativePath()
	{
		$base = WuHelpers::getWebTestPath();
		$path = str_replace($base, '', $this->getPath());
		if ($path && DIRECTORY_SEPARATOR == $path[0]) {
			$path = substr($path, 1);
		}
		return $path;
	}

	public static function fromRelativePathName($pathName)
	{
		$base = WuHelpers::getWebTestPath();
		return new self($base . DIRECTORY_SEPARATOR . $pathName);
	}
}