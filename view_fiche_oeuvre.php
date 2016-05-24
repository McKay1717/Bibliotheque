<?php
if (! OeuvreExist ( $fiche_id )) {
	include 'error.php';
	die ();
}
?>
<h1>Information</h1>
<?php
gendOeuvreCard ( $fiche_id );
?>
<h1>
	Exemplaire en stock <a href="add.php?catego_id=3"><span
		class="btn btn-success glyphicon glyphicon-plus pull-right"
		aria-hidden="true"></span></a>
</h1>
<div class="container-fluid">
	<div class="row">
	<?php
	foreach ( listExempeplaireofOeuvre ( $fiche_id ) as $useless => $id ) {
		print "<div class=\"col-md-4\">";
		genExemplaireCard ( $id );
		print "</div>";
	}
	
	?>
	</div>
</div>