<?php

if (isset($_POST['postId'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="http://localhost/votesite/votesite/jsScripts/wantToBeExuterShowSucces.js"></script>
        <script src="http://localhost/votesite/votesite/jsScripts/adminAcceptDeniedIdea.js"></script>
        <script src="http://localhost/votesite/votesite/jsScripts/userEditIdea.js"></script>
        <script src="http://localhost/votesite/votesite/jsScripts/DBaddReq.js"></script>
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
                    <h4>Здесь вы можете посмотреть статус своих идей</h5>
                </div>
            </div>
        </section>



        <?php
        session_start();
        
        include_once('config\dbFunc.class.php');
        include_once('../auth/auth_ssh.class.php');

        $au = new auth_ssh();
        $db = new dbFunc();
        $db = $db->dbConn();


        $result = pg_query($db, "SELECT * FROM inc_idea WHERE id = " . $_POST['postId']);
        $line = pg_fetch_assoc($result);

        $result_executers = pg_query($db, "SELECT * FROM public.inc_executors WHERE idea_id =" . $_POST['postId']);

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

        if ($line['image'] == null) {
            $link_image = "assets\images\intro.jpg";
        } else {
            $link_image = $line['image'];
        }

        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="card" style="margin-bottom: 15px;">
                        <div class="row">
                            <div style="width: 100%;height: 40vh;object-fit: cover;">
                                <img class="card-img-top" id="image" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">
                                <input class="card-img-top d-none" type="image" onclick="uplodNewImage()" id="imageEdit" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">
                            </div>

                            <!-- <div class="mb-3 d-none">
                                <input class="form-control" type="file" id="formFile">
                            </div> -->

                        </div>

                        <div class="card-body" id="cardBodyTitleText" style="width: 100%;">
                            <h5 class="card-title" id="card-title"><?= $line['title'] ?></h5>
                            <p class="card-text" id="card-text"><?= $line['description'] ?></p>
                        </div>
                        <div class="card-body d-none" id="cardBodyTitleTextEdit" style="width: 100%;">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <textarea class="form-control" id="title_req" maxlength="23" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <textarea class="form-control" id="text_req" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="container">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <button class="btn btn-success" type="button" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                            </svg><span id="like-span"><?= $likes ?></span></button>
                                        <button class="btn btn-danger" type="button" style="border-radius: 15px;" disabled><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                            </svg><span id="dis-span"><?= $dislikes ?></span></button>
                                    </div>
                                    <?php
                                    if ($line['status'] == 1) {
                                    ?>
                                        <div class="col-auto">
                                            <button class="btn btn-primary btn-sm" id="buttonEdit" onclick="userEditIdea()">Редактировать</button>
                                            <button class="btn btn-primary btn-sm d-none" id="buttonEditBack" onclick="userEditIdeaCancel()">Отмена</button>
                                            <button class="btn btn-primary btn-sm d-none" id="buttonEditSave" onclick="saveEditIdea(<?= $line['id'] ?>)">Сохранить</button>
                                            <input class="form-control form-control-sm d-none mt-3" onchange="uplodNewImage()" type="file" id="formFile">
                                        </div>
                                    <?php
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php $result_executers = pg_query($db, "SELECT * FROM public.inc_executors WHERE user_id != " . $au->getUserId($_SESSION['hash']) . " and idea_id =" . $_POST['postId']);
                    $result_bool = pg_query($db, "SELECT * FROM public.inc_executors WHERE user_id != " . $au->getUserId($_SESSION['hash']). " and idea_id =" . $_POST['postId']);
                    $rs = pg_fetch_assoc($result_bool);

                    if ($rs) {
                    ?>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                Откликнулись на заявку
                            </div>
                        <?php
                    }

                    while ($line_executers = pg_fetch_array($result_executers, null, PGSQL_ASSOC)) {
                        $result_user = pg_query($db, "SELECT * FROM public.students WHERE id = " . $line_executers['user_id']);
                        $line_user = pg_fetch_assoc($result_user);

                        $results_group = pg_query($db, "SELECT * FROM students_to_groups WHERE student_id=" . $au->getUserId($_SESSION['hash']));
                        $line_group = pg_fetch_assoc($results_group);

                        $results_group_name = pg_query($db, 'SELECT * FROM public."group" WHERE id=' . $line_group['group_id']);
                        $line_group_name = pg_fetch_assoc($results_group_name);

                        ?>
                            <li class="list-group-item"><?= $line_user['first_name'] ?> <?= $line_user['middle_name'] ?> <?= $line_user['last_name'] ?> <strong> Группа: <?= $line_group_name['name']  ?></strong>
                            </li>
                        <?php }
                        ?>

                        </div>
                </div>
            </div>
        <?php
    }
        ?>

        <div class="row justify-content-center">
            <div class="col-auto">
                <div id="titleErr" class="d-none" style="color: red;">
                    Неправильно введен заголовок
                </div>
                <div id="descrErr" class="d-none" style="color: red;">
                    Неправильно введено описание
                </div>
                <div id="fileErr" class="d-none" style="color: red;">

                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <a class="btn btn-primary" id="buttonBack" href="profil.php" role="button">Назад</a>
            </div>
        </div>