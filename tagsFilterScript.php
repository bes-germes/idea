<?php

require_once('config/dbFunc.class.php');
        
        $db = new dbFunc();
        $db = $db->dbConn();
if (isset($_POST['tagValue'])) {
    $tags = pg_fetch_assoc(pg_query($db, "SELECT tag FROM public.inc_idea_tag WHERE tag = '" . $_POST['tagValue'] . "';"));
    if (empty($tags)) {
        echo '';
    } else {
        echo $tags['tag'];
    }
}
