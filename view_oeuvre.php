<?php
if (strlen ( $search ) != 0) {
	$idlist = searchInOeuvre ( $search );
} else {
	$idlist = getAllnoOeuvre ();
}
?>
<div class="container-fluid">
	<div class="row">
	<?php
	foreach ( $idlist as $useless => $id ) {
		print "<div class=\"col-md-4\">";
		gendOeuvreCard ( $id );
		print "</div>";
	}
	
	?>
	</div>
</div>