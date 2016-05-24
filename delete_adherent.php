<?php
if(!AdherentExist($fiche_id))
{
	include 'error.php';
	die();
}
$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
$host = $_SERVER ['HTTP_HOST'];
$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
$extra = 'index.php?catego_id=' . $catego_id;
$extraConfirm = 'delete.php?catego_id=' . $catego_id . "&fiche_id=" . $fiche_id . '&confirm=1';
if (isset ( $confirm ) && $confirm == 1) {
	deleteAdherent ( $fiche_id );
	header ( "Location: $protocol$host$uri/$extra" );
} else {
	
	?>
<h1 class="bg-danger">Vous allez supprimer les données suivante:</h1>
<?php
	gendAdherentCard ( $fiche_id, false );
	?>
<h1>Livre Emprunté</h1>
<div class="container-fluid">
	<div class="row">
	<?php
	
	foreach ( getOeuvreConcernedByAdherent ( $fiche_id ) as $useless => $data ) {
		foreach ( $data as $noOeuvre => $info ) {
			print "<div class=\"col-md-4\">";
			genEmpruntCard ( $noOeuvre, $info, false );
			print "</div>";
		}
	}
	
	?>
	</div>
</div>
<div class="panel-footer clearfix">
	<p class="text-right">
		<a class="btn btn-danger"
			href="<?php echo $protocol.$host.$uri.'/'.$extraConfirm?>">Confirmer</a>
		<a class="btn btn-default"
			href="<?php echo $protocol.$host.$uri.'/'.$extra?>">Annuler</a>
	</p>
</div>
<?php }?>