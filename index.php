<?php 
	
	// Ruta del proyecto
	define("PROJECTPATH", __DIR__);

	// Tipo de seprador de carpetas para cada SO
	define("DS", DIRECTORY_SEPARATOR);

	// Ruta de las vistas
	define("VIEWSPATH", PROJECTPATH . DS ."views");

	date_default_timezone_set("America/Bogota");

	// Inluimos el App.php 
	require_once 'Core/App.php';

	// Obtenemos una instancia de App.php
	$instance = \Core\App::getInstance();

	// Lanzamos la aplicacion
	$instance->run();

?>