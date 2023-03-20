<?php
session_start();
include_once('../auth/auth_ssh.class.php');
$au = new auth_ssh();

if (!$au->isAdmin($_SESSION['role'])) {
    http_response_code(401);
    header('Location:index.php');
    exit;
}

if (isset($_POST['postId'])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
        <!-- подключаем библиотеку -->
        <script type="text/javascript" src="https://unpkg.com/popper.js"></script>
        <!-- подключаем универсальный скрипт, который использует API propper.js для упрощенного использование подсказок -->
        <script type="text/javascript" src="https://unpkg.com/tooltip.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="../idea/jsScripts/wantToBeExuterShowSucces.js"></script>
        <script src="../idea/jsScripts/adminAcceptDeniedIdea.js"></script>
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
                    <h4>Здесь вы можете делать что захотите</h5>
                </div>
            </div>
        </section>



        <?php

        include_once('config\dbFunc.class.php');

        $db = new dbFunc();

        $db = $db->dbConn();


        $result = pg_query($db, "SELECT * FROM inc_idea WHERE id = " . $_POST['postId']);
        $line = pg_fetch_assoc($result);

        $result_executers = pg_query($db, "SELECT * FROM public.inc_executors WHERE idea_id =" . $_POST['postId'] . " and role = 3;");

        $likes = 0;
        $dislikes = 0;
        $query_count_vote = 'SELECT * FROM inc_idea_vote WHERE inc_idea_vote.idea_id=' . $line['id'];
        $result_count_vote = pg_query($db, $query_count_vote) or die('Ошибка запроса: ' . pg_last_error());

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
                        <div style="width: 100%;height: 40vh;object-fit: cover;">
                            <img class="card-img-top" style="width: 100%;height: 40vh;object-fit: cover;" src="<?= $link_image ?>" alt="Card image cap">

                        </div>

                        <div class="card-body" style="width: 100%;">
                            <h5 class="card-title"><?= $line['title'] ?></h5>
                            <p class="card-text"><?= $line['description'] ?></p>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($line['status'] == 1) {



            $tags_array = array();
            $result_tag = pg_query($db, 'SELECT tag FROM public.inc_idea_tag;');
            while ($line_tag = pg_fetch_assoc($result_tag)) {
                array_push($tags_array, $line_tag['tag']);
            }

            $distinct = array_unique($tags_array);

        ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" onclick="acceptIdea()">Принять</button>
                    </div>
                    <div class="col-auto">

                        <button type="button" class="btn btn-primary mb-3" onclick="updateIdea(<?= $_POST['postId'] ?>, 9)">Отклонить</button>

                    </div>
                </div>

                <div class="row justify-content-center d-none" id="acceptIdea" style="margin-top: 2rem;">

                    <div class="row justify-content-center">
                        <div class="input-group mb-3" style="width: 300px;">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Теги</button>
                            <ul class="dropdown-menu">
                                <?php
                                $tag_id = 0;
                                foreach ($distinct as $oldTag) {
                                ?>
                                    <li><a class="dropdown-item" max_w id="existTag<?= $tag_id ?>" onclick="fillInputByTag(<?= $tag_id++ ?>, <?= $_POST['postId'] ?>)" href="#"><?= $oldTag ?></a></li>

                                <?php
                                } ?>
                            </ul>
                            <input type="text" placeholder="Создать новый" id="create_new_tag" class="form-control" aria-label="Text input with dropdown button">
                        </div>
                        <div class="col-auto d-none" id="tagQuetion">

                            <button type="button" class="btn btn-primary mb-3" value="0" id="taqQuestionBtn" onclick="createNewTag()">Добавить новый тег?</button>
                        </div>
                        <div id="denyTag" class="d-none" style="color: red;">
                            Тег убран
                        </div>
                        <div id="acceptTag" class="d-none" style="color: green;">
                            Новый тег добавлен
                        </div>
                    </div>


                    <div class="col-auto">
                        <label for="staticEmail" class="form-control-plaintext">Дата начала голосования</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" id="start_vote_field" name="trip-start">
                    </div>

                    <div class='col-auto'>
                        <input type="date" class="form-control" id="end_vote_field" name="trip-start">
                    </div>

                    <div class="col-auto">

                        <button type="button" class="btn btn-primary mb-3" onclick="updateIdea(<?= $_POST['postId'] ?>, 3)">Опубликовать</button>
                    </div>

                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div id="denyErr" class="d-none" style="color: red;">
                            Заявка отклонена
                        </div>
                        <div id="acceptErr" class="d-none" style="color: green;">
                            Заявка принята
                        </div>
                        <div id="timeErr" class="d-none" style="color: red;">
                            Неправильно поставлен срок голосования
                        </div>
                        <div id="tagErr" class="d-none" style="color: red;">
                            Вы не добавлили новый тег
                        </div>
                        <div id="tagErrEmpty" class="d-none" style="color: red;">
                            Поле с тегом содержит пробел или оно пустое или тег слишком длинный
                        </div>
                        <input id="tagInput" type="hidden" value="0">
                    </div>
                </div>
            </div>
        <?php
        }
        if ($line['status'] == 3) {
        ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <p> Идёт голосование </p>
                        <p> Осталось: <?= round((strtotime($line['vote_finish']) - strtotime(date('d.m.Y H:i:s'))) / 86400) ?> дней</p>
                    </div>
                </div>
            </div>
        <?php
        }
        if ($line['status'] == 4) {
        ?>
            <div class="container" name="settings">

                <div class="row justify-content-center" id="acceptIdea" style="margin-top: 2rem;">

                    <div class="col-auto">
                        <label for="staticEmail" class="form-control-plaintext">Дата начала испонения</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" id="start_freetry_field" name="trip-start">
                    </div>

                    <div class='col-auto'>
                        <input type="date" class="form-control" id="end_freetry_field" name="trip-start">
                    </div>

                </div>
                <div class="row justify-content-center" style="margin-top: 1rem;">
                    <div class="col-4">
                        <h6>Список желающих</h6>
                        <ul class="list-group" id="student_list">
                            <?php
                            $cur_id = 0;

                            while ($line_executers = pg_fetch_array($result_executers, null, PGSQL_ASSOC)) {
                                $result_user = pg_query($db, "SELECT * FROM public.students WHERE id = " . $line_executers['user_id']);
                                $line_user = pg_fetch_assoc($result_user);

                                if ($line['author'] == $line_executers['user_id']) {
                                    $is_leader = " list-group-item-primary";
                                    $is_leader_status = "Предложил заявку";
                                } else {
                                    $is_leader = "";
                                    $is_leader_status = "";
                                }

                            ?>
                                <li id="exuters_list<?= $cur_id ?>" class="list-group-item<?= $is_leader ?>"><?= $line_user['first_name'] ?> <?= $line_user['middle_name'] ?> <?= $line_user['last_name'] ?> <?= $is_leader_status ?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check form-switch">

                                                <input class="form-check-input" type="checkbox" name="form-check-input" value="<?= $line_executers['user_id'] ?>" id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">В команду</label>
                                            </div>
                                            <div class="form-check form-switch">

                                                <input class="form-check-input" type="checkbox" name="form-check-input-leader" value="<?= $line_executers['user_id'] ?>" id="flexSwitchCheckDefaultLeader<?= $cur_id ?>" onchange="addExecuterLeader(<?= $cur_id ?>)">
                                                <label class="form-check-label" for="flexSwitchCheckDefaultLeader">Сделать лидером</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeExecuter(<?= $cur_id ?>, <?= $line_executers['user_id'] ?>)">Удалить</button>
                                        </div>
                                    </div>
                                </li>

                            <?php
                                $cur_id++;
                            } ?>

                        </ul>
                        <select class="form-select" aria-label="Default select example" onchange="findExecuterByGroup()">
                            <option selected>Выберите группу</option>
                            <?php $result_groups = pg_query($db, 'SELECT name, id FROM public."group";');
                            while ($line_groups = pg_fetch_array($result_groups, null, PGSQL_ASSOC)) {

                            ?>

                                <option id="option_select<?= $line_groups['id'] ?>" value="<?= $line_groups['id'] ?>"><?= $line_groups['name'] ?></option>
                            <?php } ?>
                        </select>
                        <div id="add_div_student" hidden style="margin-top: 1rem;">
                            <div class="w-100">
                                <h6>Добавить участника</h6>
                                <ul class="list-group" id="student_add_list" style="overflow-y: scroll; max-height: 120px;">
                                </ul>
                            </div>
                            <div class="row justify-content-center" style="margin-top: 1rem;">
                                <div class="col-4">
                                    <button type="button" class="btn btn-primary" onclick="addfoundedexecuterByGroup()">Добавить</button>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 1rem;">
                            <div class="col-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefaultAll" onchange="chooseAll()">
                                    <label class="form-check-label" for="flexSwitchCheckDefaultAll">Выбрать всех</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" id="acceptIdea" style="margin-top: 1rem;">
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-3" onclick="addExecuters(<?= $_POST['postId'] ?>)">Опубликовать</button>
                            <input hidden id="post_id" value="<?= $_POST['postId'] ?>">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div id="denyErr" class="d-none" style="color: red;">
                            Не выбраны исполнители
                        </div>
                        <div id="acceptErr" class="d-none" style="color: green;">
                            Началось исполнение идеи
                        </div>
                        <div id="timeErr" class="d-none" style="color: red;">
                            Неправильно поставлен срок голосования
                        </div>
                        <div id="leaderErr" class="d-none" style="color: red;">
                            Не выбран лидер
                        </div>
                    </div>

                </div>
            </div>

        <?php
        }
        if ($line['status'] == 5) { ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        Не прошла голосование
                    </div>
                </div>
            </div>
        <?php }
        if ($line['status'] == 6) {

            $idea_date_start_freetry = date('Y.m.d', strtotime($line['freetry_start']));
            $idea_date_finish_freetry = date('Y.m.d', strtotime($line['freetry_finish']));
            $idea_date_start_vote = date('Y.m.d', strtotime($line['vote_start']));
            $body_date_finish_vote = date('Y.m.d', strtotime($line['vote_finish']));
            $body_date_start_freetry = str_replace('.', "-", $idea_date_start_freetry);
            $body_date_finish_freetry = str_replace('.', "-", $idea_date_finish_freetry);
            $body_date_start_vote = str_replace('.', "-", $idea_date_start_vote);
            $body_date_finish_vote = str_replace('.', "-", $body_date_finish_vote);
        ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <p> Исполняется идея </p>
                        <p> Осталось: <?= round((strtotime($line['freetry_finish']) - strtotime(date('d.m.Y H:i:s'))) / 86400) ?> дней для исполнения</p>
                    </div>

                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <h5> Дата начала и конца голосования</h5>
                    </div>

                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <input type="date" class="form-control" value="<?= $body_date_start_vote ?>" id="start_vote_field" name="trip-start" disabled>
                    </div>

                    <div class='col-auto'>
                        <input type="date" class="form-control" value="<?= $body_date_finish_vote ?>" id="end_vote_field" name="trip-start" disabled>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <h5> Дата начала и конца исполнения</h5>
                    </div>

                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <input type="date" class="form-control" value="<?= $body_date_start_freetry ?>" id="start_freetry_field" name="trip-start" disabled>
                    </div>

                    <div class='col-auto'>
                        <input type="date" class="form-control" value="<?= $body_date_finish_freetry ?>" id="end_freetry_field" name="trip-start" disabled>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">

                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top: 1rem;">
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" onclick="updateIdea(<?= $_POST['postId'] ?>, 7)">Выполнена</button>
                    </div>
                    <div class="col-auto">

                        <button type="button" class="btn btn-primary mb-3" onclick="updateIdea(<?= $_POST['postId'] ?>, 8)">Не выполнена</button>

                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div id="denyErr" class="d-none" style="color: red;">
                            Заявка отклонена
                        </div>
                        <div id="acceptErr" class="d-none" style="color: green;">
                            Заявка принята
                        </div>
                        <div id="timeErr" class="d-none" style="color: red;">
                            Неправильно поставлен срок голосования
                        </div>
                        <div id="create_new_tag" class="d-none" style="color: green;">
                            Заявка принята
                        </div>
                        <div id="tagQuetion" class="d-none" style="color: red;">
                            Неправильно поставлен срок голосования
                        </div>
                        <div id="tagErrEmpty" class="d-none" style="color: red;">
                            Поле с тегом содержит пробел или оно пустое или тег слишком длинный
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-auto">
            <a class="btn btn-primary" id="buttonBack" href="adminProfil.php" role="button">Назад</a>
        </div>
    </div>