<?php
session_start();
include_once('../auth/auth_ssh.class.php');
require_once('config/dbFunc.class.php');

$au = new auth_ssh();

$db = new dbFunc();
$db = $db->dbConn();
$result_idea = pg_query($db, "SELECT * FROM inc_idea WHERE author=" . $au->getUserId($_SESSION['hash']) . $_POST['status']);
