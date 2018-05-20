<?php
$fileName = $_REQUEST["fileName"];
//
$fullPath = "./upload/".$fileName;
//upload/users/xx@xx.xx/userpic
unlink($fullPath);
?>
