function acceptIdea() {

    if (document.getElementById('acceptIdea').classList.contains('d-none')) {
        document.getElementById('acceptIdea').classList.remove('d-none');
    } else {
        document.getElementById('acceptIdea').classList.add('d-none');

    }
    console.log(document.getElementById('end_vote_field').valueAsNumber);

}

function fillInputByTag(idx, postID) {

    document.getElementById('create_new_tag').value = document.getElementById('existTag' + idx).innerText;
    document.getElementById('taqQuestionBtn').value = 1;


}

function createNewTag() {

    if (document.getElementById('create_new_tag').value.includes(' ') || document.getElementById('create_new_tag').value == '') {
        document.getElementById('tagErrEmpty').classList.remove('d-none');
        return 0;
    }

    if (document.getElementById('taqQuestionBtn').value == 0) {
        document.getElementById('taqQuestionBtn').value = 1;
        document.getElementById('tagInput').value = 1;
        document.getElementById('taqQuestionBtn').innerText = "Убрать новый тег?";
        document.getElementById('tagErr').classList.add('d-none');
        document.getElementById('acceptTag').classList.remove('d-none');
        document.getElementById('denyTag').classList.add('d-none');
        document.getElementById('tagErrEmpty').classList.add('d-none');
    } else {
        document.getElementById('taqQuestionBtn').value = 0;
        document.getElementById('tagInput').value = 0;
        document.getElementById('taqQuestionBtn').innerText = "Добавить новый тег?";
        document.getElementById('tagErr').classList.remove('d-none');
        document.getElementById('acceptTag').classList.add('d-none');
        document.getElementById('denyTag').classList.remove('d-none');
    }

}

function updateIdea(postID, status) {

    if (!document.getElementById('denyErr').classList.contains('d-none') || !document.getElementById('acceptErr').classList.contains('d-none') || !document.getElementById('timeErr').classList.contains('d-none') || !document.getElementById('tagErrEmpty').classList.contains('d-none')) {
        document.getElementById('denyErr').classList.add('d-none');
        document.getElementById('acceptErr').classList.add('d-none');
        document.getElementById('timeErr').classList.add('d-none');
        document.getElementById('tagErrEmpty').classList.add('d-none');
    }


    let vote_start = document.getElementById('start_vote_field').value;
    let vote_finish = document.getElementById('end_vote_field').value;

    if (document.getElementById('taqQuestionBtn') == null && (status == 7 || status == 8)) {

        $.ajax({
            type: "POST",
            url: 'adminUpdatePostScripd.php',
            data: {
                idPost: postID,
                status: status,
                vote_start: vote_start,
                vote_finish: vote_finish
            },
            success: function (data) {
                console.log(data);

                if (status == 8) {
                    document.getElementById('denyErr').classList.remove('d-none');
                }
                if (status == 7) {
                    document.getElementById('acceptErr').classList.remove('d-none');
                }

            },
        });
    }


    if (status == 9) {
        vote_start = "";
        vote_finish = "";
        document.getElementById('taqQuestionBtn').value = 1;
    }

    if (document.getElementById('taqQuestionBtn').value == 0 && status != 9) {
        $.ajax({
            type: "POST",
            url: 'tagsFilterScript.php',
            data: {
                tagValue: document.getElementById('create_new_tag').value,

            },
            success: function (data) {
                console.log(data);

                if (data == '' && document.getElementById('tagQuetion').classList.contains('d-none')) {
                    document.getElementById('tagQuetion').classList.remove('d-none');
                    return 0;
                }
                if (document.getElementById('tagInput').value == 0 && document.getElementById('tagErr').classList.contains('d-none')) {
                    document.getElementById('tagErr').classList.remove('d-none');
                    return 0;
                } else {
                    document.getElementById('tagErr').classList.add('d-none');
                }
            },
        });
    } else {

        if (vote_start > vote_finish || vote_start == '' || vote_finish == '' || Date.parse(vote_start) <= Date.parse(new Date()) || Date.parse(new Date()) > Date.parse(vote_finish)) {
            document.getElementById('timeErr').classList.remove('d-none');
            return 0;
        }

        let tag_name = document.getElementById('create_new_tag').value;

        if (String(tag_name).length > 24 || /\s|⠀/.test(tag_name[0])) {
            document.getElementById('tagErrEmpty').classList.remove('d-none');
            return 0;
        }

        if (document.getElementById('create_new_tag').value.includes(' ') || document.getElementById('create_new_tag').value == '') {
            document.getElementById('tagErrEmpty').classList.remove('d-none');
            return 0;
        }

        $.ajax({
            type: "POST",
            url: 'adminUpdatePostScripd.php',
            data: {
                idPost: postID,
                status: status,
                vote_start: vote_start,
                vote_finish: vote_finish
            },
            success: function (data) {
                console.log(data);

                if (status == 9 || status == 5) {
                    document.getElementById('denyErr').classList.remove('d-none');
                }
                if (status == 3 || status == 7) {
                    document.getElementById('acceptErr').classList.remove('d-none');
                    document.getElementById('acceptErr').focus();

                    let tagValue = document.getElementById('create_new_tag').value;/// ajax в ajax мне не особо нравится, но я ничего не придумал
                    $.ajax({
                        type: "POST",
                        url: 'tagsAddScript.php',
                        data: {
                            postID: postID,
                            tagValue: tagValue

                        },
                        success: function (data) {
                            console.log(data);



                        },
                    });

                }

            },
        });
    }







}




