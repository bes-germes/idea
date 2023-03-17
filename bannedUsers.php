<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <script src="../idea/jsScripts/DBBanUser.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Test1</title>

</head>

<body>
    <header>
        <div class="navbar navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a href="index.php" class="navbar-brand d-flex align-items-center">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg> -->
                    <strong>Инкубатор идей</strong>
                </a>
            </div>
        </div>
    </header>

    <div id='reqSuggest'>

        <section class="text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Забаненные пользователи</h1>
                </div>
            </div>
        </section>



        <div class="container">

            <div class="row justify-content-center">

                <div class="col-auto">
                    <select class="form-select" aria-label="Default select example" onchange="findExecuterByGroup()">
                        <option selected>Выберите группу</option>
                        <?php
                        session_start();

                        require_once('config/dbFunc.class.php');

                        $db = new dbFunc();
                        $db = $db->dbConn();
                        $result_groups = pg_query($db, 'SELECT name, id FROM public."group";');
                        while ($line_groups = pg_fetch_array($result_groups, null, PGSQL_ASSOC)) {

                        ?>
                            <option id="option_select<?= $line_groups['id'] ?>" value="<?= $line_groups['id'] ?>"><?= $line_groups['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-auto">

                    Забаненные пользователи
                    <ul class="list-group">
                        <?php



                        $banned_users = pg_query($db, 'SELECT id FROM public.inc_user WHERE locked = true');

                        while ($banned_users_result = pg_fetch_array($banned_users)) {

                            $banned_users_names = pg_query($db, 'SELECT id, first_name, middle_name, last_name, login FROM public.students WHERE id = ' . $banned_users_result['id']);
                            $banned_users_names_result = pg_fetch_array($banned_users_names);
                        ?>
                            <li class="list-group-item"><?= $banned_users_names_result['first_name'] ?> <?= $banned_users_names_result['middle_name'] ?> <?= $banned_users_names_result['last_name'] ?>
                                <button class="btn btn-primary ml-3" id="buttonBack" type="button" onclick="DBUnbanUser(<?= $banned_users_result['id'] ?>)">Разбанить</button>
                            </li>

                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>



</body>

</html>