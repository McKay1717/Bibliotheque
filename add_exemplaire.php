<?php
$prix = 0;
$achat = "2017-02-14";
$etat = "";
$noOeuvre = - 1;
$error = [ ];
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	if (strlen ( $_POST ['prix'] ) != 0)
		$prix = htmlentities ( $_POST ['prix'] );
	if (strlen ( $_POST ['achat'] ) != 0)
		$achat = htmlentities ( $_POST ['achat'] );
	if (strlen ( $_POST ['etat'] ) != 0)
		$etat = htmlentities ( $_POST ['etat'] );
	if (strlen ( $_POST ['noOeuvre'] ) != 0)
		$noOeuvre = intval ( htmlentities ( $_POST ['noOeuvre'] ) );
	if (validateExemplaireForm ( $prix, $achat, $etat, $noOeuvre ) === true) {
		if ($noOeuvre == - 1) {
			$_SESSION ["prix"] = $prix;
			$_SESSION ["achat"] = $achat;
			$_SESSION ["noOeuvre"] = $noOeuvre;
			$_SESSION ['etat'] = $etat;
			$_SESSION ["CreateOeuvre"] = true;
			$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
			$host = $_SERVER ['HTTP_HOST'];
			$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
			$extra = 'add.php?catego_id=2';
			header ( "Location: $protocol$host$uri/$extra" );
			die ();
		}
		$i = addExemplaire ( $prix, $achat, $etat, $noOeuvre );
		if ($_SESSION ["CreateExemplaire"]) {
			$_SESSION ["noExempalaire"] = $i;
			$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
			$host = $_SERVER ['HTTP_HOST'];
			$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
			$extra = 'add.php?catego_id=4';
			header ( "Location: $protocol$host$uri/$extra" );
			die ();
		}
		$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
		$host = $_SERVER ['HTTP_HOST'];
		$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
		$extra = 'fiche.php?fiche_id=' . $noOeuvre . '&catego_id=2';
		header ( "Location: $protocol$host$uri/$extra" );
		die ();
	} else {
		$error = validateExemplaireForm ( $prix, $achat, $etat, $noOeuvre );
	}
} else if (count ( $_SESSION ) != 0) {
	
	if ($_SESSION ["CreateOeuvre"]) {
		$prix = $_SESSION ["prix"];
		$achat = $_SESSION ["achat"];
		$noOeuvre = $_SESSION ["noOeuvre"];
		$etat = $_SESSION ['etat'];
		unset ( $_SESSION ["CreateOeuvre"] );
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
		<label for="prix">Prix d'achat</label> <input type="text"
			class="form-control" id="prix" name="prix"
			placeholder="<?php echo $prix;?>"
			<?php if($overlay) print 'value="'.$prix.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[1] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="achat">Date d'achat</label> <input type="datetime"
			class="form-control" id="achat" name="achat"
			placeholder="<?php echo $achat;?>"
			<?php if($overlay) print 'value="'.$achat.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[2] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="etat">Etat</label>
		<input type="datetime" class="form-control" id="etat" name="etat"
			placeholder="<?php echo $etat;?>"
			<?php if($overlay) print 'value="'.$etat.'"'?>></input>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[3] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="id">Oeuvre</label> <select id="noOeuvre" name="noOeuvre"
			class="form-control">
			<option value="-1">Saisir une nouvelle oeuvre</option>
		<?php
		foreach ( getAllnoOeuvre () as $useless => $id ) {
			if ($noOeuvre == $id)
				$tmp = "selected";
			print '<option value="' . $id . '"' . $tmp . '>' . GetOeuvreTitle ( $id ) . '</option>';
			unset ( $tmp );
		}
		?>
		</select>
	</div>
	<button type="submit" class="btn btn-default">Ajouter</button>
</form>