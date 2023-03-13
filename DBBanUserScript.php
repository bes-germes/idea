<?php
session_start();
include_once('../auth/auth_ssh.class.php');
require_once('config/dbFunc.class.php');

$au = new auth_ssh();

$db = new dbFunc();
$db = $db->dbConn();


$isExistAuthor = pg_query("SELECT count(id) FROM public.inc_user WHERE id = " . $_POST['user_id']);
$isExistAuthor = pg_fetch_assoc($isExistAuthor);
if ($isExistAuthor['count'] == 0) {

    $result_idea = pg_query($db, "INSERT INTO public.inc_user(id, locked) VALUES (" . $_POST['user_id'] . ", true)");
}
