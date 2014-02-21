<?php
 
   include_once("Google_Spreadsheet.php");

   $user = 'USER';			//need to create dummy acct
   $pass = 'PASSWD';						

   $ss = new Google_Spreadsheet($user, $pass);
   $ss->useWorksheet("Sheet1");						//need to set these to match spreadsheet
   $ss->useSpreadsheet("Newsletter Subscription");





$email = $_POST['email'];
$timestmp = date('l jS \of F Y h:i:s A');






$rowData = array
(
	  "timestamp" => $timestmp
    , "email" => $email

);

if ($ss->addRow($rowData)) {
            // Display success page here

    echo "Thanks for subscribing to thenewsletter!";

} else {
            // Failed to write to the spreadsheet
    echo "Sorry there was an error processing your request.";
}

 

 
?>	
