<?php
//Creator: XIAYM
$dir = __DIR__;

//Enable to print the error page directly?
//HTML FILE ONLY or you will print your php codes on the page.
$PrintPageDirectly = false;
//Enable loading protected pages from a xml file?
$LoadPGFromAFile = false;
//XML File:
$XMLPath = $dir . "/Config.xml";
//Please use the file in this repo: Config.xml

//Set the page you want to jump to.
$P_404 = "/404.html";
//Example: /var/www/404.html , just insert "/404.html".
$P_403 = "/403.html";


if(!$LoadPGFromAFile){
$ProtectedPages = array(
  "/TestPath",
  "/TestPath/",
  "/An_Important_File.xml"
  );
}else{
  //Get From XML File
  $xmlsource = simplexml_load_file($XMLPath);
  $xml= json_encode($xmlsource);
  $xml=json_decode($xml,true);
  $ProtectedPages = $xml["ProtectedList"]["Item"];
}

//403
$fwp = $_SERVER["PHP_SELF"];
if(in_array($fwp,$ProtectedPages)){
  if(!$PrintPageDirectly){
 header("Location: $P_403");
  }else{
    echo file_get_contents($P_403);
  }
}else{
//404
$requestURI = $dir.$fwp;
$fstatus = file_exists(url_decode($requestURI));
if($fstatus){
return false;
}else{
  if(!$PrintPageDirectly){
 header("Location: $P_404");
  }else{
    echo file_get_contents($P_404);
  }
}
}
?>
