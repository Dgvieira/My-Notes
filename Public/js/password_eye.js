
const passwordInput = document.getElementById("password");
const eyeIcon = document.getElementById("eye-icon");


eyeIcon.onclick = function() {

    if(passwordInput.type == "password") {

        passwordInput.type = "text";
        eyeIcon.classList = "fa-solid fa-eye";

    } else {

        passwordInput.type = "password";
        eyeIcon.classList = "fa-solid fa-eye-slash";
    }

}