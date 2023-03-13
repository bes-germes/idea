<?php

require_once('config/dbFunc.class.php');
        
        $db = new dbFunc();
        $db = $db->dbConn();

session_start();

if (isset($_POST['tagValue']) && isset($_POST['postID'])) {


    $quary = "SELECT id, idea_id, tag FROM public.inc_idea_tag WHERE idea_id = " . $_POST['postID'];
    echo $quary;

    $result = pg_query($db, (string) $quary);
    $line = pg_fetch_assoc($result);

    if (!is_array($line)) {
        pg_query($db, "INSERT INTO public.inc_idea_tag( idea_id, tag) VALUES (" . $_POST['postID'] . ", '" . $_POST['tagValue'] . "');");
        echo "INSERT INTO public.inc_idea_tag( idea_id, tag) VALUES (" . $_POST['postID'] . ", '" . $_POST['tagValue'] . "');";
    } else {
        pg_query($db, "UPDATE public.inc_idea_tag SET tag = '" . $_POST['tagValue'] . "' WHERE idea_id =" . $_POST['postID'] . ";");
    }
}
