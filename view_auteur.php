<?php
if (strlen ( $search ) != 0) {
	$idlist = searchInAuteur ( $search );
} else {
	$idlist = getAllidAuteur ();
}
?>
<div class="container-fluid">
	<div class="row">
	<?php
	foreach ( $idlist as $useless => $id ) {
		print "<div class=\"col-md-4\">";
		genAuteurCard ( $id );
		print "</div>";
	}
	
	?>
	</div>
</div>