<?php
require_once 'classes/SQLObject.php';
require_once 'classes/Article.php';
require_once 'classes/Pays.php';

$session = openSession ();

$article = new Article ();
$tab = $article->getAll ( $session );
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
						Accueil </a> &gt; Visualisation des articles
				</span>
				<h2 class="titre">&nbsp;</h2>
				<div id="tab_autre">
					<table class="tab_infos_visu" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<th scope="col">Nom</th>
								<th scope="col">Quantité</th>
								<th scope="col">Prix</th>
								<th scope="col">Type</th>
								<th scope="col">TVA</th>
							</tr>
							<?php
							
							while ( $row = mysqli_fetch_array ( $tab ) ) {
								$article->setFromDB ( $session, $row );
								print ("<tr>") ;
								print ("<td>" . $article->nom . "</td>") ;
								print ("<td>" . $article->qte . "</td>") ;
								print ("<td>" . $article->prix . "</td>") ;
								print ("<td>" . $article->type . "</td>") ;
								print ("<td>" . $article->tva . "</td>") ;
								print ("</tr>") ;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>