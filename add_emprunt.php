<?php
$idAdherent = - 1;
$noExempalaire = - 1;
$dateEmprunt = "2017-02-14";
$dateRetour = "";
$error = [ ];
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	if (strlen ( $_POST ['dateRetour'] ) != 0)
		$dateRetour = htmlentities ( $_POST ['dateRetour'] );
	if (strlen ( $_POST ['dateEmprunt'] ) != 0)
		$dateEmprunt = htmlentities ( $_POST ['dateEmprunt'] );
	if (strlen ( $_POST ['idAdherent'] ) != 0)
		$idAdherent = intval ( htmlentities ( $_POST ['idAdherent'] ) );
	if (strlen ( $_POST ['noExempalaire'] ) != 0)
		$noExempalaire = intval ( htmlentities ( $_POST ['noExempalaire'] ) );
	if (validateEmpruntForm ( $idAdherent, $noExempalaire, $dateEmprunt, $dateRetour ) === true) {
		if ($idAdherent == - 1) {
			$_SESSION ["idAdherent"] = $idAdherent;
			$_SESSION ["noExempalaire"] = $noExempalaire;
			$_SESSION ["dateEmprunt"] = $dateEmprunt;
			$_SESSION ['dateRetour'] = $dateRetour;
			$_SESSION ["CreateAdherent"] = true;
			$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
			$host = $_SERVER ['HTTP_HOST'];
			$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
			$extra = 'add.php?catego_id=0';
			header ( "Location: $protocol$host$uri/$extra" );
			die ();
		}
		if ($noExempalaire == - 1) {
			$_SESSION ["idAdherent"] = $idAdherent;
			$_SESSION ["noExempalaire"] = $noExempalaire;
			$_SESSION ["dateEmprunt"] = $dateEmprunt;
			$_SESSION ['dateRetour'] = $dateRetour;
			$_SESSION ["CreateExemplaire"] = true;
			$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
			$host = $_SERVER ['HTTP_HOST'];
			$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
			$extra = 'add.php?catego_id=3';
			header ( "Location: $protocol$host$uri/$extra" );
			die ();
		}
		addEmprunt( $idAdherent, $noExempalaire, $dateEmprunt, $dateRetour );
		$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
		$host = $_SERVER ['HTTP_HOST'];
		$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
		$extra = 'fiche.php?fiche_id=' . $idAdherent . '&catego_id=0';
		header ( "Location: $protocol$host$uri/$extra" );
		die ();
	} else {
		$error = validateEmpruntForm ( $idAdherent, $noExempalaire, $dateEmprunt, $dateRetour );
	}
} else if (count ( $_SESSION ) != 0) {
	
	if ($_SESSION ["CreateExemplaire"] && $_SESSION ["noExempalaire"] != -1) {
		$idAdherent = $_SESSION ["idAdherent"];
		$noExempalaire = $_SESSION ["noExempalaire"];
		$dateEmprunt = $_SESSION ["dateEmprunt"];
		$dateRetour = $_SESSION ['dateRetour'];
		unset ( $_SESSION ["CreateExemplaire"] );
		$error = [ 
				false,
				false,
				false,
				false 
		];
	}
	if ($_SESSION ["CreateAdherent"] && $_SESSION ["idAdherent"] != -1) {
		$idAdherent = $_SESSION ["idAdherent"];
		$noExempalaire = $_SESSION ["noExempalaire"];
		$dateEmprunt = $_SESSION ["dateEmprunt"];
		$dateRetour = $_SESSION ['dateRetour'];
		unset ( $_SESSION ["CreateAdherent"] );
		$error = [ 
				false,
				false,
				false,
				false 
		];
	}
	if (isset ( $_SESSION ["CreateOeuvre"], $_SESSION ["CreateAuteur"], $_SESSION ["CreateAdherent"], $_SESSION ["CreateExemplaire"],$_SESSION ["EditOeuvre"]  )) {
		session_unset ();
	}
}
$overlay = count ( $error ) != 0;
?>
<form class="col-md-8 col-md-offset-2" method="post"
	action="add.php<?php print '?catego_id='.$catego_id?>">
	<div
		class="form-group <?php if($overlay) $echo =$error[0] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="dateEmprunt">Date d'emprunt</label> <input type="datetime"
			class="form-control" id="dateEmprunt" name="dateEmprunt"
			placeholder="<?php echo $dateEmprunt;?>"
			<?php if($overlay) print 'value="'.$dateEmprunt.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[1] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="dateRetour">Date de retour</label> <input type="datetime"
			class="form-control" id="dateRetour" name="dateRetour"
			placeholder="<?php echo $dateRetour;?>"
			<?php if($overlay) print 'value="'.$dateRetour.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[2] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="idAdherent">Adherent</label> <select id="idAdherent"
			name="idAdherent" class="form-control">
			<option value="-1">Saisir un nouvelle Adherent</option>
		<?php
		foreach ( getAllidAdherent () as $useless => $id ) {
			if ($idAdherent == $id)
				$tmp = "selected";
			print '<option value="' . $id . '"' . $tmp . '>' . GetAdherentName ( $id ) . '</option>';
			unset ( $tmp );
		}
		?>
		</select>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[3] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="noExempalaire">Exemplaire</label> <select
			id="noExempalaire" name="noExempalaire" class="form-control">
			<option value="-1">Saisir un nouvelle exemplaire</option>
		<?php
		foreach ( getAllnoOeuvre () as $useless => $id ) {
			print '<optgroup label="' . GetOeuvreTitle ( $id ) . '">';
			foreach ( listExempeplaireofOeuvre ( $id ) as $useless2 => $idE ) {
				if ($noExempalaire == $idE)
					$tmp = "selected";
				print '<option value="' . $idE . '"' . $tmp . '>Exemplaire n°' . $idE . '</option>';
				unset ( $tmp );
			}
			print '<optgroup>';
		}
		?>
		</select>
	</div>
	<button type="submit" class="btn btn-default">Ajouter</button>
</form>