<?php

$Email = $_POST['email'];

exec("java -jar subscribeofficial.jar " . $Email, $success);
print_r($success);
?>
