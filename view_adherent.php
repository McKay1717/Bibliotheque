<?php
if (strlen ( $search ) != 0) {
	$idlist = searchInAdherent ( $search );
} else {
	$idlist = getAllidAdherent ();
}
?>
<div class="container-fluid">
	<div class="row">
	<?php
	foreach ( $idlist as $useless => $id ) {
		print "<div class=\"col-md-4\">";
		gendAdherentCard ( $id );
		print "</div>";
	}
	
	?>
	</div>
</div>