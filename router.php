<?php
// Return False means show the file normally.
// 返回False代表直接返回这个文件.

$dir = __DIR__;
//Enable loading protected pages from a xml file?
$LoadPGFromAFile = false;
//XML File:
$XMLPath = $dir . "/Config.xml";
//Please use the file in this repo:
//Config.xml

//Set the pages you want to jump to.
$P_404 = "/404.html";
//Example: /var/www/404.html , just insert "/404.html".
$P_403 = "/403.html";


if(!$LoadPGFromAFile){
$ProtectedPages = array(
  "/TestPath",
  "/TestPath/",
  "/A_Important_File.xml"
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
 echo "<script>window.location.href = \"".$P_403."\"</script>;";
}else{
//404
$requestURI = $dir.$fwp;
$fstatus = file_exists(url_decode($requestURI));
if($fstatus){
return false;
}else{
 echo "<script>window.location.href = \"".$P_404."\"</script>;";
}
}
?>
