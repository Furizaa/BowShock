<?php
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/../src'),
    get_include_path(),
)));

function namespace_autoload($className) {
	$fileName = dirname(__FILE__) . '/../src/' . str_replace('\\', '/', $className) . '.php';
	if (file_exists($fileName)) {
		require_once $fileName;
	}	
}

spl_autoload_register(namespace_autoload);
spl_autoload_extensions('.php');
