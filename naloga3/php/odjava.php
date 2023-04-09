<?php
 include_once('header.php');
 session_unset();
session_destroy();
header( 'Location: http://localhost/Projektna/index.html' );

?>