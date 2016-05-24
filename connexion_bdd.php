<?php
include ("config.php"); // 4 constantes : database ; hostname ; username ; password
try {
	$dsn = 'mysql:dbname=' . database . ';host=' . hostname . ";charset=utf8";
	$ma_connexion_mysql = new PDO ( $dsn, username, password );
	$ma_connexion_mysql->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$ma_connexion_mysql->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	$ma_connexion_mysql->exec ( "SET CHARACTER SET utf8" );
} catch ( PDOException $Exception ) {
	// Note The Typecast To An Integer!
	$error = ( int ) $Exception->getCode ();
	include 'error_BDD.php';
	die ();
}
