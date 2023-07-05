<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
 
if (! session_start()) {
    die('can not start session');
} else {
    echo '<pre>session start: ok' . PHP_EOL;
}
 
echo 'session_id(): ';
var_dump(session_id());
 
echo '$_COOKIE["PHPSESSID"]: ';
var_dump($_COOKIE['PHPSESSID']);
 
echo 'count($_SESSION): ';
var_dump(count($_SESSION));
 
echo '$_SESSION["a"]: ';
var_dump($_SESSION["a"]);
 
echo '$_SESSION["a"] = 1';
$_SESSION["a"] = 1;