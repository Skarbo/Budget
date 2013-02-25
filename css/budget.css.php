<?php

include_once '../../krisskarboapi/css/css.css.php';

// Css files
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "font" ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "core" ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "view" ) );

// Css generate
FileUtil::generateFiles( $CSS_FILES, __FILE__, FileUtil::TYPE_CSS );

?>