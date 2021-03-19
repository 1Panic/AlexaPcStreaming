<?php

$config = include 'config.php';

Header( "HTTP/1.1 301 Moved Permanently" ); 
header("location: http://" . $config['streamIP'] . "/stream/swyh.mp3"); 

?>