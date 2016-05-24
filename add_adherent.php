<?php
$nom = "Hubert";
$paiment = "2017-02-14";
$adresse = "";
$error = [ ];
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	if (strlen ( $_POST ['nom'] ) != 0)
		$nom = htmlentities ( $_POST ['nom'] );
	if (strlen ( $_POST ['Paiement'] ) != 0)
		$paiment = htmlentities ( $_POST ['Paiement'] );
	if (strlen ( $_POST ['adresse'] ) != 0)
		$adresse = htmlentities ( $_POST ['adresse'] );
	if (validateAdherentForm ( $nom, $paiment, $adresse ) === true) {
		$i = addAdherent ( $nom, $paiment, $adresse );
		if ($_SESSION ["CreateAdherent"]) {
			$_SESSION ["idAdherent"] = $i;
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
		$extra = 'index.php?catego_id=' . $catego_id;
		header ( "Location: $protocol$host$uri/$extra" );
		die ();
	} else {
		$error = validateAdherentForm ( $nom, $paiment, $adresse );
	}
}
$overlay = count ( $error ) != 0;
?>
<form class="col-md-8 col-md-offset-2" method="post"
	action="add.php<?php print '?catego_id='.$catego_id?>">
	<div
		class="form-group <?php if($overlay) $echo =$error[0] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="nom">Nom</label> <input type="text" class="form-control"
			id="nom" name="nom" placeholder="<?php echo $nom;?>"
			<?php if($overlay) print 'value="'.$nom.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[1] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="Paiement">Date de Paiement</label> <input type="datetime"
			class="form-control" id="Paiement" name="Paiement"
			placeholder="<?php echo $paiment;?>"
			<?php if($overlay) print 'value="'.$paiment.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[2] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="adresse">Adresse</label>
		<textarea class="form-control" id="adresse" rows="3" name="adresse"
			placeholder="<?php echo $adresse;?>"
			<?php if($overlay) print 'value="'.$adresse.'"'?>></textarea>
	</div>
	<button type="submit" class="btn btn-default">Ajouter</button>
</form>