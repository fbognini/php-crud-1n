<?php
    // altervista
	/*
    $databaseHost = 'localhost';
    $databaseName = 'my_francescobognini';
    $databaseUsername = '';
    $databasePassword = '';
	*/
    // server2go
    $databaseHost = 'localhost';
    $databaseName = 'crud';
    $databaseUsername = 'root';
    $databasePassword = '';

    
    $driver = new mysqli_driver();
    // $driver->report_mode = MYSQLI_REPORT_ALL;
    
    try {
		$mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName) ;
	} catch (Exception $e ) {
		echo "Service unavailable";
		echo "message: " . $e->message;   // not in live code obviously...
		exit;
	} 
?>