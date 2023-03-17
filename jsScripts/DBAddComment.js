function DBAddComment(idx, author_firstname, author_midlename, author_lastname, author_userid, author_login) {
    let comment = document.getElementById('commentInputArea' + idx).value;//TRUNCATE TABLE inc_comment RESTART IDENTITY CASCADE
    if (comment == "") {
        document.getElementById('commentErr' + idx).classList.remove('d-none');
        return;
    }
    if (document.getElementById('commentErr' + idx).classList != 'd-none')
        document.getElementById('commentErr' + idx).classList.add('d-none');
    document.getElementById("commentInputArea" + idx).value = "";

    var formData = new FormData();
    formData.append('first_name', author_firstname);
    formData.append('midle_name', author_midlename);
    formData.append('last_name', author_lastname);
    formData.append('user_id', author_userid);
    formData.append('login', author_login);
    formData.append('com', comment);
    formData.append('idPost', idx);
    $.ajax({
        type: "POST",
        url: 'pushCommentScript.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (data) {
            let ComIdx = data;
            var today = new Date();
            var now = today.toLocaleString();
            $('#commnet_container' + idx).append(" <div class='comment_body' id='comment_body" + ComIdx + "'><div class='main_com' id='main_com" + ComIdx + "'><div class='comment_head'>" + author_firstname + ' ' + author_midlename + "</div><div class='comment_inner text-break display: inline-block; width:100px; height:50px;'>" + comment + "</div><div class='comment_time'>" + now + "</div></div><button type='button' id='rpy_btn" + ComIdx + "' value='" + ComIdx + "' class='btn' style='max-width: 100px; color: black; background-color: white; font-size: 13px; ' onclick='DBAnwerToComment(" + ComIdx + ", " + idx + "," + '"' + author_firstname + '","' + author_midlename + '"' + "," + '"' + author_lastname + '",' + author_userid + ',"' + author_login + '"' + ")'>Ответить</button><div class='d-none' id='comment_reply" + ComIdx + "' style='flex-direction: column;display: flex;padding: 10px;margin-right: 65px;margin-left: 60px;'></div></div>");



        },
    });
}

// function GetCurBDCommCount(idx) {
//     var res = '';
//     $.ajax({
//         async: false,
//         type: "POST",
//         url: 'getBDComCount.php',
//         data: {
//             idPost: idx
//         },
//         success: function (data) {
//             console.log(data);
//             res = data;
//         },
//     });
//     return res;
// }

function DBAddAnswerComment(idx, ComIdx, author_firstname, author_midlename, author_lastname, author_userid, author_login) {
    let comment = document.getElementById('answerInputArea' + idx).value;
    if (comment == "") {
        document.getElementById('commentErr' + idx).classList.remove('d-none');
        return;
    }
    if (document.getElementById('commentErr' + idx).classList != 'd-none')
        document.getElementById('commentErr' + idx).classList.add('d-none');
    document.getElementById("answerInputArea" + idx).value = "";

    var formData = new FormData();
    formData.append('first_name', author_firstname);
    formData.append('midle_name', author_midlename);
    formData.append('last_name', author_lastname);
    formData.append('user_id', author_userid);
    formData.append('login', author_login);
    formData.append('com', comment);
    formData.append('idPost', idx);
    formData.append('ComIdx', ComIdx);

    $.ajax({
        type: "POST",
        url: 'pushCommentScript.php',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (data) {
            console.log(data);
            var today = new Date();
            var now = today.toLocaleString();
            $('#comment_reply' + ComIdx).append("<div class='comment_head'>Вы</div><div class='comment_inner text-break display: inline-block; width:100px; height:50px;'>" + comment + "</div ><div class='comment_time'>" + now + "<button type = 'button' id = 'answer_btn" + ComIdx + "' value = '" + ComIdx + "' class= 'btn' style = 'max-width: 100px; color: black; background-color: white; font-size: 13px;' onclick = 'DBAnwerToComment(" + ComIdx + ", " + idx + "," + '"' + author_firstname + '","' + author_midlename + '"' + "," + '"' + author_lastname + '",' + author_userid + ',"' + author_login + '"' + ")'> Ответить </button></div>");

            if (document.getElementById('comment_reply' + ComIdx).classList == 'd-none')
                document.getElementById('comment_reply' + ComIdx).classList.remove('d-none');
            document.getElementById('rpy_btn' + ComIdx).textContent = "Скрыть";
            document.getElementById('rpy_btn' + ComIdx).setAttribute('onclick', 'DBShowReply(' + ComIdx + ',' + idx + ')');


            let addAnswerBtn = document.getElementById('main_com' + ComIdx);
            if (!addAnswerBtn.contains(document.getElementById('answer_btn' + ComIdx))) {
                $(addAnswerBtn).append("<button type = 'button' id = 'answer_btn" + ComIdx + "' value = '" + ComIdx + "' class= 'btn' style = 'max-width: 100px; color: black; background-color: white; font-size: 13px;' onclick = 'DBAnwerToComment(" + ComIdx + ", " + idx + "," + '"' + author_firstname + '","' + author_midlename + '"' + "," + '"' + author_lastname + '",' + author_userid + ',"' + author_login + '"' + ")'> Ответить </button>");
            }
        },
    });
}

function DBDeleteComment(ComIdx) {

    $.ajax({
        type: "POST",
        url: 'adminDeleteComments.php',
        data: {
            idCom: ComIdx,
        },
        success: function (data) {
            console.log(data);

        },
    });


}