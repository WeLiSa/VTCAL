
<?php
require_once "../model/iCalcreator/iCalcreator.class.php";

 if(isset($_REQUEST['submit2']) && isset($_REQUEST['profil']) && isset($_REQUEST['pjics']) && isset($_REQUEST['datepicker1']) && isset($_REQUEST['datepicker2'])){
	
	 
	 if(!empty($_REQUEST['datepicker1']) && !empty($_REQUEST['datepicker2'])){
	 $name_file=$_REQUEST['pjics'];
	 $name_profil=$_REQUEST['profil'];
	 $datedebut=$_REQUEST['datepicker1'];
	 $datefin=$_REQUEST['datepicker2'];
	 $v=filtrageFile($name_file,$datedebut,$datefin); 
	 envoieVersCalDAV($v,$name_profil);
	 recapulatifSucess($name_profil,$datedebut,$datefin);
	 }
	 else errorDateEmpty();
}
else if(isset($_REQUEST['submit1'])&& isset($_REQUEST['pjics']) && isset($_REQUEST['datepicker1']) && isset($_REQUEST['datepicker2'])){

	 if(!empty($_REQUEST['datepicker1']) && !empty($_REQUEST['datepicker2'])){
	$name_file=$_REQUEST['pjics'];
	$datedebut=$_REQUEST['datepicker1'];
	$datefin=$_REQUEST['datepicker2'];

    $v=filtrageFile($name_file,$datedebut,$datefin);
	exporterFile($v);
	}
	else errorDateEmpty();
} 
 
 
 
 
 /***Redirect to the page on error***/
 function errorDateEmpty(){
	echo"<script>alert('Les dates ne sont pas toutes saisies!')</script>";
	echo'<script>document.location.href="../index.php";</script>';
	exit();
 }
 /***Function that displays that sending has had success***/
 function recapulatifSucess($name_profil,$datedebut,$datefin){
    echo"<script>alert('Le calendrier a été envoyé avec succés ')</script>";
	echo'<script>document.location.href="../index.php";</script>';
	exit();
 }
 
 /****Function that sends to the caldav server***/
 function envoieVersCalDAV($v,$name_profil){

   $directory="file:///C:/radicale/radicale/collections/".$name_profil;
   $filename_save=$v->getConfig();
   $filename_save=$filename_save['FILENAME'];
   $delimite=False;

   /**Function to save the file**/
   $v->saveCalendar($directory,$filename_save,$delimite);
 }

/***Check the file extension***/
  function isCalendar($chemin){

	 $extension=pathinfo($chemin,PATHINFO_EXTENSION);
	 return($extension=='ics');
  }
  
  /**Function to export a file filter*/
  function exporterFile($v){
	
	$v->returnCalendar();
  }
  
  /**Function to remove event components**/
  function deleteComposantsEvent($v,$uids,$unique_id){
 
	foreach($uids as $uid){
		
		$v->deleteComponent($uid);
	}
	
	//rename the file
	$rename=$unique_id.'.ics';
	$v->setConfig("filename",$rename);
	
    return $v;
  }
  
  /**Fontion to retrieve the existing configuration**/
  function recupereConfigFichierExistant($name_file){
	$calendrier = file_get_contents('../calendar/'.$name_file.'', FILE_USE_INCLUDE_PATH);
	//expression
	$regExpVersion="‘VERSION:(.*)‘";
	$regExpProdid="‘PRODID:(.*)‘";
	$regExpMethod="‘METHOD:(.*)‘";
	$regExpCalname ="‘X-WR-CALNAME:(.*)‘";
	
	//preg_match_all
	$nversion = preg_match_all($regExpVersion,$calendrier,$matchVersion,PREG_PATTERN_ORDER);
	$nprodid = preg_match_all($regExpProdid,$calendrier,$matchProdid,PREG_PATTERN_ORDER);
	//$nmethod = preg_match_all($regExpMethod,$calendrier,$matchMethod,PREG_PATTERN_ORDER);
	$ncalname = preg_match_all($regExpCalname,$calendrier,$matchCalname,PREG_PATTERN_ORDER);

	$version=$matchVersion[1][0];
	$prodid=$matchProdid[1][0];
	$calname=$matchCalname[1][0];

	//creating a configuration table
	$tableauCongig=array();
	$tableauConfig['version']=$version;
	$tableauConfig['prodid']=$prodid;
	$tableauConfig['calname']=$calname;
	
	return $tableauConfig;
  }
  
  
  /*Filtering a file based on dates */
  function filtrageFile($name_file,$datedebut,$datefin){
	
	//Gestion de la date
	$datedebutfr=$_REQUEST['datepicker1'];
	$datefinfr=$_REQUEST['datepicker2'];
	
	$datedebuteng=convertDate($datedebutfr);
	$datefineng=convertDate($datefinfr);
	
	$datedebut=supprimerSlashe($datedebuteng);
	$datefin=supprimerSlashe($datefineng);

	//Recovering the configuration database file
	$tableauConfig=recupereConfigFichierExistant($name_file);
	
	//Initializing a calendar object
	$rename=explode(".ics",$name_file);
	$unique_id=$rename[0].'-'.$datedebut.'-'.$datefin;
	$config = array( "directory" => "../calendar", "filename" =>$name_file,
					 "unique_id" =>$unique_id
					 );
  
	$v = new vcalendar($config);			 
    $v->setProperty("version",$tableauConfig['version']);
	$v->setProperty("prodid",$tableauConfig['prodid']);
	$v->setProperty("x-wr-calname",$tableauConfig['calname']);
	
    $v->parse();
	
	//Filtering File
	$uids=array();
    while($vevent = $v->getComponent("vevent")) {
		
	  $uid = $vevent->getProperty("uid");
  
	  $dtstart = $vevent->getProperty("dtstart");
      $datedebutoccurrence=ajoutZero($dtstart['year']).ajoutZero($dtstart['month']).ajoutZero($dtstart['day']);
	  
	  $dtend = $vevent->getProperty("dtend");
	  $datefinoccurrence=ajoutZero($dtend['year']).ajoutZero($dtend['month']).ajoutZero($dtend['day']);
	
	  $resultatdatedebut=compareDate($datedebutoccurrence,$datedebut);
	  $resultatdatefin=compareDate($datefinoccurrence,$datefin);


	  //if(($resultatdatedebut==(string)"egal" || $resultatdatedebut==(string)"moins") && ($resultatdatefin==(string)"egal" || $resultatdatefin==(string)"plus")){
	  if($resultatdatedebut==(string)"plus" || $resultatdatefin==(string)"moins"){
		 $uids[]=$uid;
	   }
	   
    }

	$v=deleteComposantsEvent($v,$uids,$unique_id);
	
	return $v;
  }
  
  /**Function to convert a date French English**/
  function convertDate($date){
     $tabDate = explode('/' , $date);
     $enDate  = $tabDate[2].'/'.$tabDate[1].'/'.$tabDate[0];
     return $enDate;
  }
  
  /**Fontion to remove slashes**/
  function supprimerSlashe($date){
	return str_replace("/","",$date);
  }
  
/** Function :compare two dates **/
  function compareDate($dateoccurrence,$date){
	
     //formats dates in the format Ymd
    $dateoccurrence = new DateTime($dateoccurrence);
    $dateoccurrence = $dateoccurrence->format("Ymd");
    $date = new DateTime($date);
    $date = $date->format("Ymd");
	
	$resultat="";
 
    // and the two dates are compare
    if($dateoccurrence < $date){
        $resultat="plus";
	}
	
	else if($dateoccurrence > $date){
        $resultat="moins";
	}
	
	else if($dateoccurrence  == $date){
        $resultat="egal";
	}
	
	return $resultat;
  }

  /** Function to add a zero to an integer **/
  function ajoutZero($element){
	if($element<10){
	  $zero=0;
	  $element=$zero.$element;
	}
    
	return $element;
  }

 ?>
 