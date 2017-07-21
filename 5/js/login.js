function checkMailExist(str) {
    if (str.length == 0) {
        document.getElementById("emailMsg").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "exist") {
                    document.getElementById("emailMsg").innerHTML = "";
                } else {
                    document.getElementById("emailMsg").innerHTML = "not found";
                }
                // console.log("checkMailExist:" + this.responseText);
            }
        }
        xmlhttp.open("GET", "../5-0-1/php/checkMailExist.php?email=" + str, true);
        xmlhttp.send();
    }
}

function login() {
    $.ajax({
        url: './php/login.php',
        type: 'POST',
        // Form data
        data: function() {
            var data = new FormData();
            data.append('email', $("#email").val());
            data.append('password', $("#password").val());
            return data;
        }(),
        success: function(data) {
            var obj = JSON.parse(data);
            // console.log(obj);
            if (obj == null) {
                alert("登入帳號/密碼錯誤");
            } else {

                //儲存會員資訊()
                if (typeof(Storage) !== "undefined") {
                    sessionStorage.clear();
                    for (let item in obj) {
                        sessionStorage.setItem(item, obj[item]);
                    }
                }
                document.location.href = "../5-0-2/member.html";
            }
        },
        error: function(data) {
            console.log("login error:" + data);
        },
        complete: function() {
            // console.log("complete");
        },
        cache: false,
        contentType: false,
        processData: false
    });
}