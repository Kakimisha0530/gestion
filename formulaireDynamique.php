<?php
require_once 'classes/SQLObject.php';
require_once 'classes/Article.php';
require_once 'classes/Pays.php';

$session = openSession ();

$pays = new Article ();
$tab = $pays->getAll ( $session );
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Gestion des Stocks</title>
<meta name="description" content="">
<meta http-equiv="Content-Language" content="fr">
<meta name="author" content="Licence TEC" lang="fr">
<link rel="stylesheet" type="text/css" media="screen"
	href="./css/style.css">
<link rel="stylesheet" type="text/css" media="screen"
	href="./css/visualisation.css">
<script charset="utf-8" id="injection_graph_func"
	src="./js/injection_graph_func.js"></script>
</head>
<body>
	<div id="gestion_content">
		<div id="englobe">
			<div id="banniere">
				<img src="./img/banniere.jpg" alt="banniere gestion pro">
			</div>
			<div id="contenu">
				<span id="retour"> <a
					href="http://klankasskrane.fr/verdot/gestion/page_type.php">
						Accueil </a> &gt; Entrées des stocks
				</span>
				<h2 class="titre">Les autres Produits</h2>
				<div id="tab_autre">
					<span class="erreur">Tous les champs sont obligatoires</span>
					<form
						action="#"
						method="post">
						<input type="hidden" value="1" name="ajout">
						<table cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<th scope="col">Nom</th>
									<th scope="col">Prix</th>
									<th scope="col">Quantité</th>
									<th scope="col">Type</th>
									<th scope="col">TVA</th>
									<th scope="col">Pays</th>
								</tr>
								<tr>
									<td><input size="15" name="nom20" type="text"></td>
									<td><input size="5" name="prix20" type="text"></td>
									<td><input size="5" name="qt20" type="text"></td>
									<td><select name="type20">
											<option value="vin">vin</option>
											<option value="vin_frais">vin frais</option>
											<option value="spiritueux">spiritueux</option>
											<option value="epice">épices</option>
									</select></td>
									<td><select name="tva20">
											<option value="2.3">2.3</option>
											<option value="5.5">5.5</option>
											<option value="12.6">12.6</option>
									</select></td>
									<td><select style="width: 120px;" name="pays20">
											<?php
											
											while ( $row = mysqli_fetch_array ( $tab ) ) {
												$pays->setFromDB ( $session, $row );
												print ("<option value\"" . $pays->id . "\">" . $pays->nom . "</option>") ;
											}
											?>
									</select></td>
								</tr>
							</tbody>
							<input name="nbre_cache" value="1" type="hidden">
							<tbody>
								<tr>
									<td></td>
								</tr>
							</tbody>
						</table>
						<div class="centre">
							<input class="envoyer" value="enregistrer" name="ok_autre"
								type="submit">
						</div>
					</form>
				</div>
				<h2 class="titre">Ajouter un produit</h2>
				<div id="tab_autre">
					<span class="erreur">Tous les champs sont obligatoires</span>
					<form
						action="#"
						method="post">
						<input type="hidden" value="1" name="ajout">
						<table cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<th scope="col">Nom</th>
									<th scope="col">Prix</th>
									<th scope="col">Quantité</th>
									<th scope="col">Type</th>
									<th scope="col">TVA</th>
									<th scope="col">Pays</th>
								</tr>
								<tr>
									<td><input size="15" name="nom20" type="text"></td>
									<td><input size="5" name="prix20" type="text"></td>
									<td><input size="5" name="qt20" type="text"></td>
									<td><select name="type20">
											<option value="vin">vin</option>
											<option value="vin_frais">vin frais</option>
											<option value="spiritueux">spiritueux</option>
											<option value="epice">épices</option>
									</select></td>
									<td><select name="tva20">
											<option value="2.3">2.3</option>
											<option value="5.5">5.5</option>
											<option value="12.6">12.6</option>
									</select></td>
									<td><select style="width: 120px;" name="pays20">
											<?php
											
											while ( $row = mysqli_fetch_array ( $tab ) ) {
												$pays->setFromDB ( $session, $row );
												print ("<option value\"" . $pays->id . "\">" . $pays->nom . "</option>") ;
											}
											?>
									</select></td>
								</tr>
							</tbody>
							<input name="nbre_cache" value="1" type="hidden">
							<tbody>
								<tr>
									<td></td>
								</tr>
							</tbody>
						</table>
						<div class="centre">
							<input class="envoyer" value="enregistrer" name="ok_autre"
								type="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>