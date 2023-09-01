    const user_btn = document.querySelector(".rightEl #user-btn");
    const box = document.getElementById("login-box");
    user_btn.addEventListener('click', function() {
        if (box.classList.contains("hide")) {
            box.classList.remove("hide");
            box.classList.add("show");
        }
        else {
            box.classList.add("hide");
            box.classList.remove("show");
        }
    })
 