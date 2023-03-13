<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
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

    <div id='reqSuggest'>

        <section class="text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Предложить идею</h1>
                </div>
            </div>
        </section>



        <div class="container">
            <div class="row justify-content-center">
                <div class="col">


                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Заголовок" aria-label="Заголовок" maxlength="23" name="title_req" id="title_req" aria-describedby="basic-addon1" required>
                    </div>

                    <div class="input-group mb-3">
                        <textarea name="text_req" class="form-control" placeholder="Предложить идею" aria-label="Предложить идею" id="text_req" style="resize: none; height: 50vh" required></textarea>
                    </div>

                    <div class="w-100" id="w-100"></div>
                    <div id="titleErr" class="d-none" style="color: red;">
                        Неправильно введен заголовок
                    </div>
                    <div id="descrErr" class="d-none" style="color: red;">
                        Неправильно введено описание
                    </div>
                    <div id="fileErr" class="d-none" style="color: red;">

                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="input-group">


                                <div class="mb-3 d-flex flex-column">
                                    <label for="formFile" class="form-label">Выберите изoбражение для идеи</label>
                                    <div class="mb-3" style="display:flex; justify-content: space-between;">
                                        <input class="form-control" type="file" name="file" id="formFile" accept=".jpg, .jpeg, .png" required>
                                        <button class="btn btn-outline-secondary" id="submit-btn" onclick="DBaddReq()">Отправить</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div hidden id="reqAnswer">
        <section class="text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Идея отправлена</h1>
                </div>
            </div>
        </section>



        <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <a class="btn btn-primary" href="index.php" role="button">Супер!</a>
                </div>
            </div>

        </div>

    </div>



</body>

</html>