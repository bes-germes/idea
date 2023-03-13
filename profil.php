<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://localhost/idea/jsScripts/DBShowAthorIdeas.js"></script>
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

    <section class="text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Личный кабинет</h1>
                <h4>Здесь вы можете посмотреть свои идеи</h5>
            </div>
        </div>
    </section>



    <?php
    session_start();
    require_once('config/dbFunc.class.php');
    include_once('../auth/auth_ssh.class.php');

    $db = new dbFunc();
    $db = $db->dbConn();
    $au = new auth_ssh();

    $result_student = pg_query($db, "SELECT * FROM students WHERE id=" . $au->getUserId($_SESSION['hash']));
    $line_student = pg_fetch_assoc($result_student);

    $results_group = pg_query($db, "SELECT * FROM students_to_groups WHERE student_id=" . $au->getUserId($_SESSION['hash']));
    $line_group = pg_fetch_assoc($results_group);

    $results_group_name = pg_query($db, 'SELECT * FROM public."group" WHERE id=' . $line_group['group_id']);
    $line_group_name = pg_fetch_assoc($results_group_name);

    $result_all = pg_query($db, "SELECT * FROM inc_idea WHERE author=" . $au->getUserId($_SESSION['hash']) . " ORDER BY status");


    $result_denied = pg_query($db, "SELECT * FROM inc_idea WHERE author='" . $au->getUserId($_SESSION['hash']) . "' and (status = 5 or status = 8)");


    $result_in_progress = pg_query($db, "SELECT * FROM inc_idea WHERE author='" . $au->getUserId($_SESSION['hash']) . "' and (status != 5 and status != 8 and status != 2 and status != 7)");


    $result_accepted = pg_query($db, "SELECT * FROM inc_idea WHERE author='" . $au->getUserId($_SESSION['hash']) . "' and (status = 2 or status = 7)");



    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto">
                <h5><?= $line_student['middle_name'] ?> <?= $line_student['first_name'] ?> <?= $line_student['last_name'] ?> </h5>
                <h5>Группа: <?= $line_group_name['name']  ?> </h5>
            </div>
        </div>
        <div class="container mt-4">
            <form id="checkLog" action="DbShowReqScript.php" enctype="multipart/form-data" name="status" method="POST">
                <div class="row justify-content-center">

                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <input type="hidden" name="action" id="staus" value="">
                        <button type="button" id="show_all_ideas" value="show" style="margin-top: 15px;" href="?flag=0" class="btn btn-primary rounded-pill w-100" onclick="DBshowAllIdeas()">Все идеи</button>

                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <button type="button" id="show_denied_ideas" value="show" style="margin-top: 15px;" href="?flag=1" class="btn btn-primary rounded-pill w-100" onclick="DBshowDeniedIdeas()">Отклонённые идеи</button>
                        <input type="hidden" name="action" id="staus" value="and (status = 5 or status = 8)">

                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <button type="button" id="show_in_progress_ideas" value="show" style="margin-top: 15px;" href="?flag=2" class="btn btn-primary rounded-pill w-100" onclick="DBshowInProgressIdeas()">Идеи в обработке</button>
                        <input type="hidden" name="action" id="staus" value="and (status != 5 and status != 8 and status != 2 and status != 7)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <button type="button" id="show_accept_ideas" value="show" style="margin-top: 15px;" href="?flag=3" class="btn btn-primary rounded-pill w-100" onclick="DBshowAcceptIdeas()">Принятые</button>
                        <input type="hidden" name="action" id="staus" value="and (status = 2 or status = 7)">
                    </div>

                    <div class="row d-none" id="ideas_row" style="margin-top: 15px;">
                    </div>

                </div>
            </form>
        </div>
        <div class="row mt-5" id="all">

            <?php
            while ($line = pg_fetch_array($result_all, null, PGSQL_ASSOC)) {

                $want_to_join =  pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_executors WHERE role = 0 and idea_id = " . $line['id']));

                if ($want_to_join[0] - 1 <= 0) {
                    $new_req = '';
                } else {
                    $new_req = $want_to_join[0] - 1 . " New";
                }
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
                }

                switch ($line['status']) {
                    case 0:
                        $idea_status = 'Готовится';
                        $idea_status_color = 'info';
                        break;
                    case 1:
                        $idea_status = 'Модерируются';
                        $idea_status_color = 'info';
                        break;
                    case 2:
                        $idea_status = 'Опубликована';
                        $idea_status_color = 'success';
                        break;
                    case 3:
                        $idea_status = 'Голосование';
                        $idea_status_color = 'info';
                        break;
                    case 4:
                        $idea_status = 'Принята на голосовании';
                        $idea_status_color = 'info';
                        break;
                    case 5:
                        $idea_status = 'Отклонена пользователями';
                        $idea_status_color = 'danger';
                        break;
                    case 6:
                        $idea_status = 'Голосование';
                        $idea_status_color = 'info';
                        break;
                    case 7:
                        $idea_status = 'Выполнена';
                        $idea_status_color = 'success';
                        break;
                    case 8:
                        $idea_status = 'Не прошла модерацию';
                        $idea_status_color = 'danger';
                        break;
                }

            ?>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-sm-2 mb-md-2 mb-lg-0">
                    <div class="card" style="margin-bottom: 15px;">
                        <div style="width: 100%;height: 40vh;object-fit: cover;">
                            <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                        </div>

                        <div class="card-body" style="width: 100%; height: 150px; max-height: 300px">
                            <h5 class="card-title"><?= mb_strimwidth($line['title'], 0, 24, "...") ?></h5>
                            <p class="card-text"><?= mb_strimwidth($line['description'], 0, 120, "...") ?></p>
                        </div>
                        <div class="card-body">

                            <div class="container">
                                <div class="row">
                                    <div class="col-auto">
                                        <p class="text-<?= $idea_status_color ?>"> <?= $idea_status ?></p>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <form id="id" action="showIdeaForUserScript.php" enctype="multipart/form-data" name="postId" method="POST">
                                            <input type="hidden" value="<?= $line['id'] ?>" name="postId">
                                            <input type="submit" class="btn btn-primary rounded-pill w-100" value="Обзор">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php
            }

            ?>
        </div>
        <div id="denied" class="row mt-5 d-none">
            <?php
            while ($line = pg_fetch_array($result_denied, null, PGSQL_ASSOC)) {
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
                }

                switch ($line['status']) {
                    case 0:
                        $idea_status = 'Готовится';
                        break;
                    case 1:
                        $idea_status = 'Модерируются';
                        break;
                    case 2:
                        $idea_status = 'Опубликована';
                        break;
                    case 3:
                        $idea_status = 'Голосование';
                        break;
                    case 4:
                        $idea_status = 'Принята на голосовании';
                        break;
                    case 5:
                        $idea_status = 'Отклонена пользователями';
                        break;
                    case 6:
                        $idea_status = 'Голосование';
                        break;
                    case 7:
                        $idea_status = 'Выполнена';
                        break;
                    case 8:
                        $idea_status = 'Не прошла модерацию';
                        break;
                }

            ?>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-sm-2 mb-md-2 mb-lg-0">
                    <div class="card" style="margin-bottom: 15px;">
                        <div style="width: 100%;height: 40vh;object-fit: cover;">
                            <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                        </div>

                        <div class="card-body" style="width: 100%; height: 150px; max-height: 300px">
                            <h5 class="card-title"><?= mb_strimwidth($line['title'], 0, 24, "...") ?></h5>
                            <p class="card-text"><?= mb_strimwidth($line['description'], 0, 120, "...") ?></p>
                        </div>
                        <div class="card-body">

                            <div class="container">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <p class="text-danger"> <?= $idea_status ?></p>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php
            }

            ?>
        </div>
        <div id="in_progress_ideas" class="row mt-5 d-none">
            <?php
            while ($line = pg_fetch_array($result_in_progress, null, PGSQL_ASSOC)) {
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
                }

                switch ($line['status']) {
                    case 0:
                        $idea_status = 'Готовится';
                        break;
                    case 1:
                        $idea_status = 'Модерируются';
                        break;
                    case 2:
                        $idea_status = 'Опубликована';
                        break;
                    case 3:
                        $idea_status = 'Голосование';
                        break;
                    case 4:
                        $idea_status = 'Принята на голосовании';
                        break;
                    case 5:
                        $idea_status = 'Отклонена пользователями';
                        break;
                    case 6:
                        $idea_status = 'Голосование';
                        break;
                    case 7:
                        $idea_status = 'Выполнена';
                        break;
                    case 8:
                        $idea_status = 'Не прошла модерацию';
                        break;
                }

            ?>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-sm-2 mb-md-2 mb-lg-0">
                    <div class="card" style="margin-bottom: 15px;">
                        <div style="width: 100%;height: 40vh;object-fit: cover;">
                            <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                        </div>

                        <div class="card-body" style="width: 100%; height: 150px; max-height: 300px">
                            <h5 class="card-title"><?= mb_strimwidth($line['title'], 0, 24, "...") ?></h5>
                            <p class="card-text"><?= mb_strimwidth($line['description'], 0, 120, "...") ?></p>
                        </div>
                        <div class="card-body">

                            <div class="container">
                                <div class="row justify-content-between">
                                    <div class="col-auto">

                                        <p class="text-info"> <?= $idea_status ?></p>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php
            }

            ?>

        </div>

        <div id="accept_ideas" class="row mt-5 d-none">
            <?php
            while ($line = pg_fetch_array($result_accepted, null, PGSQL_ASSOC)) {
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
                }

                switch ($line['status']) {
                    case 0:
                        $idea_status = 'Готовится';
                        break;
                    case 1:
                        $idea_status = 'Модерируются';
                        break;
                    case 2:
                        $idea_status = 'Опубликована';
                        break;
                    case 3:
                        $idea_status = 'Голосование';
                        break;
                    case 4:
                        $idea_status = 'Принята на голосовании';
                        break;
                    case 5:
                        $idea_status = 'Отклонена пользователями';
                        break;
                    case 6:
                        $idea_status = 'Голосование';
                        break;
                    case 7:
                        $idea_status = 'Выполнена';
                        break;
                    case 8:
                        $idea_status = 'Не прошла модерацию';
                        break;
                }

            ?>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-sm-2 mb-md-2 mb-lg-0">
                    <div class="card" style="margin-bottom: 15px;">
                        <div style="width: 100%;height: 40vh;object-fit: cover;">
                            <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                        </div>

                        <div class="card-body" style="width: 100%; height: 150px; max-height: 300px">
                            <h5 class="card-title"><?= mb_strimwidth($line['title'], 0, 24, "...") ?></h5>
                            <p class="card-text"><?= mb_strimwidth($line['description'], 0, 120, "...") ?></p>
                        </div>
                        <div class="card-body">

                            <div class="container">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <p class="text-success"> <?= $idea_status ?></p>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php
            }

            ?>
        </div>


    </div>

</body>

</html>