<?php

// Import
include 'function.php';
// Gestion Categorie
$catego_id = 0;
$fiche_id = - 1;
$catego_id = htmlentities ( $_GET ["catego_id"] );
$catego_id = intval ( $catego_id );
$fiche_id = htmlentities ( $_GET ["fiche_id"] );
$fiche_id = intval ( $fiche_id );
$confirm = intval ( htmlentities ( $_GET ["confirm"] ) );
if (! is_int ( $catego_id ) || is_int ( $catego_id ) && ($catego_id < 0 || $catego_id > 4)) {
	include 'head.php';
	include 'nav.php';
	include 'error.php';
	include 'foot.php';
	die ();
}
if (! is_int ( $fiche_id ) || is_int ( $fiche_id ) && $fiche_id < 1) {
	include 'head.php';
	include 'nav.php';
	include 'error.php';
	include 'foot.php';
	die ();
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
include 'delete_' . strtolower ( $page_name ) . '.php';
include 'foot.php';
