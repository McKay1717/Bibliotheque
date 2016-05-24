<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
				aria-expanded="false">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Bibliotheque</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse"
			id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			<?php
			foreach ( $catego as $row => $data ) {
				if ($row < 3) {
					if ($row == $catego_id) {
						echo "<li class=\"active\"><a href=\"index.php?catego_id=" . $row . "\">" . $data . "<span class=\"sr-only\">(current)</span></a></li>";
					} else {
						echo "<li><a href=\"index.php?catego_id=" . $row . "\">" . $data . "</a></li>";
					}
				}
			}
			?>
			</ul>
			<?php if(!isset($fiche_id)):?>
			<form class="navbar-form navbar-left" role="search" method="get" action="index.php">
			<input type="hidden" name="catego_id" value="<?php echo $catego_id;?>">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="<?php echo $search;?>"
						name="search" id="search">
				</div>
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
				</button>
			</form>
			<?php endif ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown" role="button" aria-haspopup="true"
					aria-expanded="false">Ajouter <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="add.php?catego_id=0">Ajouter un Adherent</a></li>
						<li><a href="add.php?catego_id=1">Ajouter un Auteur</a></li>
						<li><a href="add.php?catego_id=2">Ajouter une Oeuvre</a></li>
						<li><a href="add.php?catego_id=3">Ajouter un Exempalire</a></li>
						<li><a href="add.php?catego_id=4">Ajouter un Emprunt</a></li>
					</ul></li>
			</ul>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->

</nav>