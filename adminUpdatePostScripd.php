<?php

if (isset($_POST['idPost']) && isset($_POST['status'])) {
    include_once('config\dbFunc.class.php');

    $db = new dbFunc();

    $db = $db->dbConn();


    $quary = "UPDATE inc_idea SET status = " . $_POST['status'] . ", vote_start = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_start'])) . "',vote_finish = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_finish'])) . "' WHERE id = " . $_POST['idPost'];
    $res = pg_query($db, "UPDATE inc_idea SET status = " . $_POST['status'] . ", vote_start = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_start'])) . "',vote_finish = '" . date('d.m.Y H:i:s', strtotime($_POST['vote_finish'])) . "' WHERE id = " . $_POST['idPost']);
    echo $quary;
    if ($res) {
        echo "kryto";
    } else {
        echo "ploxo";
    }
}
