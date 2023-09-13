<?php
session_start();
$_SESSION['user']['email'] = null;
session_destroy();
header("http://localhost:3000/");
exit();
