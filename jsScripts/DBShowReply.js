function DBShowReply(commId, idx) {

    if (document.getElementById('rpy_btn' + commId).textContent == "Развернуть") {
        document.getElementById('rpy_btn' + commId).textContent = "Скрыть";
        document.getElementById('comment_reply' + commId).classList.remove('d-none');
    } else {
        document.getElementById('comment_reply' + commId).classList.add('d-none');
        document.getElementById('rpy_btn' + commId).textContent = "Развернуть";
        return 0;
    }

}


// function DBHideReply(commId) {

//     document.getElementById('comment_reply' + commId).remove();
//     $('#comment_body' + commId).append('<div class="comment_reply' + commId + '" id="comment_reply' + commId + '"></div>');

// }

function DBAnwerToComment(commId, idx, user_firstname, user_midlename, user_lastname, user_userid, user_login, author_firstname, author_middlename) {


    let commentArea = document.getElementById("commentInputArea" + idx);
    let answerArea = document.getElementById("answerInputArea" + idx);

    let commentStyles = commentArea.style;
    let answerStyles = answerArea.style;

    answerStyles.display = '';
    commentStyles.display = 'none';
    

    answerArea.value = author_firstname + " " + author_middlename + ", ";
    document.getElementById("commentInputDiv" + idx).remove();

    $("#input-group" + idx).append('<div class="input-group-append" id="commentInputAnswerDiv' + idx + '"><button type="button" class="btn" id="commentInputAnswerBtn' + idx + '" style="display: flex;flex-direction: column;" type="" onclick="DBAddAnswerComment(' + idx + ',' + commId + ", " + "'" + user_firstname + "'," + "'" + user_midlename + "'," + "'" + user_lastname + "'," + "'" + user_userid + "'," + "'" + user_login + "'" + ')"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" /></svg></button><button type="button" id="cansel_btn' + idx + '" value="' + idx + '" class="btn" style="max-width: 100px; color: black; background-color: white; font-size: 13px;">Отмена</button></div>');

    answerArea.focus();

    let answer_btn = document.getElementById("cansel_btn" + idx);
  
    answer_btn.addEventListener('click', () => closeTextarea(idx, user_firstname, user_midlename, user_lastname, user_userid, user_login))

}


function closeTextarea(idx, user_firstname, user_midlename, user_lastname, user_userid, user_login) {
    document.getElementById("commentInputAnswerDiv" + idx).remove();
    // let comment = document.getElementById('commentInputArea').value;
    // $("#comment_reply" + idx).append();
    $("#input-group" + idx).append('<div class="input-group-append" id="commentInputDiv' + idx + '"><button type="button" class="btn" id="commentInputBtn' + idx + '" style="" type="" onclick="DBAddComment(' + idx + ", " + "'" + user_firstname + "'," + "'" + user_midlename + "'," + "'" + user_lastname + "'," + "'" + user_userid + "'," + "'" + user_login + "'" + ')"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" /></svg></button></div>');
    let commentArea = document.getElementById("commentInputArea" + idx);
    let answerArea = document.getElementById("answerInputArea" + idx);

    let commentStyles = commentArea.style;
    let answerStyles = answerArea.style;

    answerStyles.display = 'none';
    commentStyles.display = '';
}
