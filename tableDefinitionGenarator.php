<?php

const DS = DIRECTORY_SEPARATOR;
const APP_ROOT = __DIR__ . DS;
const TML_ROOT = APP_ROOT . 'template' . DS;
const SKIP_DATABASES = ['sys', 'mysql', 'information_schema', 'performance_schema'];

include_once APP_ROOT . 'functions.php';

$outputDir = APP_ROOT . 'output' . DS;
if (!createDir($outputDir)) {
	exit(0);
}

$tblList = [];
$tblData = [];
foreach (simplexml_load_string(readSTDIN())->database as $database) {
	$dbName = (string)$database->attributes()['name'];
	if (in_array($dbName, SKIP_DATABASES, true)) {
		continue;
	}
	if (!createDir($outputDir . $dbName)) {
		exit(0);
	}

	$tblList[$dbName] = [];
	$tblData[$dbName] = [];
	foreach ($database->table_structure as $table) {
		$tblName = (string)$table->attributes()['name'];
		$tblList[$dbName][] = $tblName;
		$tblData[$dbName][$tblName] = $table;
		unset($tblName, $table);
	}
	unset($dbName, $database);
}

$html = createHTML(['tblList' => $tblList], TML_ROOT . 'index.php');
file_put_contents($outputDir . 'index.html', $html);

foreach ($tblData as $dbName => $database) {
	foreach ($database as $tblName => $table) {
		echo "create $dbName.$tblName" . PHP_EOL;
		$html = createHTML(['tblList' => $tblList, 'table' => $table], TML_ROOT . 'tblDetail.php');
		file_put_contents($outputDir . DS . $dbName . DS . $tblName . '.html', $html);
	}
}

copy(TML_ROOT . 'default.css', $outputDir . DS . 'default.css');
