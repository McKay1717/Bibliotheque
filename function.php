<?php
function genPanelHeader($title, $id, $catego) {
	print "<div class=\"panel panel-default\">";
	print '<div class="panel-heading clearfix">' . $title . '<span class="pull-right">
				<a href="fiche.php?fiche_id=' . $id . '&catego_id=' . $catego . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true">
				</span></a></span></div>' . "\n";
}
function genPanelFooter($edit = true, $id, $catego) {
	print '<div class="panel-footer clearfix">';
	if ($edit)
		print ' <span class="pull-right">
				<a class="btn btn-primary" href="edit.php?fiche_id=' . $id . '&catego_id=' . $catego . '" role="button">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true">
				</span>
				</a>';
	print '<a class="btn btn-danger" href="delete.php?fiche_id=' . $id . '&catego_id=' . $catego . '" role="button">
				<span class="glyphicon glyphicon-trash" aria-hidden="true">
				</span>
				</a>
				</span>
				</div>';
	print "</div>";
}
function gendAdherentCard($id, $footer = true) {
	include "connexion_bdd.php";
	$requete = "SELECT * FROM ADHERENT WHERE idAdherent=" . $id;
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		genPanelHeader ( $row ['nomAdherent'], $id, 0 );
		print "<div class=\"panel-body\">";
		print "Date de paiement : " . date ( "m.d.y", strtotime ( $row ['datePaiement'] ) ) . "<br> \n";
		print "Adresse : " . $row ['adresse'] . "<br> \n";
		print "</div>";
		if ($footer)
			genPanelFooter ( true, $id, 0 );
		else
			print "</div>";
	}
}
function getAllidAdherent() {
	include "connexion_bdd.php";
	$requete = "SELECT idAdherent FROM ADHERENT";
	$result = array ();
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		array_push ( $result, $row ['idAdherent'] );
	}
	return $result;
}
function genAuteurCard($id, $footer = true) {
	include "connexion_bdd.php";
	$requete = "SELECT * FROM AUTEUR WHERE idAuteur=" . $id;
	$count = 0;
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		genPanelHeader ( $row ['prenomAuteur'] . " " . $row ['nomAuteur'], $id, 1 );
		print '<div class="panel-body clearfix">';
		print "Nombre d'Oeuvre : " . getCountOeuvreConcernedByAuteur ( $id );
		print "</div>";
		if ($footer)
			genPanelFooter ( true, $id, 1 );
		else
			print "</div>";
	}
}
function getAllidAuteur() {
	include "connexion_bdd.php";
	$requete = "SELECT idAuteur FROM AUTEUR";
	$result = array ();
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		array_push ( $result, $row ['idAuteur'] );
	}
	return $result;
}
function gendOeuvreCard($id, $emprunt = false, $empruntinfo = null, $footer = true) {
	include "connexion_bdd.php";
	$requete = "SELECT * FROM OEUVRE WHERE noOeuvre=" . $id;
	$existant = getExemplaireCount ( $id );
	$emprunte = getCountOeuvreConcernedByEmprunt ( $id );
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		
		genPanelHeader ( $row ['titre'], $id, 2 );
		print "<div class=\"panel-body\">";
		print "Date de parution : " . date ( "m.d.y", strtotime ( $row ['dateParution'] ) ) . "<br> \n";
		print "Nombre en Stock : " . ($existant - $emprunte) . "<br> \n";
		print "Nombre Emprunté : " . $emprunte . "<br> \n";
		print "Auteur : " . getAuteurOfOeuvre ( $id ) . "<br> \n";
		print "</div>";
		if ($footer)
			genPanelFooter ( ! $emprunt, $id, 2 );
		else
			print "</div>";
	}
}
function genEmpruntCard($id, $empruntinfo, $footer = true) {
	include "connexion_bdd.php";
	$requete = "SELECT * FROM OEUVRE WHERE noOeuvre=" . $id;
	$existant = getExemplaireCount ( $id );
	$emprunte = getCountOeuvreConcernedByEmprunt ( $id );
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		
		genPanelHeader ( $row ['titre'], $id, -1 );
		print "<div class=\"panel-body\">";
		print "Date de parution : " . date ( "d.m.y", strtotime ( $row ['dateParution'] ) ) . "<br> \n";
		print "Nombre en Stock : " . ($existant - $emprunte) . "<br> \n";
		print "Nombre Emprunté : " . $emprunte . "<br> \n";
		print "Auteur : " . getAuteurOfOeuvre ( $id ) . "<br> \n";
		print "Etat : " . $empruntinfo [2] . "<br> \n";
		print "Prix : " . $empruntinfo [3] . "<br> \n";
		print "Date d'emprunt : " . date ( "d.m.y", strtotime ( $empruntinfo [0] ) ) . "<br> \n";
		print "Date prévu de retour : " . date ( "d.m.y", strtotime ( $empruntinfo [1] ) ) . "<br> \n";
		print "</div>";
		if ($footer)
			genPanelFooter ( false, $empruntinfo [4], 4 );
		else
			print "</div>";
	}
}
//
function genExemplaireCard($id, $footer = true) {
	include "connexion_bdd.php";
	$requete = "SELECT * FROM EXEMPLAIRE WHERE EXEMPLAIRE.noExemplaire = " . $id;
	
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		
		$existant = getExemplaireCount ( $row ['oeuvre_nooeuvre'] );
		$emprunte = getCountOeuvreConcernedByEmprunt ( $row ['oeuvre_nooeuvre'] );
		genPanelHeader ( "Exemplaire n°" . $row ['noExemplaire'], $id, 3 );
		print "<div class=\"panel-body\">";
		print "Date d'Achat : " . date ( "d.m.y", strtotime ( $row ['dateAchat'] ) ) . "<br> \n";
		print "Nombre en Stock : " . ($existant - $emprunte) . "<br> \n";
		print "Nombre Emprunté : " . $emprunte . "<br> \n";
		print "Auteur : " . getAuteurOfOeuvre ( $row ['oeuvre_nooeuvre'] ) . "<br> \n";
		print "Etat : " . $row ["etat"] . "<br> \n";
		print "Prix : " . $row ['prix'] . "<br> \n";
		print "</div>";
		if ($footer)
			genPanelFooter ( true, $id, 3 );
		else
			print "</div>";
	}
}
function getAllnoOeuvre() {
	include "connexion_bdd.php";
	$requete = "SELECT noOeuvre FROM OEUVRE";
	$result = array ();
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		array_push ( $result, $row ['noOeuvre'] );
	}
	return $result;
}
function getExemplaireCount($noOeuvre) {
	include "connexion_bdd.php";
	$requete = "SELECT COUNT(*) FROM EXEMPLAIRE WHERE oeuvre_nooeuvre=" . $noOeuvre;
	$result = $ma_connexion_mysql->prepare ( $requete );
	$result->execute ();
	$number_of_rows = $result->fetchColumn ();
	return $number_of_rows;
}
function getCountOeuvreConcernedByEmprunt($noOeuvre) {
	include "connexion_bdd.php";
	$requete = "SELECT COUNT(*) FROM `EMPRUNT`, OEUVRE, EXEMPLAIRE WHERE ( OEUVRE.noOeuvre = " . $noOeuvre . " AND OEUVRE.noOeuvre = EXEMPLAIRE.oeuvre_nooeuvre AND EXEMPLAIRE.noExemplaire = exemplaire_noexemplaire)";
	$resultSQL = $ma_connexion_mysql->prepare ( $requete );
	$resultSQL->execute ();
	$number_of_rows = $resultSQL->fetchColumn ();
	$result = $number_of_rows;
	return $result;
}
function getCountOeuvreConcernedByAuteur($idAuteur) {
	include "connexion_bdd.php";
	$requete = "SELECT COUNT(*) FROM `OEUVRE` where auteur_idAuteur=" . $idAuteur;
	$resultSQL = $ma_connexion_mysql->prepare ( $requete );
	$resultSQL->execute ();
	$number_of_rows = $resultSQL->fetchColumn ();
	$result = $number_of_rows;
	return $result;
}
function getAuteurOfOeuvre($noOeuvre) {
	include "connexion_bdd.php";
	$requete = "SELECT AUTEUR.nomAuteur, AUTEUR.prenomAuteur FROM OEUVRE, AUTEUR WHERE (
    OEUVRE.noOeuvre = " . $noOeuvre . "  AND
    OEUVRE.auteur_idauteur= AUTEUR.idAuteur)";
	$row = $ma_connexion_mysql->query ( $requete )->fetch ( PDO::FETCH_ASSOC );
	return $row ["prenomAuteur"] . " " . $row ["nomAuteur"];
}
function getOeuvreConcernedByAdherent($idAdherent) {
	include "connexion_bdd.php";
	$sql = "SELECT EMPRUNT.exemplaire_noexemplaire, OEUVRE.noOeuvre ,EMPRUNT.dateEmprunt, EMPRUNT.dateRendu, EXEMPLAIRE.etat, EXEMPLAIRE.prix FROM OEUVRE, ADHERENT,EMPRUNT,EXEMPLAIRE WHERE (\n" . " ADHERENT.idAdherent = " . $idAdherent . " AND \n" . " ADHERENT.idAdherent = EMPRUNT.adherent_idadherent AND \n" . " EMPRUNT.exemplaire_noexemplaire = EXEMPLAIRE.noExemplaire AND\n" . " EXEMPLAIRE.oeuvre_nooeuvre = OEUVRE.noOeuvre )";
	$result = array ();
	foreach ( $ma_connexion_mysql->query ( $sql ) as $row ) {
		array_push ( $result, [ 
				$row ['noOeuvre'] => [ 
						$row ['dateEmprunt'],
						$row ['dateRendu'],
						$row ['etat'],
						$row ['prix'],
						$row ['exemplaire_noexemplaire']
				] 
		] );
	}
	return $result;
}
function getIdInSGBDSimpleWhere($requete, $key, $value) {
	include "connexion_bdd.php";
	$requete .= $value;
	$result = array ();
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		array_push ( $result, $row [$key] );
	}
	return $result;
}
function getOeuvreByAuteur($idauteur) {
	$requete = "SELECT OEUVRE.noOeuvre FROM OEUVRE WHERE OEUVRE.auteur_idauteur=";
	return getIdInSGBDSimpleWhere ( $requete, 'noOeuvre', $idauteur );
}
function getExemplaireByAdherent($idauteur) {
	$requete = "SELECT EMPRUNT.exemplaire_noexemplaire FROM OEUVRE WHERE EMPRUNT.adherent_idadherent = ";
	return getIdInSGBDSimpleWhere ( $requete, 'exemplaire_noexemplaire', $idauteur );
}
function listExempeplaireofOeuvre($noOeuvre) {
	$requete = "SELECT noExemplaire FROM EXEMPLAIRE WHERE oeuvre_nooeuvre=";
	return getIdInSGBDSimpleWhere ( $requete, 'noExemplaire', $noOeuvre );
}
function deleteAdherent($idAdherent) {
	include "connexion_bdd.php";
	$requete = 'DELETE FROM `ADHERENT` WHERE `idAdherent`=' . $idAdherent;
	$ma_connexion_mysql->exec ( $requete );
}
function deleteAuteur($idauteur) {
	include "connexion_bdd.php";
	$requete = 'DELETE FROM `AUTEUR` WHERE `idAuteur`=' . $idauteur;
	$ma_connexion_mysql->exec ( $requete );
}
function deleteOeuvre($noOeuvre) {
	include "connexion_bdd.php";
	$requete = 'DELETE FROM `OEUVRE` WHERE `noOeuvre`=' . $noOeuvre;
	$ma_connexion_mysql->exec ( $requete );
}
function deleteExemplaire($noexemplaire) {
	include "connexion_bdd.php";
	$requete = 'DELETE FROM `EXEMPLAIRE` WHERE `noexemplaire`=' . $noexemplaire;
	$ma_connexion_mysql->exec ( $requete );
}
function listAdherentByExemplaire($noexemplaire) {
	$requete = "SELECT adherent_idadherent  FROM EMPRUNT WHERE exemplaire_noexemplaire=";
	return getIdInSGBDSimpleWhere ( $requete, 'adherent_idadherent', $noexemplaire );
}
function GetNoOeuvreOfExemplaire($noexemplaire) {
	$requete = "SELECT oeuvre_nooeuvre FROM EXEMPLAIRE WHERE noExemplaire=";
	return getIdInSGBDSimpleWhere ( $requete, 'oeuvre_nooeuvre', $noexemplaire );
}
function check_date($x) {
	return (date ( 'Y-m-d', strtotime ( $x ) ) == $x);
}
function validateAdherentForm($nom, $paiment, $adresse) {
	$return = [ 
			false,
			false,
			false 
	];
	if (strlen ( $nom ) == 0)
		$return [0] = true;
	if (strlen ( $paiment ) == 0 || ! check_date ( $paiment ))
		$return [1] = true;
	if (strlen ( $adresse ) == 0)
		$return [2] = true;
	if (! $return [0] && ! $return [1] && ! $return [2]) {
		return true;
	} else {
		return $return;
	}
}
function addAdherent($nom, $paiment, $adresse) {
	include "connexion_bdd.php";
	$requete = 'INSERT INTO ADHERENT(nomAdherent, datePaiement, adresse) VALUES ("' . $nom . '","' . $paiment . '","' . $adresse . '")';
	$ma_connexion_mysql->exec ( $requete );
	return $ma_connexion_mysql->lastInsertId ();
}
function validateAuteurForm($nom, $prenom) {
	$return = [ 
			false,
			false 
	];
	if (strlen ( $nom ) == 0)
		$return [0] = true;
	if (strlen ( $prenom ) == 0)
		$return [1] = true;
	if (! $return [0] && ! $return [1]) {
		return true;
	} else {
		return $return;
	}
}
function addAuteur($nom, $prenom) {
	include "connexion_bdd.php";
	$requete = 'INSERT INTO AUTEUR(nomAuteur, prenomAuteur) VALUES ("' . $nom . '","' . $prenom . '")';
	$ma_connexion_mysql->exec ( $requete );
	return $ma_connexion_mysql->lastInsertId ();
}
function getAuteurName($idAuteur) {
	include "connexion_bdd.php";
	$requete = 'SELECT `nomAuteur`, `prenomAuteur` FROM `AUTEUR` WHERE `idAuteur`=' . $idAuteur;
	$r = $ma_connexion_mysql->query ( $requete )->fetch ();
	return $r ['nomAuteur'] . " " . $r ['prenomAuteur'];
}
function validateOeuvreForm($titre, $date, $id) {
	include "connexion_bdd.php";
	$requete = "SELECT count(*) FROM AUTEUR WHERE idAuteur=" . $id;
	$return = [ 
			false,
			false,
			false 
	];
	if (strlen ( $titre ) == 0)
		$return [0] = true;
	if (strlen ( $date ) == 0 || ! check_date ( $date ))
		$return [1] = true;
	if (! is_int ( $id ) || (intval ( $ma_connexion_mysql->query ( $requete )->fetchColumn () ) != 1 && $id != - 1))
		$return [2] = true;
	if (! $return [0] && ! $return [1] && ! $return [2]) {
		return true;
	} else {
		return $return;
	}
}
function addOeuvre($titre, $date, $id) {
	include "connexion_bdd.php";
	$requete = 'INSERT INTO OEUVRE(auteur_idauteur,titre, dateParution) VALUES (' . $id . ',"' . $titre . '","' . $date . '")';
	$ma_connexion_mysql->exec ( $requete );
	return $ma_connexion_mysql->lastInsertId ();
}
function GetOeuvreTitle($noOeuvre) {
	include "connexion_bdd.php";
	$requete = "SELECT titre FROM OEUVRE WHERE noOeuvre=" . $noOeuvre;
	$titre = $ma_connexion_mysql->query ( $requete )->fetchColumn ();
	return $titre;
}
function validateExemplaireForm($prix, $achat, $etat, $noOeuvre) {
	include "connexion_bdd.php";
	$requete = "SELECT count(*) FROM OEUVRE WHERE noOeuvre=" . $noOeuvre;
	$return = [ 
			false,
			false,
			false,
			false 
	];
	if (strlen ( $prix ) == 0 || ! is_numeric ( $prix ))
		$return [0] = true;
	if (strlen ( $achat ) == 0 || ! check_date ( $achat ))
		$return [1] = true;
	if (strlen ( $etat ) == 0 || strlen ( $etat ) > 5)
		$return [2] = true;
	if (! is_int ( $noOeuvre ) || (intval ( $ma_connexion_mysql->query ( $requete )->fetchColumn () ) != 1 && $noOeuvre != - 1))
		$return [3] = true;
	if (! $return [0] && ! $return [1] && ! $return [2] && ! $return [3]) {
		return true;
	} else {
		return $return;
	}
}
function addExemplaire($prix, $achat, $etat, $noOeuvre) {
	include "connexion_bdd.php";
	$requete = 'INSERT INTO EXEMPLAIRE(dateAchat, etat, prix, oeuvre_nooeuvre) VALUES ("' . $achat . '","' . $etat . '",' . $prix . ',' . $noOeuvre . ')';
	
	$ma_connexion_mysql->exec ( $requete );
	return $ma_connexion_mysql->lastInsertId ();
}
function GetAdherentName($idAdherent) {
	include "connexion_bdd.php";
	$requete = "SELECT nomAdherent FROM ADHERENT WHERE idAdherent=" . $idAdherent;
	
	$nom = $ma_connexion_mysql->query ( $requete )->fetchColumn ();
	return $nom;
}
function validateEmpruntForm($idAdherent, $noExempalaire, $dateEmprunt, $dateRetour) {
	include "connexion_bdd.php";
	$requeteAdherent = "SELECT count(*) FROM ADHERENT WHERE idAdherent=" . $idAdherent;
	$requeteExemplaire = "SELECT count(*) FROM EXEMPLAIRE WHERE noExemplaire=" . $noExempalaire;
	$return = [ 
			false,
			false,
			false,
			false 
	];
	if (strlen ( $dateEmprunt ) == 0 || ! check_date ( $dateEmprunt ))
		$return [0] = true;
	
	if (strlen ( $dateRetour ) == 0 || ! check_date ( $dateRetour ))
		$return [1] = true;
	
	if (! is_int ( $idAdherent ) || (intval ( $ma_connexion_mysql->query ( $requeteAdherent )->fetchColumn () ) != 1 && $idAdherent != - 1))
		$return [2] = true;
	
	if (! is_int ( $noExempalaire ) || (intval ( $ma_connexion_mysql->query ( $requeteExemplaire )->fetchColumn () ) != 1 && $noExempalaire != - 1))
		$return [3] = true;
	if (! $return [0] && ! $return [1] && ! $return [2] && ! $return [3]) {
		return true;
	} else {
		return $return;
	}
}
function addEmprunt($idAdherent, $noExempalaire, $dateEmprunt, $dateRetour) {
	include "connexion_bdd.php";
	$requete = 'INSERT INTO EMPRUNT(adherent_idadherent, exemplaire_noexemplaire, dateEmprunt, dateRendu) VALUES (' . $idAdherent . ',' . $noExempalaire . ',"' . $dateEmprunt . '","' . $dateRetour . '")';
	$ma_connexion_mysql->exec ( $requete );
	return $ma_connexion_mysql->lastInsertId ();
}
function getAdherentInfo($id) {
	include "connexion_bdd.php";
	$requete = "SELECT nomAdherent, datePaiement, adresse FROM ADHERENT WHERE  idAdherent=" . $id;
	$prepare = $ma_connexion_mysql->prepare ( $requete );
	$prepare->execute ();
	$result = $prepare->fetch ();
	return [ 
			$result ['nomAdherent'],
			$result ['datePaiement'],
			$result ['adresse'] 
	];
}
function editAdherent($nom, $paiment, $adresse, $idAdherent) {
	include "connexion_bdd.php";
	$requete = 'UPDATE  ADHERENT SET nomAdherent="' . $nom . '",datePaiement="' . $paiment . '",adresse="' . $adresse . '" WHERE idAdherent=' . $idAdherent;
	
	$ma_connexion_mysql->exec ( $requete );
}
function getAuteurInfo($id) {
	include "connexion_bdd.php";
	$requete = "SELECT nomAuteur, prenomAuteur FROM AUTEUR WHERE  idAuteur=" . $id;
	$prepare = $ma_connexion_mysql->prepare ( $requete );
	$prepare->execute ();
	$result = $prepare->fetch ();
	return [ 
			$result ['nomAuteur'],
			$result ['prenomAuteur'] 
	];
}
function editAuteur($nom, $prenom, $idAuteur) {
	include "connexion_bdd.php";
	$requete = 'UPDATE AUTEUR SET nomAuteur="' . $nom . '",prenomAuteur="' . $prenom . '"WHERE idAuteur=' . $idAuteur;
	$ma_connexion_mysql->exec ( $requete );
}
function getOeuvreInfo($id) {
	include "connexion_bdd.php";
	$requete = "SELECT auteur_idauteur, titre, dateParution FROM OEUVRE WHERE noOeuvre=" . $id;
	$prepare = $ma_connexion_mysql->prepare ( $requete );
	$prepare->execute ();
	$result = $prepare->fetch ();
	return [ 
			$result ['auteur_idauteur'],
			$result ['titre'],
			$result ['dateParution'] 
	];
}
function editOeuvre($titre, $date, $id, $noOeuvre) {
	include "connexion_bdd.php";
	$requete = 'UPDATE OEUVRE SET  auteur_idauteur=' . $id . ',titre="' . $titre . '",dateParution="' . $date . '"WHERE noOeuvre=' . $noOeuvre;
	$ma_connexion_mysql->exec ( $requete );
}
function getExemplaireInfo($id) {
	include "connexion_bdd.php";
	$requete = "SELECT  dateAchat, etat, prix, oeuvre_nooeuvre FROM `EXEMPLAIRE` WHERE noExemplaire=" . $id;
	$prepare = $ma_connexion_mysql->prepare ( $requete );
	$prepare->execute ();
	$result = $prepare->fetch ();
	return [ 
			$result ['dateAchat'],
			$result ['etat'],
			$result ['prix'],
			$result ['oeuvre_nooeuvre'] 
	];
}
function editExemplaire($prix, $achat, $etat, $noOeuvre, $noExemplaire) {
	include "connexion_bdd.php";
	$requete = 'UPDATE EXEMPLAIRE SET dateAchat="' . $achat . '",etat="' . $etat . '",prix=' . $prix . ',oeuvre_nooeuvre=' . $noOeuvre . ' WHERE noExemplaire=' . $noExemplaire;
	
	$ma_connexion_mysql->exec ( $requete );
}
function AdherentExist($idAdherent) {
	include "connexion_bdd.php";
	$requeteAdherent = "SELECT count(*) FROM ADHERENT WHERE idAdherent=" . $idAdherent;
	return intval ( $ma_connexion_mysql->query ( $requeteAdherent )->fetchColumn () ) == 1;
}
function AuteurExist($idAuteur) {
	include "connexion_bdd.php";
	$requeteAdherent = "SELECT count(*) FROM AUTEUR WHERE idAuteur=" . $idAuteur;
	return intval ( $ma_connexion_mysql->query ( $requeteAdherent )->fetchColumn () ) == 1;
}
function ExemplaireExist($noExemplaire) {
	include "connexion_bdd.php";
	$requeteAdherent = "SELECT count(*) FROM EXEMPLAIRE WHERE noExemplaire=" . $noExemplaire;
	return intval ( $ma_connexion_mysql->query ( $requeteAdherent )->fetchColumn () ) == 1;
}
function OeuvreExist($noOeuvre) {
	include "connexion_bdd.php";
	$requeteAdherent = "SELECT count(*) FROM OEUVRE WHERE noOeuvre=" . $noOeuvre;
	return intval ( $ma_connexion_mysql->query ( $requeteAdherent )->fetchColumn () ) == 1;
}
function getIdInSGBDComplexWhere($requete, $key) {
	include "connexion_bdd.php";
	$result = array ();
	foreach ( $ma_connexion_mysql->query ( $requete ) as $row ) {
		array_push ( $result, $row [$key] );
	}
	return $result;
}
function searchInAdherent($search) {
	$requete = 'SELECT idAdherent FROM ADHERENT WHERE nomAdherent LIKE "%' . $search . '%" OR datePaiement LIKE "%' . $search . '%" OR adresse LIKE "%' . $search . '%"';
	return getIdInSGBDComplexWhere ( $requete, 'idAdherent' );
}
function searchInAuteur($search) {
	$requete = 'SELECT idAuteur FROM AUTEUR WHERE nomAuteur LIKE "%' . $search . '%" OR prenomAuteur LIKE "%' . $search . '%"';
	return getIdInSGBDComplexWhere ( $requete, 'idAuteur' );
}
function searchInOeuvre($search) {
	$requete = 'SELECT noOeuvre FROM OEUVRE WHERE titre LIKE "%' . $search . '%" OR dateParution LIKE "%' . $search . '%"';
	return getIdInSGBDComplexWhere ( $requete, 'noOeuvre' );
}
function EmpruntExist($noExemplaire) {
	include "connexion_bdd.php";
	$requeteAdherent = "SELECT count(*) FROM EMPRUNT WHERE exemplaire_noexemplaire=" . $noExemplaire;
	return intval ( $ma_connexion_mysql->query ( $requeteAdherent )->fetchColumn () ) == 1;
}
function deleteEmprunt($noexemplaire) {
	include "connexion_bdd.php";
	$requete = 'DELETE FROM `EMPRUNT` WHERE `exemplaire_noexemplaire`=' . $noexemplaire;
	$ma_connexion_mysql->exec ( $requete );
}