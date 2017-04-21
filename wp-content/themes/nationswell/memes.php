<?php
/*
Template Name: mememaker
 */
?>

<!DOCTYPE html>
<meta charset="utf-8">
<title>NS Meme Maker</title>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tabletop.js/1.1.0/tabletop.min.js"></script>

<style type="text/css">
    body {
        margin:0px;
    }
    #meme-embed {
        display:inline-block;
        min-width:100%;
        min-height:100%;
    }

</style>

<body>
<iframe id="meme-embed" src="http://nsmemes.herokuapp.com/" width="100%" height="100%" frameborder="0" scrolling="no">
</iframe>

</body>