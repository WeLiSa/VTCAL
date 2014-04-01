<!DOCTYPE html>
<?php
 include_once("model/typeseance.php");
 include_once("model/matiere.php");
 include_once("model/groupeEtudiant.php");
 include_once("model/enseignant.php");
 
 
 /****Les groupes d'étudiants*****/
 $groupeetudiants=array();
 $groupeetudiants[]=new groupeEtudiant("M1A");
 $groupeetudiants[]=new groupeEtudiant("M2A");
 $groupeetudiants[]=new groupeEtudiant("M2_MIAGE");
 $groupeetudiants[]=new groupeEtudiant("M1_ASR");

/***Les types de séances****/ 
 $typesseances=array();
 $typesseances[]= new typeseance("CM");
 $typesseances[]= new typeseance("TD");
 $typesseances[]= new typeseance("TP");
 $typesseances[]= new typeseance("Examen");
 $typesseances[]= new typeseance("R&eacute;union");
 
 /***Les matières******/
 $matieres=array();
 $matieres[]= new matiere("BDA");
 $matieres[]= new matiere("DLL");
 $matieres[]= new matiere("Multim&eacute;dia");
 $matieres[]= new matiere("Projet R&amp;D");
 $matieres[]= new matiere("Projet DLL");
?>
<html>
	<head>
	 <title>Bienvenue sur VTCAL</title>
	 <meta charset="utf-8" />
	 <link rel="stylesheet" type="text/css" href="css/style.css" />
	 <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
	</head>
	<body>
	<div id="top">
			<h1 id="top-titre">Bienvenue sur VTCAL</h1>
		</div>
		<form method="post" action="controller/traitement.php" >
		<div id="container">
			<div id="bloc1fieldset">
				<fieldset id="fieldset1" class="largeur312 hauteur60">
					<legend class="gras italic">Profil</legend>
					<p>S&eacute;lectionnez un profil 
						<select name="profil">
						<option>Enseignant</option>
						<option>Etudiant</option>
					    </select>
					</p>	
				</fieldset>
				<fieldset id="fieldset2" class="largeur312 hauteur60">
					<legend class="gras italic">Pi&egrave;ce jointe</legend>
					<!-- MAX_FILE_SIZE doit précéder le champ input de type file
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
					<input type="file" name="pjics" accept=".ics" required class="margeH15" id="pjics">
				</fieldset>
			</div>
			<div id="bloc2fieldset">
				<fieldset id="fieldset3">
					<legend class="gras italic">Filtrage du fichier</legend>
					<div id="datespicker">
					 <p>Date de début: <input type="text" id="datepicker1" name="datepicker1" required></p>
					 <p  class="margeG53p" style=" margin-top: -38px;">Date de fin:   <input type="text" id="datepicker2" name="datepicker2" required></p>
					</div>
					<fieldset id="fieldset4">
						<legend class="gras italic">Formations</legend>
						<?php
						foreach($groupeetudiants as $groupeetudiant){
							$nameGroupeEtudiant=$groupeetudiant->getNameGroupeEtudiant();
							echo '<input name="formation" type="checkbox" value="'.$nameGroupeEtudiant.'">'.$nameGroupeEtudiant.'<br/>';
						}
				        ?>
					</fieldset>
					<fieldset id="fieldset5">
					  <legend class="gras italic">Type de s&eacute;ance</legend>
					<?php
						foreach($typesseances as $typeseance){
							$nametypeseance=$typeseance->getNameTypeSeance();
							echo '<input name="typeseance" type="checkbox" value="'.$nametypeseance.'">'.$nametypeseance.'<br/>';
						}
				    ?>
					</fieldset>
					<fieldset id="fieldset6">
						<legend class="gras italic">Les mati&egrave;res</legend>
						<?php
						foreach($matieres as $matiere){
							$nameMatiere=$matiere->getNameMatiere();
							echo '<input name="matiere" type="checkbox" value="'.$nameMatiere.'">'.$nameMatiere.'<br/>';
						}
				        ?>
					</fieldset>
					<div id="button_submit">
						<input type="submit" name="submit1" value="exporter" class="gras" id="b_submit1">
						<input type="submit" name="submit2" value="exporter vers radicale" class="gras" id="b_submit2">
					</div>
					<?php
						//include_once("view/popUp.php");
					?>
				</fieldset>
				</div>
		</div>
		</form>
		<script type="text/javascript" src="js/jquery1_9.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
	    <script type='text/javascript' src='js/datepickerInFrench.js'></script>
		<script type='text/javascript' src='js/main.js'></script>
	</body>
</html>