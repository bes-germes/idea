function DBaddReq() {


    let title_req = document.getElementById('title_req').value;
    let text_req = document.getElementById('text_req').value;

    if (document.getElementById('titleErr').classList != 'd-none')
        document.getElementById('titleErr').classList.add('d-none');
    if (document.getElementById('descrErr').classList != 'd-none') {
        document.getElementById('descrErr').classList.add('d-none');
    }
    if (document.getElementById('fileErr').classList != 'd-none') {
        document.getElementById('fileErr').classList.add('d-none');
        document.getElementById('fileErr').innerHTML = '';
    }

    if (title_req == "" || /\s|⠀/ .test(title_req[0])) {
        document.getElementById('titleErr').classList.remove('d-none');
        return;
    }
    if (text_req == "" || /\s|⠀/.test(text_req[0])) {
        document.getElementById('descrErr').classList.remove('d-none');
        return;
    }

    if (window.FormData === undefined) {
        alert('В вашем браузере FormData не поддерживается')
    } else {
        var formData = new FormData();
        formData.append('file', $("#formFile")[0].files[0]);
        formData.append('title_req', title_req);
        formData.append('text_req', text_req);

        $.ajax({
            type: "POST",
            url: 'addReqScript.php',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,

            success: function (data) {
                console.log(data);
                if (!data.includes('kryto')) {
                    document.getElementById('fileErr').classList.remove('d-none');
                    $('#fileErr').append(data);
                } else {
                    window.location.href = 'addRequsetSuccesPage.php';
                }

            }
        });
    }

}

