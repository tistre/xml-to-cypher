<?php

require_once __DIR__ . '/vendor/autoload.php';

use StrehleDe\XmlToCypher\Import\SimpleImportScript;

$script = new SimpleImportScript();
$script->convertFileToCypher($argv[1]);
