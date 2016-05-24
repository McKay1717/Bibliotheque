<?php 
if (! AuteurExist ( $fiche_id )) {
	include 'error.php';
	die ();
}?>
<h1>Information</h1>
<?php
genAuteurCard( $fiche_id );
?>
<h1>Livre Ecrit:</h1>
<div class="container-fluid">
	<div class="row">
	<?php
	foreach ( getOeuvreByAuteur ( $fiche_id ) as $useless => $id ) {
		print "<div class=\"col-md-4\">";
		gendOeuvreCard ( $id, false );
		print "</div>";
	}
	
	?>
	</div>
</div>