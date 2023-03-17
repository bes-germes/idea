<?php
require_once('config/dbFunc.class.php');
include_once('../auth/auth_ssh.class.php');

$au = new auth_ssh();
$db = new dbFunc();
$db = $db->dbConn();



if (!isset($_POST['ComIdx'])) {
    $comId = -1;
} else {
    $comId = $_POST['ComIdx'];
}


$descr = $_POST['com'];
$postId = $_POST['idPost'];

$postTime = date('d.m.Y H:i:s');

$isExistAuthor = pg_query($db, "SELECT count(id) FROM public.students WHERE id = " . $_POST['user_id']);
$isExistAuthor = pg_fetch_assoc($isExistAuthor);
if ($isExistAuthor['count'] == 0){
    $newAuthor = pg_query($db, "INSERT INTO public.students(id, first_name, middle_name, last_name, login) VALUES (".$_POST['user_id'].", ".$_POST['first_name'].",".$_POST['middle_name']." ,".$_POST['last_name']." ,".$_POST['login']." )");
}

$quary = "INSERT into inc_comment(idea_id, comment_id, author_id, description, created, modified)  VALUES(" . $postId . "," . $comId . "," . $_POST['user_id']. ", '" . $descr . "','" . $postTime . "','" . $postTime . "');";
$res = pg_query($db, (string) $quary);
$quary = "SELECT MAX(id) from inc_comment";
$res = pg_query($db, (string) $quary);

echo pg_fetch_assoc($res)['max'];
