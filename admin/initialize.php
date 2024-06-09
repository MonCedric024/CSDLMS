<?php
session_start();

define('web_root', '/CSDLMS/admin/'); 

function redirect($url) {
    header("Location: $url");
    exit();
}
?>
