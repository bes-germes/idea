<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://localhost/votesite/votesite/jsScripts/DBShowAthorIdeas.js"></script>
    <script src="http://localhost/votesite/votesite/jsScripts/DBShowIdeaForAdmin.js"></script>
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
                <h1 class="fw-light">Admin кабинет</h1>
                <h4>Здесь вы можете делать что захотите</h4>
            </div>
        </div>
    </section>



    <?php
    session_start();
    
    include_once('../auth/auth_ssh.class.php');
    $au = new auth_ssh();

    if (!$au->isAdmin($_SESSION['hash'])) {
        http_response_code(401);
        header('Location:index.php');
        exit;
    }

    require_once('config/dbFunc.class.php');

    $db = new dbFunc();
    $db = $db->dbConn();

    $result_all = pg_query($db, "SELECT * FROM inc_idea ");

    $result_end_vote_time = pg_query($db, "SELECT * FROM public.inc_idea WHERE DATE_PART('day',  vote_finish - '" . date('d.m.Y') . "') <= 0");

    $result_end_freetry_time = pg_query($db, "SELECT * FROM public.inc_idea WHERE DATE_PART('day', freetry_finish -'" . date('d.m.Y') . "') <= 0;");

    $result_check = pg_query($db, "SELECT * FROM inc_idea WHERE status = 1");

    $result_banned = pg_query($db, "SELECT * FROM inc_idea  WHERE status = 9");



    while ($line = pg_fetch_array($result_end_vote_time, null, PGSQL_ASSOC)) {
        $likes = 0;
        $dislikes = 0;
        $query_count_vote = 'SELECT * FROM inc_idea_vote WHERE inc_idea_vote.idea_id=' . $line['id'];
        $result_count_vote = pg_query($query_count_vote) or die('Ошибка запроса: ' . pg_last_error());

        while ($line_count_vote = pg_fetch_array($result_count_vote, null, PGSQL_ASSOC)) {

            if ($line_count_vote['value'] == 1) {
                $likes++;
            }

            if ($line_count_vote['value'] == -1) {
                $dislikes++;
            }
        }

        if ($line['status'] != 6 && $line['status'] != 7 && $line['status'] != 9) {
            if ($likes > $dislikes) {
                pg_query($db, "UPDATE inc_idea SET status = 4 WHERE id = " . $line['id']);
            } else {
                pg_query($db, "UPDATE inc_idea SET status = 5 WHERE id = " . $line['id']);
            }
        }
    }

    $result_end_vote_time = pg_query($db, "SELECT * FROM public.inc_idea WHERE status = 4 or status = 5 or status = 6 or status = 7 or status = 8");
    ?>
    <div class="container">
        <div class="container mt-4">
            <form id="checkLog" action="DbShowReqScript.php" enctype="multipart/form-data" name="status" method="POST">
                <div class="row justify-content-center">

                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <input type="hidden" name="action" id="staus" value="">
                        <button type="button" id="show_all_ideas" value="show" style="margin-top: 15px;" href="?flag=0" class="btn btn-primary rounded-pill w-100" onclick="DBshowAdminAllIdeas()">Все идеи</button>

                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <button type="button" id="show_denied_ideas" value="show" style="margin-top: 15px;" href="?flag=1" class="btn btn-primary rounded-pill w-100" onclick="DBshowCheckIdeas()">Идеи на проверку</button>
                        <input type="hidden" name="action" id="staus" value="and (status = 5 or status = 8)">

                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <button type="button" id="show_in_progress_ideas" value="show" style="margin-top: 15px;" href="?flag=2" class="btn btn-primary rounded-pill w-100" onclick="DBshowEndVoteIdeas()">Идеи у которых закончился срок голосования</button>
                        <input type="hidden" name="action" id="staus" value="and (status != 5 and status != 8 and status != 2 and status != 7)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <button type="button" id="show_in_progress_ideas" value="show" style="margin-top: 15px;" href="?flag=2" class="btn btn-primary rounded-pill w-100" onclick="DBshowEndFreetryIdeas()">Идеи у которых закончился срок исполнения</button>
                        <input type="hidden" name="action" id="staus" value="and (status != 5 and status != 8 and status != 2 and status != 7)">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                        <button type="button" id="show_in_progress_ideas" value="show" style="margin-top: 15px;" href="?flag=2" class="btn btn-primary rounded-pill w-100" onclick="DBshowBannedIdeas()">Забаненные идеи</button>
                        <input type="hidden" name="action" id="staus" value="and (status != 5 and status != 8 and status != 2 and status != 7)">
                    </div>

                    <div class="row d-none" id="ideas_row" style="margin-top: 15px;">
                    </div>

                </div>
            </form>
        </div>
        <div class="row mt-5" id="all">

            <?php
            while ($line = pg_fetch_array($result_all, null, PGSQL_ASSOC)) {
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
                        $idea_status_color = 'success';
                        break;
                    case 5:
                        $idea_status = 'Отклонена пользователями';
                        $idea_status_color = 'danger';
                        break;
                    case 6:
                        $idea_status = 'Выполняется';
                        $idea_status_color = 'info';
                        break;
                    case 7:
                        $idea_status = 'Выполнена';
                        $idea_status_color = 'success';
                        break;
                    case 9:
                        $idea_status = 'Не прошла модерацию';
                        $idea_status_color = 'danger';
                        break;
                    case 8:
                        $idea_status = 'Не пвыполнена';
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
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <p class="text-<?= $idea_status_color ?>"> <?= $idea_status ?></p>
                                    </div>

                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <form id="id" action="showIdeaForAdminScript.php" enctype="multipart/form-data" name="postId" method="POST">
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
        <div id="need_to_check" class="row mt-5 d-none">
            <?php
            while ($line = pg_fetch_array($result_check, null, PGSQL_ASSOC)) {
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
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
                                        <p class="text-info">Модерируются</p>
                                    </div>

                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <form id="showReq" action="showIdeaForAdminScript.php" enctype="multipart/form-data" method="POST">
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
        <div id="end_vote_time" class="row mt-5 d-none">
            <?php
            while ($line = pg_fetch_array($result_end_vote_time, null, PGSQL_ASSOC)) {
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
                }

                switch ($line['status']) {

                    case 4:
                        $idea_status = 'Принята на голосовании';
                        $idea_status_color = 'success';
                        break;
                    case 5:
                        $idea_status = 'Отклонена пользователями';
                        $idea_status_color = 'danger';
                        break;
                    case 6:
                        $idea_status = 'Выполняется';
                        $idea_status_color = 'info';
                        break;
                    case 7:
                        $idea_status = 'Выполнена';
                        $idea_status_color = 'success';
                        break;
                    case 8:
                        $idea_status = 'Не выполнена';
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
                                <div class="row justify-content-between">
                                    <div class="col-auto">

                                        <p class="text-<?= $idea_status_color ?>"> <?= $idea_status ?></p>

                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <form id="id" action="showIdeaForAdminScript.php" enctype="multipart/form-data" name="postId" method="POST">
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

        <div id="end_freetry" class="row mt-5 d-none">
            <?php
            while ($line = pg_fetch_array($result_end_freetry_time, null, PGSQL_ASSOC)) {
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
                }

                switch ($line['status']) {

                    case 6:
                        $idea_status = 'Выполняется';
                        $idea_status_color = 'info';
                        break;
                    case 7:
                        $idea_status = 'Выполнена';
                        $idea_status_color = 'success';
                        break;
                    case 8:
                        $idea_status = 'Не выполнена';
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
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <p class="text-<?= $idea_status_color ?>"> <?= $idea_status ?></p>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <form id="id" action="showIdeaForAdminScript.php" enctype="multipart/form-data" name="postId" method="POST">
                                                <input type="hidden" value="<?= $line['id'] ?>" name="postId">
                                                <input type="submit" class="btn btn-primary rounded-pill w-100" value="Обзор">
                                            </form>
                                        </div>
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

        <div id="banned" class="row mt-5 d-none">
            <?php
            while ($line = pg_fetch_array($result_banned, null, PGSQL_ASSOC)) {
                if ($line['image'] == null) {
                    $link_image = "assets\images\intro.jpg";
                } else {
                    $link_image = $line['image'];
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
                                        <p class="text-danger">Ты забанен!</p>
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