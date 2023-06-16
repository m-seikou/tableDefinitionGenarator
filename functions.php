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

const SYSTEM_COLUMNS = [1 => 'created_at', 2 => 'updated_at'];
function sortField(SimpleXMLElement $table)
{
    $primary = [];
    $normal = [];
    $system = SYSTEM_COLUMNS;
    foreach ($table->key as $keyElement) {
        if ((string)$keyElement['Key_name'] !== 'PRIMARY') {
            continue;
        }
        $primary[(string)$keyElement['Seq_in_index']] = (string)$keyElement['Column_name'];
    }
    foreach ($table->field as $fieldElement) {
        $colName = (string)$fieldElement['Field'];
        if ($index = array_search($colName, $primary, true)) {
            $primary[$index] = clone $fieldElement;
        } else if ($index = array_search($colName, $system, true)) {
            $system[$index] = clone $fieldElement;
        } else {
            $normal[$colName] = clone $fieldElement;
        }
    }
    ksort($primary);
    ksort($normal);
    ksort($system);

    unset($table->field);
    $function = function($parent,$child){
        if(!$child instanceof SimpleXMLElement) {
            return;
        }
        $field = $parent->addChild('field');
        if(!$field instanceof SimpleXMLElement){
            return;
        }
        foreach ($child->attributes() as $name => $value) {
            $field->addAttribute($name, (string)$value);
        }
    };
    foreach ($primary as $fieldElement) {
        $function($table,$fieldElement);
    }
    foreach ($normal as $fieldElement) {
        $function($table,$fieldElement);
    }
    foreach ($system as $fieldElement) {
        $function($table,$fieldElement);
    }
}