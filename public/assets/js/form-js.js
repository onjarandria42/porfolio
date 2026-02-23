document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const button = document.getElementById("LoginBtn");
    const passwordInput = document.getElementById("LoginPassword");
    const toggleBtn = document.getElementById("togglePassword");

    // ===== TOGGLE PASSWORD =====
    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener("click", function () {
            const isPassword = passwordInput.getAttribute("type") === "password";
            passwordInput.setAttribute("type", isPassword ? "text" : "password");
            
            // Change l'icône
            this.innerHTML = isPassword ? 
                `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>` : 
                `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
        });
    }

    // ===== FORM SUBMIT & LOADING =====
    if (form && button) {
        form.addEventListener("submit", function () {
            // Active le loading
            button.disabled = true;
            button.classList.add("loading");
        });
    }
});