$(document).ready(function () {
    let passwordInput = $("#password");
    let passwordStrength = $("#password-strength");
    let passwordHelp = $("#password-help");

    function getPasswordStrength(password) {
        let score = 0;

        if (/[A-Z]/.test(password)) score += 1;
        if (/[a-z]/.test(password)) score += 1;
        if (/\d/.test(password)) score += 1;
        if (/[^A-Za-z0-9]/.test(password)) score += 1;

        return score;
    }

    function updatePasswordStrength() {
        let password = passwordInput.val();
        let score = getPasswordStrength(password);

        passwordStrength.removeClass("bg-danger bg-warning bg-success");
        if (score >= 4) {
            passwordStrength.addClass("bg-success");
        } else if (score >= 3) {
            passwordStrength.addClass("bg-warning");
        } else {
            passwordStrength.addClass("bg-danger");
        }

        passwordStrength.css("width", (score * 25) + "%");

        let message = "";
        if (password.length < 8) {
            message = "Password should be at least 8 characters long and include a mix of upper and lowercase letters, numbers, and symbols.";
        } else if (score < 4) {
            message = "Include a mix of upper and lowercase letters, numbers, and symbols.";
        }
        passwordHelp.text(message);
    }

    passwordInput.on("input", updatePasswordStrength);
});
