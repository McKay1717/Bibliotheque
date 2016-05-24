<?php
if(!AdherentExist($fiche_id))
{
	include 'error.php';
	die();
}
$init = getAdherentInfo ( $fiche_id );
$nom = $init [0];
$paiment = $init [1];
$adresse = $init [2];
$error = [ ];
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	if (strlen ( $_POST ['nom'] ) != 0)
		$nom = htmlentities ( $_POST ['nom'] );
	if (strlen ( $_POST ['Paiement'] ) != 0)
		$paiment = htmlentities ( $_POST ['Paiement'] );
	if (strlen ( $_POST ['adresse'] ) != 0)
		$adresse = htmlentities ( $_POST ['adresse'] );
	if (validateAdherentForm ( $nom, $paiment, $adresse ) === true) {
		editAdherent ( $nom, $paiment, $adresse, $fiche_id );
		$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
		$host = $_SERVER ['HTTP_HOST'];
		$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
		$extra = 'fiche.php?catego_id=' . $catego_id . "&fiche_id=" . $fiche_id;
		header ( "Location: $protocol$host$uri/$extra" );
		die ();
	} else {
		$error = validateAdherentForm ( $nom, $paiment, $adresse );
	}
}
$overlay = count ( $error ) != 0;
?>
<form class="col-md-8 col-md-offset-2" method="post"
	action="edit.php<?php print '?catego_id='.$catego_id. "&fiche_id=" . $fiche_id?>">
	<div
		class="form-group <?php if($overlay) $echo =$error[0] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="nom">Nom</label> <input type="text" class="form-control"
			id="nom" name="nom" <?php  print 'value="'.$nom.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[1] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="Paiement">Date de Paiement</label> <input type="datetime"
			class="form-control" id="Paiement" name="Paiement"
			<?php print 'value="'.$paiment.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[2] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="adresse">Adresse</label>
		<textarea class="form-control" id="adresse" rows="3" name="adresse"
			<?php  print 'value="'.$adresse.'"'?>></textarea>
	</div>
	<button type="submit" class="btn btn-default">Editer</button>
</form>