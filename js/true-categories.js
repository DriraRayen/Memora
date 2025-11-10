function displayCategoryButtons() {
   const flashcardSetsContainer = document.getElementById("flashcard-sets"); // You can rename this if needed

   // Clear the container first
   flashcardSetsContainer.innerHTML = "";

   // Fetch categories from the server
   fetch(`php/fetch_categories.php`)
      .then((response) => response.json())
      .then((categories) => {
         console.log("Fetched categories:", categories); // Debug

         if (categories.error) {
            flashcardSetsContainer.innerHTML = `<p style="color: #31c1e1; font-size: 1.2em; text-align: center; padding: 2em;">${categories.error}</p>`;
            return;
         }
         if (categories.length === 0) {
            flashcardSetsContainer.innerHTML = `<p style="color: white; font-size: 1.2em; text-align: center; padding: 2em;">No categories available yet.<br><br>Check back soon for new content!</p>`;
            return;
         }

         for (let i = 0; i < categories.length; i += 3) {
            const row = document.createElement("div");
            row.className = "main-content-row";

            for (let j = i; j < i + 3 && j < categories.length; j++) {
               const category = categories[j];
               const button = document.createElement("button");
               button.className = "btx-blue-blue";
               button.onclick = () => {
                  window.location.href = `html/browse.php?category_id=${category.id}&category_name=${category.name}`;
               };

               button.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 48 48">
                        <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                            <path d="M28 12V4L8 14v28l12-6" />
                            <path fill="currentColor" d="M20 16L40 6v28L20 44z" />
                        </g>
                    </svg>
          ${category.name}`;
               row.appendChild(button);
            }

            flashcardSetsContainer.appendChild(row);
         }
      })
      .catch((error) => {
         console.error("Error fetching categories:", error);
         flashcardSetsContainer.innerHTML = `<p style="color: #ff6b6b; font-size: 1.2em; text-align: center; padding: 2em;">Connection Error<br><br>Unable to load categories. Please check your internet connection and refresh the page.</p>`;
      });
}
document.addEventListener("DOMContentLoaded", () => {
   displayCategoryButtons(); // Load all category buttons initially
});
