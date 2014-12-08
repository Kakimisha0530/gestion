<?php
require_once 'classes/SQLObject.php';
require_once 'classes/Article.php';
require_once 'classes/Pays.php';

$session = openSession ();

$id = getFormVariable("id");

if(getFormVariable("ajout") == 1){
	$article = new Article();
	$nom = getFormVariable("ajout_nom");
	$prix = getFormVariable("ajout_prix");
	$qte = getFormVariable("ajout_qte");
	$type = getFormVariable("ajout_type");
	$type = Article::$TYPES[intval($type)];
	$tva = getFormVariable("ajout_tva");
	$tva = Article::$TVA[intval($tva)];
	$pays = getFormVariable("ajout_pays");
	$article->set($session, 0 , $nom, $prix, $qte, $tva, $type, $pays);
	if($article->save($session))
		$confirm = "<span class=\"success\">L'article a bien été ajouté !!</span>";
	else
	    $confirm = "<span class=\"erreur\">Une erreur est survenue lors de l'ajout de l'article</span>";
	
}
else if($id != null && intval($id) > 0){
	$article = new Article();
	$article->getById($session, $id);
	//echo "<br>id : " + $article->id;
	$qte = getFormVariable("qte");
	$article->qte = $qte;
	if($article->save($session))
	    $confirm = "<span class=\"success\">L'article a bien été modifié !!</span>";
	else
	    $confirm = "<span class=\"erreur\">Une erreur est survenue lors de la modification de l'article</span>";
	
}

$pays = new Pays();
$article = new Article();
$tab1 = $pays->getAll ( $session );
$tab2 = $article->getAll ( $session );
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gestion des Stocks</title>
<meta name="description" content="">
<meta http-equiv="Content-Language" content="fr">
<meta name="author" content="Licence TEC" lang="fr">
<link rel="stylesheet" type="text/css" media="screen"
	href="./css/style.css">
<link rel="stylesheet" type="text/css" media="screen"
	href="./css/visualisation.css">
<style type="text/css">
#confirm{
width: auto;
float: left;
margin-left: 100px;
padding-left: 10px;
padding-right: 10px;
clear: both;
}
</style>
<script src="./js/injection_graph_func.js"></script>
<script type="text/javascript">

function verification(event){
	var elt1 = document.getElementById("ajout_nom");
	var elt2 = document.getElementById("ajout_prix");
	var elt3 = document.getElementById("ajout_qte");
    if(elt1.value == "" || elt2.value == "" || elt3.value == ""){
    	document.getElementById("erreur0").style.display = "block";
        event.preventDefault();
    }
    else{
    	var form = document.forms["ajout_article"];
    	form.submit();
    }
}

function modification(btn){
	var id = btn.id.split("_")[1];
	//alert(btn.id);
	var form = document.forms["modif_article"];
	if(form.elements["id"].value == undefined || form.elements["id"].value == ""){
		btn.value = "Valider";
		form.elements["id"].value = id;
		document.getElementById("inputQte_" + id).style.display = "block";
    	document.getElementById("txtQte_" + id).style.display = "none";
    }
	else if (form.elements["id"].value == id){
		var qte = document.getElementById("inputQte_" + form.elements["id"].value);
		if(qte.value == ""){
	    	document.getElementById("erreur1").style.display = "block";
	        event.preventDefault();
	    }
		else{
			form.elements["qte"].value = qte.value;
			//alert(qte.value);
			form.submit();
		}
	}
}

</script>
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
				<?php 
					if($confirm)
						print ("<div id='confirm'><h4>$confirm</h4></div>");
					?>
				<h2 class="titre">Modifier un produit</h2>
				<div id="tab_autre">
					<p id="erreur1" style="display: none;">
					    <span class="erreur">Tous les champs sont obligatoires</span>
					</p>
					<p> </p>
					<form
						action="#"
						method="post" name="modif_article" id="modif_article">
						<input type="hidden" name="id" id="id">
						<input type="hidden" name="qte" id="qte">
						</form>
						<table cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<th scope="col">Nom</th>
									<th scope="col">Prix</th>
									<th scope="col">Quantité</th>
									<th scope="col">Type</th>
									<th scope="col">TVA</th>
									<th scope="col">Action</th>
								</tr>
								<?php
    							while ( $row = mysqli_fetch_array ( $tab2 ) ) {
    								$article->setFromDB ( $session, $row );
    								print ("<tr>") ;
    								print ("<td>" . stripslashes($article->nom) . "</td>") ;
    								print ("<td>" . $article->prix . "</td>") ;
    								print ("<td>" );
    								print ("<span id=\"txtQte_" . $article->id . "\">" . $article->qte . "</span>");
    								print ("<input size=5 style='display:none;' id=\"inputQte_" . $article->id . "\" value=\"" . $article->qte . "\">");
    								print ("</td>") ;
    								print ("<td>" . $article->type . "</td>") ;
    								print ("<td>" . $article->tva . "</td>") ;
    								print ("<td>");
    								print ("<input type=\"button\" value=\"Modifier\" onclick=\"modification(this);\" id=\"btn_" . $article->id . "\">");
    								print ("</td>") ;
    								print ("</tr>") ;
    							}
    							mysqli_free_result($tab);
    							?>
							</tbody>
						</table>
						<div class="space"></div>
				</div>
				<h2 class="titre">Ajouter un produit</h2>
				<div id="tab_autre">
					<p id="erreur0" style="display: none;"><span class="erreur">Tous les champs sont obligatoires</span></p>
					<p> </p>
					<form
						action="#"
						method="post" name="ajout_article" id="ajout_article">
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
									<td><input size="15" name="ajout_nom" id="ajout_nom" type="text"></td>
									<td><input size="5" name="ajout_prix" id="ajout_prix" type="text"></td>
									<td><input size="5" name="ajout_qte" id="ajout_qte" type="text"></td>
									<td><select name="ajout_type">
											<?php
											foreach (Article::$TYPES as $key => $val)
												print ("<option value=\"$key\">$val</option>") ;
											?>
									</select></td>
									<td><select name="ajout_tva">
									<?php
											foreach (Article::$TVA as $key => $val)
												print ("<option value=\"$key\">$val</option>") ;
											?>
									</select></td>
									<td>
									<select style="width: 120px;" name="ajout_pays">
											<?php
											while ( $row = mysqli_fetch_array ( $tab1 ) ) {
												$pays->setFromDB ( $session, $row );
												print ("<option value=\"" . $pays->id . "\">" . $pays->nom . "</option>") ;
											}
											mysqli_free_result($tab);
											?>
									</select>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="centre">
						<p> </p>
							<input class="envoyer" value="enregistrer" name="ok_autre"
								type="button" onclick="verification();">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
closeSession($session);
?>