document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const loginStatus = params.get("login");
    const signupStatus = params.get("signup");

    let message = "";
    let alertType = "info"; // default Bootstrap alert

    // Login notifications
    if (loginStatus) {
        if (loginStatus === "success") {
            message = "Login successful! Welcome.";
            alertType = "success";
        } else if (loginStatus === "wrong") {
            message = "Incorrect password. Please try again.";
            alertType = "danger";
        } else if (loginStatus === "notfound") {
            message = "Email not found. Please sign up first.";
            alertType = "warning";
        }
    }

    // Signup notifications
    if (signupStatus) {
        if (signupStatus === "success") {
            message = "Signup successful! You can now log in.";
            alertType = "success";
        } else if (signupStatus === "exist") {
            message = "Email already exists. Please use another.";
            alertType = "warning";
        } else if (signupStatus === "error") {
            message = "Something went wrong. Please try again.";
            alertType = "danger";
        }
    }

    if (message) {
        const alertEl = document.getElementById("notificationAlert");
        const alertMessageEl = document.getElementById("alertMessage");

        alertMessageEl.textContent = message;

        // Set alert type dynamically
        alertEl.className = `alert alert-${alertType} alert-dismissible fade show`;
        
        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            bootstrap.Alert.getOrCreateInstance(alertEl).close();
        }, 3000);

        // Remove query parameters so it doesn't show again on reload
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
