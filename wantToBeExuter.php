<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="../idea/jsScripts/wantToBeExuterShowSucces.js"></script>
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
                <h2 class="fw-light">Подать заявку и стать одним из исполнителем идеи</h2>
            </div>
        </div>
    </section>



    <div class="container">

        <div class="row justify-content-center">
            <div class="col-auto">
                <p>На этом сайте вы можете не только предлогать свои идеи и голосавть за другие, но и стать их исполнителем. А именно вступить в команду единомышленников. Все что вам надо, это нажать на кнопку
                    ниже, а затем в своём личном кабинете отслеживать её статус.
                </p>
            </div>
        </div>
        <div class="row justify-content-center" id="acceptCancelbuttons" style="margin-top: 1rem;">
            <div class="col-auto">
                <button class="btn btn-primary" id="submit-btn" type="submit" onclick="wantToBeExuterShowSucces(<?= $_POST['action']?>)">Подать заявку</button>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" href="index.php">Отмена</a>
            </div>
        </div>
        <div id="succes" class="d-none">
            <div class="row justify-content-center" style="margin-top: 1rem;">
                <div class="col-auto">

                    <a class="btn btn-primary" href="profil.php">Перейти в личный кабинет</a>
                </div>
            </div>
            <div class="row justify-content-center" style="margin-top: 1rem;">
                <div class="col-auto">
                    <p style="color: green;">Ваша заявка отправлена!</p>
                </div>
            </div>
        </div>
        <div id="errExecutor" class="d-none">
        <div class="row justify-content-center" style="margin-top: 1rem;">
                <div class="col-auto">
                    <p style="color: red;">Вы уже оставили заявку!</p>
                </div>
            </div>
        </div>

    </div>



</body>

</html>