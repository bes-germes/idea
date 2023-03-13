<?php

require_once('config/dbFunc.class.php');
        
        $db = new dbFunc();
        $db = $db->dbConn();
if (isset($_POST['tagValue']) && isset($_POST['postID'])) {

    pg_query($db, "DELETE FROM public.inc_idea_tag WHERE idea_id = " . $_POST['postID']);
}
