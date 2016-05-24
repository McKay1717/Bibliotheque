<?php
if(!EmpruntExist($fiche_id))
{
	include 'error.php';
	die();
}
$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
$host = $_SERVER ['HTTP_HOST'];
$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
$extra = 'fiche.php?catego_id=2&fiche_id=' . GetNoOeuvreOfExemplaire ( $fiche_id ) [0];
$extraConfirm = 'delete.php?catego_id=' . $catego_id . "&fiche_id=" . $fiche_id . '&confirm=1';
if (isset ( $confirm ) && $confirm == 1) {
	deleteEmprunt ( $fiche_id );
	header ( "Location: $protocol$host$uri/$extra" );
} else {
	
	?>
<h1>Vous allez supprimer l'emprunt de</h1>
<div class="container-fluid">
	<div class="row">
	<?php
	foreach ( listAdherentByExemplaire ( $fiche_id ) as $useless => $id ) {
		print "<div class=\"col-md-4\">";
		gendAdherentCard ( $id, false );
		print "</div>";
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