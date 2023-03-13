function DBshowAllIdeas() {

    if (document.getElementById('all').classList.contains('d-none')) {
        document.getElementById('all').classList.remove('d-none');
        document.getElementById('denied').classList.add('d-none');
        document.getElementById('in_progress_ideas').classList.add('d-none');
        document.getElementById('accept_ideas').classList.add('d-none');
    }



}

function DBshowInProgressIdeas() {
    if (document.getElementById('in_progress_ideas').classList.contains('d-none')) {
        document.getElementById('in_progress_ideas').classList.remove('d-none');
        document.getElementById('denied').classList.add('d-none');
        document.getElementById('all').classList.add('d-none');
        document.getElementById('accept_ideas').classList.add('d-none');
    }



}

function DBshowDeniedIdeas() {

    if (document.getElementById('denied').classList.contains('d-none')) {
        document.getElementById('denied').classList.remove('d-none');
        document.getElementById('all').classList.add('d-none');
        document.getElementById('in_progress_ideas').classList.add('d-none');
        document.getElementById('accept_ideas').classList.add('d-none');
        // document.getElementById('denied').style  = "transform: translate(0, -200%);"
    }



}

function DBshowAcceptIdeas() {
    if (document.getElementById('accept_ideas').classList.contains('d-none')) {
        document.getElementById('accept_ideas').classList.remove('d-none');
        document.getElementById('denied').classList.add('d-none');
        document.getElementById('all').classList.add('d-none');
        document.getElementById('in_progress_ideas').classList.add('d-none');
    }




}

function DBshowAdminAllIdeas() {
    if (document.getElementById('all').classList.contains('d-none')) {
        document.getElementById('all').classList.remove('d-none');
        document.getElementById('need_to_check').classList.add('d-none');
        document.getElementById('end_vote_time').classList.add('d-none');
        document.getElementById('end_freetry').classList.add('d-none');
        document.getElementById('banned').classList.add('d-none');
    }




}

function DBshowCheckIdeas() {
    if (document.getElementById('need_to_check').classList.contains('d-none')) {
        document.getElementById('need_to_check').classList.remove('d-none');
        document.getElementById('all').classList.add('d-none');
        document.getElementById('end_vote_time').classList.add('d-none');
        document.getElementById('end_freetry').classList.add('d-none');
        document.getElementById('banned').classList.add('d-none');
    }




}

function DBshowEndVoteIdeas() {
    if (document.getElementById('end_vote_time').classList.contains('d-none')) {
        document.getElementById('end_vote_time').classList.remove('d-none');
        document.getElementById('all').classList.add('d-none');
        document.getElementById('need_to_check').classList.add('d-none');
        document.getElementById('banned').classList.add('d-none');
        document.getElementById('end_freetry').classList.add('d-none');
    }




}

function DBshowEndFreetryIdeas() {
    if (document.getElementById('end_freetry').classList.contains('d-none')) {
        document.getElementById('end_freetry').classList.remove('d-none');
        document.getElementById('need_to_check').classList.add('d-none');
        document.getElementById('banned').classList.add('d-none');
        document.getElementById('end_vote_time').classList.add('d-none');
        document.getElementById('all').classList.add('d-none');
    }




}

function DBshowBannedIdeas() {
    if (document.getElementById('banned').classList.contains('d-none')) {
        document.getElementById('banned').classList.remove('d-none');
        document.getElementById('need_to_check').classList.add('d-none');
        document.getElementById('end_vote_time').classList.add('d-none');
        document.getElementById('end_freetry').classList.add('d-none');
        document.getElementById('all').classList.add('d-none');
    }




}
function DBReturnCurStatus() {
    return document.getElementById('staus').value;

}