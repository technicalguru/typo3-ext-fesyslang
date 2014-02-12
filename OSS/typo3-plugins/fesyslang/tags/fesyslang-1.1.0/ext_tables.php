<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"tx_fesyslang_lang_uid" => Array (		
		"exclude" => 0,		
		"label" => "LLL:EXT:fesyslang/locallang_db.php:fe_users.tx_fesyslang_lang_uid",		
		"config" => Array (
			"type" => "input",
			"size" => "4",
			"max" => "4",
			"eval" => "int",
			"checkbox" => "0",
			"range" => Array (
				"upper" => "1000",
				"lower" => "-1000"
			),
			"default" => -1
		)
	),
);


t3lib_div::loadTCA("fe_users");
t3lib_extMgm::addTCAcolumns("fe_users",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("fe_users","tx_fesyslang_lang_uid;;;;1-1-1");
?>
