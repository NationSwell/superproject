<?php
 
 $Email = $_POST[email]
 $timestmp = date('l jS \of F Y h:i:s A');
// Zend library include path
set_include_path(get_include_path() . PATH_SEPARATOR . "$_SERVER[DOCUMENT_ROOT]/ZendGdata-2.2.5/library");
     
include_once("Google_Spreadsheet.php");
 
$u = "username@gmail.com";
$p = "password";
 
$ss = new Google_Spreadsheet($u,$p);
$ss->useSpreadsheet("Newsletter Signup");
 
// if not setting worksheet, "Sheet1" is assumed
// $ss->useWorksheet("worksheetName");
 
$row = array
(
    "date" => $timestmp
    , "email" => $Email
);
 
if ($ss->addRow($row)) echo "You are now subscribed to the Newsletter!";
else echo "Error, unable to add you to the newsletter subscriptions.";
 
?>
