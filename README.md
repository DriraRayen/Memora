# 🧠 Memora

**Memora** is a web-based flashcard app designed to help students learn efficiently. It offers organized decks, editing tools, and self-testing to boost retention.

---

## 🚀 Features

-  Create, edit, and delete flashcards
-  Organize cards by chapters or modules
-  Test yourself and track your scores
-  User authentication (Login/Register)
-  Contact form (sends email directly)
-  Clean and user-friendly interface
-  **Coming soon**: Multiplayer mode

---

## ⚙️ Setup

### 1. Clone the Repository

```bash
git clone https://github.com/RayenDrira/Memora.git
cd Memora
```

### 2. Database Setup

-  Import `db/memora.sql` via phpMyAdmin to create the database structure with categories
-  (Optional) Import `db/sample_data.sql` to populate with 180 sample flashcards

### 3. Configure Database Connection

**IMPORTANT: Never commit your database credentials!**

1. Copy the template file:
   ```bash
   cp php/connexion.example.php php/connexion.php
   ```
2. Edit `php/connexion.php` with your actual database credentials:
   -  For **local development (XAMPP)**:
      ```php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "memora";
      ```
   -  For **production hosting**:
      ```php
      $servername = "your-host.com";
      $username = "your-username";
      $password = "your-password";
      $dbname = "your-database";
      ```

### 4. Run the Application

-  Start XAMPP (Apache + MySQL)
-  Navigate to `http://localhost/Memora/`
-  Register a new account or login

---

## 🔒 Security Notes

-  `php/connexion.php` is **excluded from Git** for security
-  Use `php/connexion.example.php` as a template
-  Never commit passwords or API keys
-  Keep your `.gitignore` file updated

---

## 📁 Structure

memora/
├── html/
├── css/
├── js/
├── php/
├── db/
├── img/
└── README.md

---

## 👥 Team

-  **Rayen Drira** – Frontend, Backend, UI Design – _Product Owner_
-  **Hadil Fekih** – Frontend, Documentation – _Scrum Master_
-  **Sarra Ayoub** – Frontend, System Design – _Developer_
-  **Mohamed Yassine Romdhani** – UI Design, Testing – _Developer_
-  **Mohamed Malek Sakly** – Database, Testing – _Developer_

---

## 🔖 Tagline

Product Owner at Memora | Computer Engineering Student | IoT & Cybersecurity Enthusiast
