<?php

// Import
include 'function.php';
// Gestion Categorie
$catego_id = 0;
$catego_id = htmlentities ( $_GET ["catego_id"] );
$catego_id = intval ( $catego_id );
if (! is_int ( $catego_id ) || is_int ( $catego_id ) && ($catego_id < 0 || $catego_id > 4)) {
	include 'head.php';
	include 'nav.php';
	include 'error.php';
	include 'foot.php';
	die();
}

$catego = [ 
		"Adherent",
		"Auteur",
		"Oeuvre",
		"Exemplaire",
		"Emprunt" 
];
$page_name = $catego [$catego_id];
// Affichage
include 'head.php';
include 'nav.php';
include 'add_' . strtolower ( $page_name ) . '.php';
include 'foot.php';
