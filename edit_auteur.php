<?php
if (! AuteurExist ( $fiche_id )) {
	include 'error.php';
	die ();
}
$init = getAuteurInfo ( $fiche_id );
$nom = $init [0];
$prenom = $init [1];
$error = [ ];
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	if (strlen ( $_POST ['nom'] ) != 0)
		$nom = htmlentities ( $_POST ['nom'] );
	if (strlen ( $_POST ['prenom'] ) != 0)
		$prenom = htmlentities ( $_POST ['prenom'] );
	if (validateAuteurForm ( $nom, $prenom, $adresse ) === true) {
		$i = editAuteur ( $nom, $prenom, $fiche_id );
		$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
		$host = $_SERVER ['HTTP_HOST'];
		$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
		$extra = 'fiche.php?catego_id=' . $catego_id . "&fiche_id=" . $fiche_id;
		header ( "Location: $protocol$host$uri/$extra" );
		die ();
	} else {
		$error = validateAuteurForm ( $nom, $prenom );
	}
}
$overlay = count ( $error ) != 0;
?>
<form class="col-md-8 col-md-offset-2" method="post"
	action="edit.php<?php print '?catego_id='.$catego_id. "&fiche_id=" . $fiche_id?>">
	<div
		class="form-group <?php if($overlay) $echo =$error[0] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="nom">Nom</label> <input type="text" class="form-control"
			id="nom" name="nom" <?php print 'value="'.$nom.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[1] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="prenom">Prenom</label> <input type="text"
			class="form-control" id="prenom" name="prenom"
			<?php  print 'value="'.$prenom.'"'?>>
	</div>
	<button type="submit" class="btn btn-default">Editer</button>
</form>