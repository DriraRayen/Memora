document.addEventListener("DOMContentLoaded", function () {
   // Ensure the page is loaded before running JS
   const form = document.querySelector(".form-box");
   if (!form) return;

   form.addEventListener("submit", function (e) {
      // Use the email input (the form uses email, not username)
      const emailEl = document.getElementById("email_input");
      const passwordEl = document.getElementById("password_input");
      const remember = document.getElementById("remember_checkbox");
      const email = emailEl ? emailEl.value.trim() : "";
      const password = passwordEl ? passwordEl.value.trim() : "";

      // Simple email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
         alert("Please enter a valid email address.");
         e.preventDefault();
         return;
      }

      if (password.length < 8) {
         alert("Password must be at least 8 characters long.");
         e.preventDefault();
         return;
      }

      if (email === "") {
         alert("Please enter your email.");
         e.preventDefault();
         return;
      }
      if (password === "") {
         alert("Please enter your password.");
         e.preventDefault();
         return;
      }
      // If validation passes we let the form submit normally to the PHP handler
   });
});
