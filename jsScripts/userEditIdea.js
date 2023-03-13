function userEditIdea() {

    document.getElementById('cardBodyTitleText').classList.add('d-none');
    document.getElementById('cardBodyTitleTextEdit').classList.remove('d-none');

    let title = document.getElementById('card-title').innerHTML;
    let text = document.getElementById('card-text').innerHTML;

    document.getElementById('title_req').innerHTML = title;
    document.getElementById('text_req').innerHTML = text;

    document.getElementById('buttonEditBack').classList.remove('d-none');
    document.getElementById('buttonEditSave').classList.remove('d-none');
    document.getElementById('buttonEdit').classList.add('d-none');

    // document.getElementById('imageEdit').classList.remove('d-none');
    // document.getElementById('image').classList.add('d-none');

    document.getElementById('formFile').classList.remove('d-none');

}

function userEditIdeaCancel() {

    if (document.getElementById('cardBodyTitleText').classList.contains('d-none')) {
        document.getElementById('cardBodyTitleText').classList.remove('d-none');
        document.getElementById('cardBodyTitleTextEdit').classList.add('d-none');

        document.getElementById('buttonEditBack').classList.add('d-none');
        document.getElementById('buttonEditSave').classList.add('d-none');
        document.getElementById('buttonEdit').classList.remove('d-none');

        document.getElementById('formFile').classList.add('d-none');
        // document.getElementById('imageEdit').classList.add('d-none');
        // document.getElementById('image').classList.remove('d-none');
    }
}

function uplodNewImage() {

    // document.getElementById('formFile').click();

    let f = formFile.files[0];
    if (f) {
        document.getElementById('image').src = URL.createObjectURL(f);
    }
}

function saveEditIdea(idx) {

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

    if (title_req == "" || /\s|⠀/.test(title_req[0])) {
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
        if ($("#formFile")[0].files[0] === undefined) {
            formData.append('oldImg', '.' + document.getElementById('imageEdit').src.split('votesite/votesite')[1]);
        } else {
            formData.append('file', $("#formFile")[0].files[0]);
        }
        formData.append('title_req', title_req);
        formData.append('text_req', text_req);
        formData.append('postId', idx);

        $.ajax({
            type: "POST",
            url: 'updateReqScript.php',
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
                    window.location.href = 'profil.php';
                }

            }
        });
    }

}