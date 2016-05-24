<?php
if(!OeuvreExist($fiche_id))
{
	include 'error.php';
	die();
}
$init = getOeuvreInfo ( $fiche_id );
$titre = $init [1];
$date = $init [2];
$id = $init [0];
$error = [ ];
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	if (strlen ( $_POST ['titre'] ) != 0)
		$titre = htmlentities ( $_POST ['titre'] );
	if (strlen ( $_POST ['date'] ) != 0)
		$date = htmlentities ( $_POST ['date'] );
	if (strlen ( $_POST ['id'] ) != 0)
		$id = intval ( htmlentities ( $_POST ['id'] ) );
	
	if (validateOeuvreForm ( $titre, $date, $id ) === true) {
		$i = editOeuvre ( $titre, $date, $id, $fiche_id );
		$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
		$host = $_SERVER ['HTTP_HOST'];
		$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
		$extra = 'fiche.php?catego_id=' . $catego_id . "&fiche_id=" . $fiche_id;
		header ( "Location: $protocol$host$uri/$extra" );
		die ();
	} else {
		$error = validateOeuvreForm ( $titre, $date, $id );
	}
}

$overlay = count ( $error ) != 0;
?>
<form class="col-md-8 col-md-offset-2" method="post"
	action="edit.php<?php print '?catego_id='.$catego_id. "&fiche_id=" . $fiche_id?>">
	<div
		class="form-group <?php if($overlay) $echo =$error[0] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="titre">Titre</label> <input type="text"
			class="form-control" id="titre" name="titre"
			<?php print 'value="'.$titre.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[1] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="date">Date de parution</label> <input type="datetime"
			class="form-control" id="date" name="date"
			<?php  print 'value="'.$date.'"'?>>
	</div>

	<div
		class="form-group <?php if($overlay) $echo = $error[2] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="id">Auteur</label> <select id="id" name="id"
			class="form-control">
			<option value="-1">Saisir un nouvelle auteur</option>
		<?php
		foreach ( getAllidAuteur () as $useless => $idAuteur ) {
			if ($id == $idAuteur)
				$tmp = "selected";
			print '<option value="' . $idAuteur . '"' . $tmp . '>' . getAuteurName ( $idAuteur ) . '</option>';
			unset ( $tmp );
			
		}
		?>
		</select>
	</div>
	<button type="submit" class="btn btn-default">Editer</button>
</form>