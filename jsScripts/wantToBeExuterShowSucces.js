function wantToBeExuterShowSucces(action) {



    $.ajax({
        type: "POST",
        url: 'wantToBeExuterScript.php',
        data: {
            postId: action
        },
        success: function (data) {
            console.log(data);
            if (data == "Вы уже оставили заявку") {

                if (document.getElementById('errExecutor').classList.contains('d-none')) {
                    document.getElementById('errExecutor').classList.remove('d-none');
                } else {
                    document.getElementById('errExecutor').classList.add('d-none');

                }
            } else {
                if (document.getElementById('succes').classList.contains('d-none')) {
                    document.getElementById('succes').classList.remove('d-none');
                    document.getElementById('acceptCancelbuttons').classList.add('d-none');
                } else {
                    document.getElementById('succes').classList.add('d-none');

                }
            }
        },
    });

}

function chooseAll() {

    var inputElements = document.getElementsByName('form-check-input');

    if (document.getElementById('flexSwitchCheckDefaultAll').checked) {
        for (var i = 0; inputElements[i]; ++i) {
            inputElements[i].checked = true;
            inputElements[i].setAttribute('disabled', '');
        }
    } else {
        for (var i = 0; inputElements[i]; ++i) {
            inputElements[i].checked = false;
            inputElements[i].removeAttribute('disabled');
        }
    }



}


function addExecuters(action) {

    let result = [];
    let leaderErr = false;
    var inputElements = document.getElementsByName('form-check-input');
    for (var i = 0; inputElements[i]; ++i) {
        if (inputElements[i].checked) {
            if (document.getElementById('flexSwitchCheckDefaultLeader' + i).checked) {
                user = {
                    hash: inputElements[i].value,
                    role: '2'
                }
                leaderErr = true;
                result.push(user);
            } else {
                user = {
                    hash: inputElements[i].value,
                    role: '1'
                }
                result.push(user);
            }
        }
    }
    // let arrLeader = [];
    // var inputElementsLeader = document.getElementsByName('form-check-input-leader');
    // for (var i = 0; inputElementsLeader[i]; ++i) {
    //     if (inputElementsLeader[i].checked) {
    //         user = {
    //             hash: '',
    //             role: '2'
    //         }
    //         user.hash 
    //          = inputElementsLeader[i].value;
    //     }
    // }

    if (!leaderErr) {
        document.getElementById('leaderErr').classList.remove('d-none');
        return;
    }

    if (result.length <= 0) {

        document.getElementById('denyErr').classList.remove('d-none');
        return;
    }

    if (!document.getElementById('denyErr').classList.contains('d-none') || !document.getElementById('leaderErr').classList.contains('d-none') || !document.getElementById('timeErr').classList.contains('d-none')) {
        document.getElementById('denyErr').classList.add('d-none');
        document.getElementById('leaderErr').classList.add('d-none');
        document.getElementById('timeErr').classList.add('d-none');
    }




    let freetry_start = document.getElementById('start_freetry_field').value;
    let freetry_finish = document.getElementById('end_freetry_field').value;

    if (freetry_start > freetry_finish || freetry_start == '' || freetry_finish == '' ||  Date.parse(freetry_start) <= Date.parse(new Date()) ||  Date.parse(new Date()) > Date.parse(freetry_finish)) {
        document.getElementById('timeErr').classList.remove('d-none');
        return 0;
    }

    $.ajax({
        type: "POST",
        url: 'wantToBeExuterScript.php',
        data: {
            postId: action,
            arr: result,
            freetry_start: freetry_start,
            freetry_finish: freetry_finish

        },
        success: function (data) {
            console.log(data);

            if (document.getElementById('acceptErr').classList.contains('d-none')) {
                document.getElementById('acceptErr').classList.remove('d-none');
            } else {
                document.getElementById('acceptErr').classList.add('d-none');

            }

            if (!document.getElementById('timeErr').classList.contains('d-none')){
                document.getElementById('acceptErr').classList.add('d-none');
            }
        },
    });

}


function addExecuterLeader(idx) {

    var inputElements = document.getElementsByName('form-check-input-leader');

    for (var i = 0; inputElements[i]; ++i) {
        if (i == idx) {
            document.getElementById('flexSwitchCheckDefaultLeader' + i).checked = true;
        } else {
            document.getElementById('flexSwitchCheckDefaultLeader' + i).checked = false;
        }
    }

}

function findExecuterByGroup() {


    var group = $('.form-select option:selected').val();


    let element = document.getElementById("add_div_student");
    let hidden = element.getAttribute("hidden");


    if (!hidden) {
        element.setAttribute("hidden", "hidden");
    }


    if (group == 'Выберите группу') {
        return 0;
    }
    // let group = document.getElementById('group_name_input').value;

    let inputElements = document.getElementsByName('form-check-input-leader');

    let existIndx = [];

    inputElements.forEach(element => {
        existIndx.push(element.value);
    });

    $.ajax({
        type: "POST",
        url: 'adminFindExecuterByGroupScript.php',
        data: {
            group: group,
            existIndx: existIndx
        },
        success: function (data) {
            // console.log(data);
            $("#student_add_list").html('');
            $("#student_add_list").append(data);
            if (!data == '') {
                document.getElementById('add_div_student').removeAttribute('hidden');
            }



        },
    });

}

function addfoundedexecuterByGroup() {
    var inputElements = document.getElementsByName('form-check-input-add');


    inputElements.forEach(element => {
        if (element.checked) {
            let id_student = element.value;
            $.ajax({
                type: "POST",
                url: 'adminFindExecuterById.php',
                data: {
                    id_student: id_student,
                },
                success: function (data) {
                    let id_idx = document.getElementsByName('form-check-input-leader');
                    $('#student_list').append("<li id='exuters_list" + id_idx.length + "' class='list-group-item'>" + data + "<div class='row'><div class='col'><div class='form-check form-switch'><input class='form-check-input' type='checkbox' name='form-check-input' value='" + id_student + "' id='flexSwitchCheckDefault'><label class='form-check-label' for='flexSwitchCheckDefault'>В команду</label></div><div class='form-check form-switch'><input class='form-check-input' type='checkbox' name='form-check-input-leader' value='" + id_student + "' id='flexSwitchCheckDefaultLeader" + id_idx.length + "' onchange='addExecuterLeader(" + id_idx.length + ")'><label class='form-check-label' for='flexSwitchCheckDefaultLeader'>Сделать лидером</label></div></div><div class='col'><button type='button' class='btn btn-danger btn-sm' onclick='removeExecuter(" + id_idx.length + ", " + id_student + ")'>Удалить</button></div></div></li>");
                    document.getElementById("add_student_id" + element.id).remove();
                    console.log(document.getElementById('post_id').value);
                    DBinsetExecutor(document.getElementById('post_id').value, id_students, 3);
                    reoderIndexes();
                },
            });

        }
    });
}

function reoderIndexes() {
    let leader_switchers = document.getElementsByName('form-check-input-leader');

    for (var i = 0; i < leader_switchers.length; i++){

        leader_switchers[i].removeAttribute('onchange');
        leader_switchers[i].id = 'flexSwitchCheckDefaultLeader' + i;
        leader_switchers[i].setAttribute("onchange", "addExecuterLeader(" + i + ")");
    }

}

function removeExecuter(idx, id_students) {

    document.getElementById("exuters_list" + idx).remove();

    DBinsetExecutor(document.getElementById('post_id').value, id_students, 0);
    findExecuterByGroup();
}

function DBinsetExecutor(postID, user_id, role) {

    $.ajax({
        type: "POST",
        url: 'adminAddDeleteExecuter.php',
        data: {
            postID: postID,
            user_id: user_id,
            role: role
        },
        success: function (data) {
            console.log(data);
        },
    });

}