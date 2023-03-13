<?php
session_start();
require_once('config/dbFunc.class.php');
include_once('../auth/auth_ssh.class.php');

$au = new auth_ssh();
$db = new dbFunc();
$db = $db->dbConn();

if (isset($_POST['postId'])) {

    if (isset($_POST['arr'])) {
        foreach ($_POST['arr'] as $arr) {
            pg_query($db, "UPDATE public.inc_executors SET role=" . $arr['role'] . ", role_date='" . date('d.m.Y H:i:s') . "' WHERE user_id = " . $arr['hash']);
        }

        pg_query($db, "UPDATE public.inc_idea SET status = 6, freetry_start = '" . date('d.m.Y H:i:s', strtotime($_POST['freetry_start'])) . "',freetry_finish = '" . date('d.m.Y H:i:s', strtotime($_POST['freetry_finish'])) .  "' WHERE id = " . $_POST['postId']);
        return;
    }


    $result_end_vote_time = pg_send_query($db, "SELECT id, idea_id, user_id, role, role_date FROM public.inc_executors WHERE idea_id = " . $_POST['postId'] . " and user_id = " . $au->getUserId($_SESSION['hash']));

    $res_end_time_vote = pg_get_result($db);
    $rows_end_time_vote = pg_num_rows($res_end_time_vote);
    if ($rows_end_time_vote > 0) {
        echo "Вы уже оставили заявку";
    } else {
        $postTime = date('d.m.Y H:i:s');
        pg_query($db, "INSERT INTO public.inc_executors(idea_id, user_id, role, role_date)VALUES (" . $_POST['postId'] . ", " . $au->getUserId($_SESSION['hash']) . ", 3, '" . $postTime . "');");
    }
}
