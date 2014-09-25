<?php
/*
Template Name: Partner UTM Builder
 */
?>
<!DOCTYPE html>

<head>
    <link href='http://fonts.googleapis.com/css?family=Gudea:400,700,400italic|Oswald:400,700|Montserrat:400,700|Noto+Serif:400,700'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="http://nationswell.com/wp-content/themes/nationswell/partner-utm/partnercodes.css">
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="http://nationswell.com/wp-content/themes/nationswell/partner-utm/partnercodes.js"></script>
</head>


<body>

<h1>NationSwell Partner Link Constructor</h1>

<div id="input">
    Enter story URL:<br>
    <input type="textbox" id="inputurl"></input>
</div>
<div id="buttonrow">Select partner:<br>
    <div id="mic">Mic</div>
    <div id="takepart">TakePart</div>
</div>
<div id="outputrow">
    Your URL:<br>
    <input type="textbox" id="outputurl" onclick="this.select();"></input>
</div>
</body>
