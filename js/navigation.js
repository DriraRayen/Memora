document.addEventListener("DOMContentLoaded", () => {
   // Buttons
   const getStartedButton = document.getElementById("get-started");
   const contactButton = document.getElementById("contact");
   const categoryButtons = document.querySelectorAll(
      ".main-content-row button"
   );
   const loginButton = document.getElementById("login");

   // Navigate to Login Page (only if button exists)
   if (loginButton) {
      loginButton.addEventListener("click", () => {
         window.location.href = "../html/signin.html";
      });
   }

   // Navigate to Browse Page (Get Started)
   getStartedButton.addEventListener("click", () => {
      window.location.href = "../html/browse.html";
   });

   // Navigate to Contact Page
   contactButton.addEventListener("click", () => {
      window.location.href = "../html/contact.html";
   });

   // Navigate to Browse Page with Category
   categoryButtons.forEach((button) => {
      button.addEventListener("click", () => {
         const category = button.dataset.category; // Use `data-category` attribute
         if (category) {
            window.location.href = `../html/browse.html?category=${encodeURIComponent(
               category
            )}`;
         } else {
            console.error("Category not found for button.");
         }
      });
   });
});
