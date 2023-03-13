<?php
session_start();
include_once('config\dbFunc.class.php');
include_once('../auth/auth_ssh.class.php');

$au = new auth_ssh();

$db = new dbFunc();
$db = $db->dbConn();


$quary = "SELECT * FROM inc_idea_vote WHERE idea_id =" . $_POST['postId'] . " and user_id =" . $au->getUserId($_SESSION['hash']) . ";";
echo $quary;

$result = pg_query($db, (string) $quary);
$line = pg_fetch_assoc($result);

if (!is_array($line)) {
   $quary = "INSERT INTO inc_idea_vote VALUES(" . $_POST['postId'] . "," . $_SESSION['hash'] . "," . $_POST['dislikeBool'] . ")";
   echo $quary;
   pg_query($db, (string) $quary);
} else {
   $quary = "UPDATE inc_idea_vote SET value = " . $_POST['dislikeBool'] . " WHERE idea_id = " . $_POST['postId'] . " and user_id =" .  $au->getUserId($_SESSION['hash']) . ";";
   echo $quary;
   pg_query($db, (string) $quary);
}
