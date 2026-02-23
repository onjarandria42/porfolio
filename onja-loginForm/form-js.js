document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const button = document.getElementById("LoginBtn");
    const passwordInput = document.getElementById("LoginPassword");
    const emailInput = document.getElementById("LoginEmail");

    /* ===== TOGGLE PASSWORD ===== */
    if (passwordInput) {
        const wrapper = document.createElement("div");
        wrapper.style.position = "relative";
        passwordInput.parentNode.insertBefore(wrapper, passwordInput);
        wrapper.appendChild(passwordInput);

        const eye = document.createElement("span");
        eye.innerHTML = "👁";
        eye.style.position = "absolute";
        eye.style.right = "15px";
        eye.style.top = "50%";
        eye.style.transform = "translateY(-50%)";
        eye.style.cursor = "pointer";
        eye.style.opacity = "0.6";
        wrapper.appendChild(eye);

        eye.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            eye.style.opacity = type === "text" ? "1" : "0.6";
        });
    }

    /* ===== FORM VALIDATION + LOADER ===== */
    if (form && button) {
        form.addEventListener("submit", function (e) {
            // Validation email
            if (!emailInput.value.trim()) {
                alert("Veuillez entrer votre email");
                emailInput.focus();
                e.preventDefault();
                return;
            }

            // Validation password
            if (!passwordInput.value.trim()) {
                alert("Veuillez entrer votre mot de passe");
                passwordInput.focus();
                e.preventDefault();
                return;
            }

            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!re.test(emailInput.value)) {
                alert("Email non valide");
                emailInput.focus();
                e.preventDefault();
                return;
            }

            // ✅ Tout est OK → loader
            const text = button.querySelector(".btn-text");
            const spinner = button.querySelector(".spinner");

            if (text && spinner) {
                button.disabled = true;
                text.style.display = "none";
                spinner.style.display = "inline-block";
            }

            // Laisse le formulaire se soumettre normalement
        });
    }
});