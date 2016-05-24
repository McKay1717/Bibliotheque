<?php
$titre = "";
$date = "2017-02-14";
$id = - 1;
$error = [ ];
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
	if (strlen ( $_POST ['titre'] ) != 0)
		$titre = htmlentities ( $_POST ['titre'] );
	if (strlen ( $_POST ['date'] ) != 0)
		$date = htmlentities ( $_POST ['date'] );
	if (strlen ( $_POST ['id'] ) != 0)
		$id = intval ( htmlentities ( $_POST ['id'] ) );
	
	if (validateOeuvreForm ( $titre, $date, $id ) === true) {
		if ($id == - 1) {
			$_SESSION ["titre"] = $titre;
			$_SESSION ["date"] = $date;
			$_SESSION ["CreateAuteur"] = true;
			$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
			$host = $_SERVER ['HTTP_HOST'];
			$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
			$extra = 'add.php?catego_id=1';
			header ( "Location: $protocol$host$uri/$extra" );
			die ();
		}
		$i = addOeuvre ( $titre, $date, $id );
		if ($_SESSION ["CreateOeuvre"]) {
			$_SESSION ["noOeuvre"] = $i;
			$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
			$host = $_SERVER ['HTTP_HOST'];
			$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
			$extra = 'add.php?catego_id=3';
			header ( "Location: $protocol$host$uri/$extra" );
			die ();
		}
		if ($_SESSION ["EditOeuvre"]) {
			$_SESSION ["noOeuvre"] = $i;
			$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
			$host = $_SERVER ['HTTP_HOST'];
			$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
			$extra = 'edit.php?catego_id=3&fiche_id='.$_SESSION ['noExemplaire'] ;
			header ( "Location: $protocol$host$uri/$extra" );
			die ();
		}
		$protocol = stripos ( $_SERVER ['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
		$host = $_SERVER ['HTTP_HOST'];
		$uri = rtrim ( dirname ( $_SERVER ['PHP_SELF'] ), '/\\' );
		$extra = 'index.php?catego_id=2';
		header ( "Location: $protocol$host$uri/$extra" );
		die ();
	} else {
		$error = validateOeuvreForm ( $titre, $date, $id );
	}
} else if (count ( $_SESSION ) != 0) {
	
	if ($_SESSION ["CreateAuteur"]) {
		$titre = $_SESSION ["titre"];
		$date = $_SESSION ["date"];
		$id = $_SESSION ["id"];
		unset ( $_SESSION ["CreateAuteur"] );
		
		$error = [ 
				false,
				false,
				false 
		];
	}
	if (isset ( $_SESSION ["CreateOeuvre"], $_SESSION ["CreateAuteur"], $_SESSION ["CreateAdherent"], $_SESSION ["CreateExemplaire"],$_SESSION ["EditOeuvre"]  )){
		session_unset ();
	}
}
$overlay = count ( $error ) != 0;
?>
<form class="col-md-8 col-md-offset-2" method="post"
	action="add.php<?php print '?catego_id='.$catego_id?>">
	<div
		class="form-group <?php if($overlay) $echo =$error[0] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="titre">Titre</label> <input type="text"
			class="form-control" id="titre" name="titre"
			placeholder="<?php echo $titre;?>"
			<?php if($overlay) print 'value="'.$titre.'"'?>>
	</div>
	<div
		class="form-group <?php if($overlay) $echo = $error[1] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="date">Date de parution</label> <input type="datetime"
			class="form-control" id="date" name="date"
			placeholder="<?php echo $date;?>"
			<?php if($overlay) print 'value="'.$date.'"'?>>
	</div>

	<div
		class="form-group <?php if($overlay) $echo = $error[2] == true ? 'has-error' : 'has-success'; echo $echo;?>">
		<label for="id">Auteur</label> <select id="id" name="id"
			class="form-control">
			<option value="-1">Saisir un nouvelle auteur</option>
		<?php
		foreach ( getAllidAuteur () as $useless => $idAuteur ) {
			if ($id == $idAuteur)
				$tmp = "selected";
			print '<option value="' . $idAuteur . '"' . $tmp . '>' . getAuteurName ( $idAuteur ) . '</option>';
			unset ( $tmp );
		}
		?>
		</select>
	</div>
	<button type="submit" class="btn btn-default">Ajouter</button>
</form>