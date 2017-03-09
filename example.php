<?php
	require_once("fontGoogleToLocal.php");
	$Obj = new fontGoogleToLocal;
	$Obj->setForceReplace(true); //optional
	$Obj->setLink("http://fonts.googleapis.com/css?family=Oswald");
	$Obj->getCss();
	
	$Obj->setLink("http://fonts.googleapis.com/css?family=Roboto:400,700");
	$Obj->getCss();
	
	$Obj->setLink("https://fonts.googleapis.com/css?family=Open+Sans:400,600i,800");
	$Obj->getCss();
	
?>

<link rel="stylesheet" href="file/css/Roboto.css">
<link rel="stylesheet" href="file/css/Oswald.css">
<style type="text/css">
	.arial{
		font-family: arial;
	}
	.OpenSans{
		font-family: 'Open Sans', arial;
	}
	.Roboto{
		font-family: Roboto, arial;
	}
	.Oswald{
		font-family: Oswald, arial;
	}
	.Roboto span{
		font-weight: 700;
	}
	
</style>
<div class="arial">Arial : Lorem ipsum dolor sit amet, quo id quodsi aperiam senserit, justo facer vel at. Cum ea eleifend dissentiet, <b>verear interesset ex vim.</b> <i>Convenire molestiae comprehensam per ei,</i> adipisci aliquando vis at. Sea an persius ponderum, est te unum wisi meliore.</div>
<div class="OpenSans">Open Sans : Lorem ipsum dolor sit amet, quo id quodsi aperiam senserit, justo facer vel at. Cum ea eleifend dissentiet, <b>verear interesset ex vim.</b> <i>Convenire molestiae comprehensam per ei,</i> adipisci aliquando vis at. Sea an persius ponderum, est te unum wisi meliore.</div>
<div class="Roboto">Roboto : Lorem ipsum dolor sit amet, quo id quodsi aperiam senserit, justo facer vel at. Cum ea eleifend dissentiet, <b>verear interesset ex vim.</b> <i>Convenire molestiae comprehensam per ei,</i> adipisci aliquando vis at. <span>Sea an persius ponderum, est te unum wisi meliore.</span></div>
<div class="Oswald">Oswald : Lorem ipsum dolor sit amet, quo id quodsi aperiam senserit, justo facer vel at. Cum ea eleifend dissentiet, <b>verear interesset ex vim.</b> <i>Convenire molestiae comprehensam per ei,</i> adipisci aliquando vis at. Sea an persius ponderum, est te unum wisi meliore.</div>
