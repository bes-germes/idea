function DBBanUser(user_id) {



    $.ajax({
        type: "POST",
        url: 'DBBanUserScript.php',
        data: {
            user_id: user_id
        },
        success: function (data) {
            console.log(data);
        },
    });

}

function DBUnbanUser(user_id) {



    $.ajax({
        type: "POST",
        url: 'DBUnbanUserScript.php',
        data: {
            user_id: user_id
        },
        success: function (data) {
            console.log(data);
        },
    });

}
