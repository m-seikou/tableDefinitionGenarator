<?php

function readSTDIN()
{
	$string = '';
	while ($line = fgets(STDIN)) {
		$string .= $line;
	}
	return $string;
}

function createDir($dir)
{
	if (file_exists($dir)) {
		return is_dir($dir);
	}
	return mkdir($dir);
}

function createHTML(array $args, string $templateFilePath)
{
	if (array_key_exists('templateFilePath', $args)) {
		throw new Exception('', 1);
	}
	extract($args, EXTR_OVERWRITE);

	ob_start();
	include $templateFilePath;
	return ob_get_clean();
}