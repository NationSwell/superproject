<?php
 
$email = _POST['Email'];

$listId = "8eaa257d1b";
$apikey = "99983ece6b5ad94f7c4f026238381f4d-us6"; 
$double_optin=false;
$update_existing=false;
$send_welcome=false;
$email_type = 'html';            
$data = array(
        'email'=>$email,
        'apikey'=>$apikey,
        'id' => $listId,
        'double_optin' => $double_optin,
        'update_existing' => $update_existing,
        'send_welcome' => $send_welcome,
        'email_type' => $email_type
    );
$payload = json_encode($data);
 

$submit_url = "http://us6.api.mailchimp.com/2.0/?method=subscribe";
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $submit_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
 
$result = curl_exec($ch);
curl_close ($ch);
$data = json_decode($result);
if ($data->error){
    echo $data->code .' : '.$data->error."\n";
} else {
    echo "Thank you for subscribing to our newsletter!\n";
}
?> 
