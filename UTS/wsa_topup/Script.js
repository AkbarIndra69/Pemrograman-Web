document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('click', function () {
        let input = this.previousElementSibling;
        let isPassword = input.type === "password";

        // Ubah tipe input password/text
        input.type = isPassword ? "text" : "password";

        // Ubah ikon mata
        this.src = isPassword ? "eye-open.png" : "eye-closed.png";

        // Efek transform
        this.classList.toggle("active");
    });
});
