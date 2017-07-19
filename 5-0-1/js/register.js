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
    if (email == confirmEmail && password == confirmPassword) {
        return true;
    } else {
        return false;
    }
}