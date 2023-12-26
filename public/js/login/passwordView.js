// Wait for the document to load
document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById("password");
    const eyeIcon = document.querySelector(".fa-eye");

    // Function to toggle password visibility
    function togglePasswordVisibility() {
        const type =
            passwordField.getAttribute("type") === "password"
                ? "text"
                : "password";
        passwordField.setAttribute("type", type);
    }

    // Toggle password visibility on eye icon click
    eyeIcon.addEventListener("click", function () {
        togglePasswordVisibility();
        // Toggle eye icon class to change the appearance
        eyeIcon.classList.toggle("fa-eye");
        eyeIcon.classList.toggle("fa-eye-slash");
    });
});
