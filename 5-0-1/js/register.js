function checkIdentical(input1, input2, err, errMsg) {
    var element1 = document.getElementById(input1).value;
    var element2 = document.getElementById(input2).value;
    var elementErr = document.getElementById(err);
    if (element1 != element2) {
        elementErr.innerHTML = errMsg;
        return false;
    } else {
        elementErr.innerHTML = null;
        return true;
    }
}

function register() {
    var email = document.getElementById("email").value;
    var confirmEmail = document.getElementById("confirmEmail").value;
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var emailMsg = document.getElementById("emailMsg").value;
    var name = document.getElementById("name").value;

    if (email == confirmEmail && password == confirmPassword && !emailMsg) {
        //儲存會員資訊()
        if (typeof(Storage) !== "undefined") {
            sessionStorage.clear();
            
            sessionStorage.setItem('email', email);
            sessionStorage.setItem('nickName', name);
            sessionStorage.setItem('password', password);
        }        
        return true;
    } else {
        return false;
    }
}

function checkMailExist(str) {
    if (str.length == 0) {
        document.getElementById("emailMsg").innerHTML = null;
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "exist") {
                    document.getElementById("emailMsg").innerHTML = "mail is used!";
                } else {
                    document.getElementById("emailMsg").innerHTML = null;
                }
                // console.log("checkMailExist:" + this.responseText);
            }
        }
        xmlhttp.open("GET", "./php/checkMailExist.php?email=" + str, true);
        xmlhttp.send();
    }
}