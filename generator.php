<?php

include_once '../KrisSkarboApi/generator.php';
RETURN;
$generator = new Generator( "localhost", "root", "", "budget_test", Generator::MODE_DAO_STANDARD );

$generator->onlyTables = array( "budget_budget" );
$generator->prefixIgnore = "budget_";

$generator->doGenerate( realpath( "./" ) );

?>