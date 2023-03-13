<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                <h1 class="fw-light">Вход</h1>
            </div>
        </div>
    </section>



    <div class="container">
         <form id="checkLog" action="../auth/action.php" enctype="multipart/form-data" name="login" method="POST"><!-- здесь поменять auth.php на action.php -->
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Логин" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Пароль" aria-label="Password" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <button class="btn btn-primary" id="submit-btn" type="submit">Войти</button>
                    <input type="hidden" name="action" value="login">
                </div>
            </div>
        </form>
    </div>



</body>

</html>