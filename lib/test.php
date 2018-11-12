<?php	
	header('content-type:image/png');
    //$root =  $_SERVER['DOCUMENT_ROOT'];
    $img = "./4376.png";
    $str = file_get_contents($img);
    echo $str;