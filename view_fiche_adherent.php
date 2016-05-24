<?php

if (! AdherentExist ( $fiche_id )) {
	include 'error.php';
	die ();
}
?>
<h1>Information</h1>
<?php
gendAdherentCard ( $fiche_id );
?>
<h1>
	Livre Emprunté<a href="add.php?catego_id=4"><span
		class="btn btn-success glyphicon glyphicon-plus pull-right"
		aria-hidden="true"></span></a>
</h1>
<div class="container-fluid">
	<div class="row">
	<?php
	
	foreach ( getOeuvreConcernedByAdherent ( $fiche_id ) as $useless => $data ) {
		foreach ( $data as $noOeuvre => $info ) {
			print "<div class=\"col-md-4\">";
			genEmpruntCard ( $noOeuvre, $info );
			print "</div>";
		}
	}
	
	?>
	</div>
</div>