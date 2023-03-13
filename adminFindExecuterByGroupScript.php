<?php

if (isset($_POST['group'])) {
    include_once('config\dbFunc.class.php');

    $db = new dbFunc();

    $db = $db->dbConn();

    
    $res_students_id = pg_query($db, "SELECT student_id FROM public.students_to_groups WHERE group_id =" . $_POST['group'] . ";");
    $index = 0;
    while ($row = pg_fetch_row($res_students_id)) {

        $res_students_names = pg_query($db, "SELECT first_name, middle_name, last_name FROM public.students where id =" . $row[0]);
        $bebeebe = pg_fetch_row($res_students_names);

        if (isset($_POST['existIndx'])) {
            if (in_array($row[0], $_POST['existIndx'])) {
                continue;
            }
        }
?>

        <li class="list-group-item d-flex" id="add_student_id<?= $index ?>">
            <input class="form-control form-control-sm" type="text" placeholder="<?= $bebeebe[0]  ?>" readonly>
            <input class="form-control form-control-sm" type="text" placeholder="<?= $bebeebe[1] ?>" readonly>
            <input class="form-control form-control-sm" type="text" placeholder="<?= $bebeebe[2]   ?>" readonly>
            <div class="form-check form-switch" id="switch-delete">

                <input class="form-check-input ms-2" type="checkbox" name="form-check-input-add" value="<?= $row[0] ?>" id="<?= $index ?>">
            </div>
        </li>
<?php
        $index++;
    }
}
