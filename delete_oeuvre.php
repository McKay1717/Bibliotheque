<?php
if(!OeuvreExist($fiche_id))
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
	deleteOeuvre ( $fiche_id );
	header ( "Location: $protocol$host$uri/$extra" );
} else {
	
	?>
<h1 class="bg-danger">Vous allez supprimer les donn��es suivante:</h1>
<?php
	gendOeuvreCard ( $fiche_id, false, null, false );
	?>
<h1>Exemplaire en stock</h1>
<div class="container-fluid">
	<div class="row">
	<?php
	foreach ( listExempeplaireofOeuvre ( $fiche_id ) as $useless => $id ) {
		print "<div class=\"col-md-4\">";
		genExemplaireCard ( $id, false );
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