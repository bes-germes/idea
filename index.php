<!DOCTYPE html>
<html lang="en">

<head>

    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script type="text/javascript" src="https://unpkg.com/popper.js"></script>
    <!-- подключаем универсальный скрипт, который использует API propper.js для упрощенного использование подсказок -->
    <script type="text/javascript" src="https://unpkg.com/tooltip.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="http://localhost/idea/jsScripts/DBAddComment.js"></script>
    <script src="http://localhost/idea/jsScripts/DBAddLikeDislike.js"></script>
    <script src="http://localhost/idea/jsScripts/DBShowReply.js"></script>
    <script src="http://localhost/idea/jsScripts/DBBanUser.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Test</title>


</head>

<body>
    <header>
        <?php
        include_once('../auth/auth_ssh.class.php');

        session_start();


        $au = new auth_ssh();
        $user = $au->loggedIn($_SESSION['hash']);

        if (!$user) {
            $show_your_like = -1;
        } else {
            $show_your_like = $au->getUserId($_SESSION['hash']);
        }

        ?>
        <div class="navbar navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a href="index.php" class="navbar-brand d-flex align-items-center">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg> -->
                    <strong>Инкубатор идей</strong>
                </a>

                <?php
                if ($user != '') { ?>
                    <form id="checkInOut" action="../auth/action.php" enctype="multipart/form-data" method="POST">

                        <input type="hidden" value="logout" name="action">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                            <?php if ($au->isAdmin($_SESSION['hash'])) { ?>

                                <div class="dropdown">
                                    <button class="btn btn-primary rounded-pill w-100 dropdown-toggle" id="dropdownMenuButton1" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $user ?></button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="adminProfil.php">кабинет админа</a></li>
                                        <li><a class="dropdown-item" href="profil.php">личный кабинет</a></li>
                                    </ul>
                                </div>
                            <?php } else { ?>
                                <a class="btn btn-primary rounded-pill w-100" href="profil.php"><?= $user ?></a>
                            <?php } ?>
                        </div>

                        <input type="submit" class="btn btn-primary rounded-pill w-100" style="margin-top: 5px;" value="Выйти">
                    </form>
                <?php } else { ?>
                    <form id="checkInOut" action="ideaLogin.php" enctype="multipart/form-data" method="POST">

                        <input type="hidden" value="login" name="action">
                        <input type="submit" class="btn btn-primary rounded-pill w-100" value="Войти">
                    </form>
                <?php } ?>
            </div>
        </div>
    </header>
    <main>

        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Здесь вы можете оставить свою идею</h1>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=0">Все идеи</a>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=1" id="1">Идеи в процессе</a>

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=2" id="2">Отклонённые идеи</a>

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <a class="btn btn-primary rounded-pill w-100" href="?flag=3" id="3">Предложенные идеи</a>

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-auto col-xl-auto mb-sm-2 mb-md-2 mb-lg-0">
                    <?php if ($user != '') { ?>
                        <a class="btn btn-primary rounded-pill w-100" href="addRequset.php">Добавить идею</a>
                    <?php } else { ?>
                        <a class="btn btn-primary rounded-pill w-100" href="authSuggestion.php">Добавить идею</a>
                    <?php } ?>
                </div>

            </div>
        </div>
        <hr>

        <?php

        if (!isset($_GET['flag'])) {
            $flag = 0;
        } else {
            $flag = $_GET['flag'];
        }


        require_once('config/dbFunc.class.php');

        $db = new dbFunc();
        $db = $db->dbConn();

        switch ($flag) {
            case 0:
                $query = 'SELECT * FROM inc_idea  WHERE status != 1 and status != 9 ORDER BY status';
                break;
            case 1:
                $query = 'SELECT * FROM inc_idea WHERE status = 6';
                break;
            case 2:
                $query = 'SELECT * FROM inc_idea WHERE status = 5 or status = 8';
                break;
            case 3:
                $query = 'SELECT * FROM inc_idea WHERE status = 2 or status = 3';
                break;
        }
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());


        ?>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php
                    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

                        $query_tags = 'SELECT *FROM public.inc_idea_tag WHERE  idea_id =' . $line['id'];

                        $query_likes = 'SELECT * FROM inc_idea_vote WHERE inc_idea_vote.user_id= ' . $show_your_like . ' and inc_idea_vote.idea_id=' . $line['id'];

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

                        pg_send_query($db, "SELECT * FROM public.inc_idea WHERE DATE_PART('day', vote_start - '" . date('d.m.Y') . "') > 0 and id = " . $line['id'] . ";");
                        $res_vote_time_left_to_begin = pg_get_result($db);
                        $rows_vote_time_left_to_begin = pg_num_rows($res_vote_time_left_to_begin);
                        $vote_time_left_to_begin_line = pg_fetch_array($res_vote_time_left_to_begin, null, PGSQL_ASSOC);
                        pg_send_query($db, "SELECT * FROM public.inc_idea WHERE DATE_PART('day', vote_finish - '" . date('d.m.Y') . "') > 0 and DATE_PART('day', vote_start - '" . date('d.m.Y') . "') <= 0 and id = " . $line['id'] . ";");

                        $res_end_time_vote = pg_get_result($db);
                        $rows_end_time_vote = pg_num_rows($res_end_time_vote);
                        $result_likes = pg_query($query_likes) or die('Ошибка запроса: ' . pg_last_error());
                        $likes_line = pg_fetch_array($result_likes, null, PGSQL_ASSOC);

                        $tag_result = pg_query($query_tags) or die('Ошибка запроса: ' . pg_last_error());
                        $tag_line = pg_fetch_assoc($tag_result);

                        if ($likes_line == false) {
                            $put_like = 'outline-';
                            $put_dislike = 'outline-';
                            $likeBool = 0;
                            $disBool = 0;
                        } else {

                            if ($likes_line['value'] == 1) {
                                $put_like = '';
                                $put_dislike = 'outline-';
                                $likeBool = 1;
                                $disBool = 0;
                            } else if ($likes_line['value'] == -1) {
                                $put_like = 'outline-';
                                $put_dislike = '';
                                $likeBool = 0;
                                $disBool = 1;
                            } else if ($likes_line['value'] == 0) {
                                $put_like = 'outline-';
                                $put_dislike = 'outline-';
                                $likeBool = 0;
                                $disBool = 0;
                            }
                        }

                        if ($line['image'] == null) {
                            $link_image = "assets\images\intro.jpg";
                        } else {
                            $link_image = $line['image'];
                        }


                        switch ($line['status']) {
                            case 0:
                                $idea_status = 'Готовится';
                                $idea_status_color = 'primary';
                                break;
                            case 1:
                                $idea_status = 'Модерируются';
                                $idea_status_color = 'primary';
                                break;
                            case 2:
                                $idea_status = 'Опубликована';
                                $idea_status_color = 'success';
                                break;
                            case 3:
                                if ($rows_vote_time_left_to_begin > 0) {
                                    $idea_status = 'Начнётся: ' . mb_substr($vote_time_left_to_begin_line['vote_start'], 0, 10);
                                    $idea_status_color = 'primary';
                                } else {
                                    if ($rows_end_time_vote > 0) {
                                        $idea_status = 'Голосование';
                                        $idea_status_color = 'primary';
                                    } else {
                                        $idea_status = 'Голосование окончено';
                                        $idea_status_color = 'warning';
                                    }
                                }
                                break;
                            case 4:
                                $idea_status = 'Принята на голосовании';
                                $idea_status_color = 'success';
                                break;
                            case 5:
                                $idea_status = 'Отклонена голосованием';
                                $idea_status_color = 'danger';
                                break;
                            case 6:
                                $idea_status = 'Выполняется';
                                $idea_status_color = 'primary';
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
                            <div class="card " style="margin-bottom: 15px;">
                                <div style="width: 100%;height: 40vh;object-fit: cover;">
                                    <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <p class="text-<?= $idea_status_color ?>"> <?= $idea_status ?>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="badge bg-<?= $idea_status_color ?>" title="<?= $tag_line['tag'] ?>"><?= mb_strimwidth($tag_line['tag'], 0, 20, "...") ?></span></p>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-body" style="width: 100%; height: 150px; max-height: 300px">
                                    <h5 class="card-title"><?= mb_strimwidth($line['title'], 0, 24, "...") ?></h5>
                                    <p class="card-text"><?= mb_strimwidth($line['description'], 0, 120, "...") ?></p>
                                </div>
                                <div class="card-body">

                                    <div class="container">
                                        <div class="row justify-content-between">
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="<?= '#modal' . $line['id'] ?>">
                                                    Обзор
                                                </button>
                                            </div>
                                            <div class="col-auto">
                                                <?php if ($rows_end_time_vote > 0) { ?>
                                                    <?php if ($user != '') { ?>
                                                        <button class="btn btn-<?= $put_like ?>success" id="like_btn<?= $line['id'] ?>" value="<?= $likeBool ?>" style="border-radius: 15px;" onclick="DBAddLike(<?= $line['id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                            </svg><span id="like-span<?= $line['id'] ?>"><?= $likes ?></span></button>
                                                        <button class="btn btn-<?= $put_dislike ?>danger" id="dis_btn<?= $line['id'] ?>" value=" <?= $disBool ?>" style="border-radius: 15px;" onclick="DBAddDislike(<?= $line['id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                            </svg><span id="dis-span<?= $line['id'] ?>"><?= $dislikes ?></span></button>
                                                    <?php } else { ?>
                                                        <a class="btn btn-outline-success" id="like_btn" value="" style="border-radius: 15px;" href="authSuggestion.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                            </svg><span id="like-span<?= $line['id'] ?>"><?= $likes ?></span></a>
                                                        <a class="btn btn-outline-danger" id="dis_btn" value="" style="border-radius: 15px;" href="authSuggestion.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                            </svg><span id="dis-span<?= $line['id'] ?>"><?= $dislikes ?></span></a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <button class="btn btn-<?= $put_like ?>success" id="like_btn<?= $line['id'] ?>" value="<?= $likeBool ?>" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                        </svg><span id="like-span<?= $line['id'] ?>"><?= $likes ?></span></button>
                                                    <button class="btn btn-<?= $put_dislike ?>danger" id="dis_btn<?= $line['id'] ?>" value=" <?= $disBool ?>" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                        </svg><span id="dis-span<?= $line['id'] ?>"><?= $dislikes ?></span></button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Модальное окно-->
                            <div class="modal fade" id="<?= 'modal' .  $line['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="exit" style="margin-left: 97%">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                        </div>
                                        <img class="card-img-top" src="<?= $link_image ?>" style="width: 30%; height: 30%; margin: auto; max-height: 400px;" alt="Card image cap">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><?= $line['title'] ?></h5>
                                        </div>
                                        <div class="modal-body">
                                            <?= $line['description'] ?>
                                        </div>
                                        <hr>
                                        <h5 class="modal-title" style="margin-left: 15px" id="exampleModalLabel">Комментарии</h5>
                                        <?php $curId = $line['id'];
                                        ?>
                                        <div class="commnet_container" id="commnet_container<?= $curId ?>">
                                            <?php $query_comments = 'SELECT * FROM inc_comment WHERE idea_id=' . $line['id'] . ' and comment_id = -1';
                                            $result_comments = pg_query($query_comments) or die('Ошибка запроса: ' . pg_last_error());

                                            while ($comment = pg_fetch_array($result_comments, null, PGSQL_ASSOC)) {
                                                $result_author = pg_query('SELECT * FROM students WHERE id=' . $comment['author_id']) or die('Ошибка запроса: ' . pg_last_error());

                                                $author = pg_fetch_array($result_author, null, PGSQL_ASSOC);
                                                $result_ban_author = pg_query('SELECT count(locked) FROM inc_user WHERE  locked = true and id=' . $comment['author_id']) or die('Ошибка запроса: ' . pg_last_error());

                                                $ban_author = pg_fetch_array($result_ban_author, null, PGSQL_ASSOC);

                                                if ($ban_author['count'] == 0) {
                                            ?>
                                                    <div class="comment_body" id="comment_body<?= $comment['id'] ?>">
                                                        <div class="comment_head">
                                                            <?= $author['middle_name'] . " " . $author['first_name'] ?>
                                                        </div>
                                                        <div class="comment_inner text-break display: inline-block; width:100px; height:50px;">
                                                            <?= $comment['description'] ?>
                                                        </div>
                                                        <div class="comment_time">
                                                            <?=
                                                            date('d.m.Y H:i:s', strtotime($comment['created']));
                                                            ?>

                                                            <?php if ($au->isAdmin($_SESSION['hash'])) { ?>
                                                                <button type="button" id="delete_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBDeleteComment(<?= $comment['id'] ?>)">Удалить</button>
                                                                <button type="button" id="ban_user<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBBanUser(<?= $author['id'] ?>)">Забанить</button>
                                                            <?php } ?>
                                                        </div>

                                                        <?php $count = pg_fetch_row(pg_query($db, "SELECT count(*) FROM inc_comment WHERE comment_id =" . $comment['id']));

                                                        if ($count[0] != 0) {
                                                        ?>
                                                            <button type="button" id="rpy_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBShowReply(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>)">Развернуть</button>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <button type="button" id="rpy_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBAnwerToComment(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>, '<?= $author['middle_name'] . ' ' . $author['first_name'] ?>')">Ответить</button>
                                                        <?php
                                                        }
                                                        ?>
                                                        <div class="d-none" id="comment_reply<?= $comment['id'] ?>" style="flex-direction: column;display: flex;padding: 10px;margin-right: 65px;margin-left: 60px;">
                                                            <?php
                                                            $query_comments_reply = 'SELECT * FROM inc_comment WHERE comment_id != -1';
                                                            $result_comments_reply = pg_query($query_comments_reply) or die('Ошибка запроса: ' . pg_last_error());
                                                            while ($comment_reply = pg_fetch_array($result_comments_reply, null, PGSQL_ASSOC)) {
                                                                if ($comment_reply['comment_id'] == $comment['id']) {
                                                                    $result_author = pg_query('SELECT * FROM students WHERE id=' . $comment_reply['author_id']) or die('Ошибка запроса: ' . pg_last_error());
                                                                    $author = pg_fetch_array($result_author, null, PGSQL_ASSOC);

                                                                    $result_delete_comm = pg_query($db, "SELECT id FROM inc_comment WHERE description = '" . $comment_reply['description'] . "'");
                                                                    $delete_com_id = pg_fetch_array($result_delete_comm, null, PGSQL_ASSOC);



                                                            ?>
                                                                    <div class="comment_head">
                                                                        <?= $author['middle_name'] . " " . $author['first_name'] ?>
                                                                    </div>
                                                                    <div class="comment_inner text-wrap">
                                                                        <?= $comment_reply['description'] ?>
                                                                    </div>
                                                                    <div class="comment_time">
                                                                        <?=
                                                                        date('d.m.Y H:i:s', strtotime($comment_reply['created']));
                                                                        ?>
                                                                        <button type="button" id="answer_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBAnwerToComment(<?= $comment['id'] ?>, <?= $comment['idea_id'] ?>, '<?= $author['middle_name'] . ' ' . $author['first_name'] ?>')">Ответить</button>
                                                                        <?php if ($au->isAdmin($_SESSION['hash'])) { ?>
                                                                            <button type="button" id="delete_btn<?= $comment['id'] ?>" value="<?= $comment['id'] ?>" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;" onclick="DBDeleteComment(<?= $delete_com_id['id'] ?>)">Удалить</button>
                                                                        <?php } ?>
                                                                    </div>

                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>


                                            <?php
                                                }
                                            } ?>
                                        </div>

                                        <div class="comment_push mb-3">
                                            <div class="container-lg">

                                                <?php if ($user != '') {
                                                    $result_ban_author = pg_query('SELECT count(locked) FROM inc_user WHERE  locked = true and id=' . $au->getUserId($_SESSION['hash'])) or die('Ошибка запроса: ' . pg_last_error());

                                                    $ban_author = pg_fetch_array($result_ban_author, null, PGSQL_ASSOC);

                                                    if ($ban_author['count'] == 0) {
                                                ?>
                                                        <div class="input-group" id="input-group<?= $curId ?>">

                                                            <?php $curId = $line['id'];
                                                            ?>
                                                            <textarea name="hide" style="display:none;" class="form-control" id="answerInputArea<?= $curId ?>" maxlength="250" type="text" placeholder="Ответить на комментарий" required></textarea>

                                                            <textarea class="form-control" id="commentInputArea<?= $curId ?>" maxlength="250" type="text" placeholder="Оставить комментарий" name="comment_push_enter" required></textarea>

                                                            <div class="input-group-append" id="commentInputDiv<?= $curId ?>">
                                                                <?php

                                                                $author = $au->getUserData($_SESSION['hash']);

                                                                ?>
                                                                <button type="button" id="commentInputBtn<?= $curId ?>" class="btn" style="" type="" onclick="DBAddComment('<?= $curId ?>','<?= $author['first_name'] ?>','<?= $author['middle_name'] ?>','<?= $author['last_name'] ?>','<?= $author['user_id'] ?>','<?= $author['login'] ?>')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                                                    </svg>
                                                                </button>

                                                            </div>
                                                        <?php
                                                    } else {

                                                        ?>
                                                            <div class="container">
                                                                <div class="row justify-content-center">
                                                                    <input class="form-control" type="text" value="Вы заблокированы и не можете оставлять комментарии" aria-label="Disabled input example" disabled readonly>

                                                                </div>
                                                            <?php
                                                        }
                                                            ?>
                                                           
                                                        </div>
                                                        <?php if ($line['status'] <= 3) { ?>
                                                            <div class="row" style="margin-top: 1rem;">
                                                                <div class="col">
                                                                    <!-- <a type="button" href="wantToBeExuter.php" class="btn btn-outline-secondary btn-sm">Хочу стать исполнителем идеи!</a> -->
                                                                    <form id="checkInOut" action="wantToBeExuter.php" enctype="multipart/form-data" method="POST">

                                                                        <input type="hidden" value="<?= $curId ?>" name="action">
                                                                        <input type="submit" class="btn btn-outline-secondary btn-sm" value="Хочу стать исполнителем идеи!">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <div class="container">
                                                            <div class="row justify-content-center">
                                                                <input class="form-control" type="text" value="Оставлять комментарии могут только авторизированные пользователи" aria-label="Disabled input example" disabled readonly>
                                                                <a class="btn btn-primary" style="margin-top: 1rem;" href="authSuggestion.php" role="button">Войти</a>
                                                            </div>
                                                        </div>
                                                        </a>
                                                    <?php } ?>
                                                    <div class="w-100" id="w-100"></div>
                                                    <div id="commentErr<?= $curId ?>" class="d-none" style="color: red;">
                                                        Пожалуйста введите текст
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

    </main>
</body>

</html>