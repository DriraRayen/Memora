# 🧠 Memora

**Memora** is a web-based flashcard app designed to help students learn efficiently. It offers organized decks, editing tools, and self-testing to boost retention.

🌐 **Live Demo:** [https://memora.kesug.com](https://memora.kesug.com)

---

## 🛠️ Technologies Used

### Frontend

-  **HTML5** - Semantic markup and structure
-  **CSS3** - Custom styling, animations, and responsive design
-  **JavaScript (ES6+)** - Dynamic interactions and Fetch API

### Backend

-  **PHP 7.4+** - Server-side logic and API endpoints
-  **MySQL** - Relational database with MySQLi extension
-  **Session Management** - Secure user authentication

### Tools & Libraries

-  **XAMPP** - Local development environment
-  **Web3Forms** - Contact form integration
-  **Git** - Version control
-  **InfinityFree** - Production hosting

### Security

-  **Password Hashing** - bcrypt (PASSWORD_DEFAULT)
-  **Prepared Statements** - SQL injection prevention
-  **Session Tokens** - User authentication
-  **Git Exclusions** - Sensitive credential protection

---

## 🚀 Features

-  **Create flashcard sets** with questions, answers, hints, and quiz options
-  **Browse by categories** - History, Science, Geography, Sports, Video Games, Movies, Music, Anime, Math
-  **Revise mode** - Study flashcards with flip animations and hints
-  **Quiz mode** - Test yourself with multiple choice questions
-  **User authentication** - Secure login/register with password hashing
-  **Creator accounts** - Special access to create and share flashcard sets
-  **Contact form** - Request creator access via Web3Forms integration
-  **Interactive experience** - Clean, user-friendly and interactive interface (flipcards)

### 🔮 Coming Soon

-  **Creator Studio** - Manage, edit, and delete your own flashcard sets
-  **Analytics Dashboard** - Track study progress and performance
-  **Multiplayer Mode** - Compete with friends in real-time quizzes
-  **Advanced Search** - Filter flashcards by difficulty and topics

---

## ⚙️ Setup

### 1. Clone the Repository

```bash
git clone https://github.com/RayenDrira/Memora.git
cd Memora
```

### 2. Database Setup

-  Import `db/memora.sql` via phpMyAdmin to create the database structure with categories
-  Import `db/sample_data.sql` to populate with 180 sample flashcards

### 3. Configure Database Connection

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

## 📁 Project Structure

```
Memora/
├── index.php                    # Homepage with category showcase
│
├── html/                        # Frontend pages
│   ├── browse.php              # Browse flashcard sets by category
│   ├── contact.php             # Become a creator contact form
│   ├── create.php              # Create new flashcard sets (creators only)
│   ├── revise.php              # Study mode with flip cards and hints
│   ├── signin.php              # User login page
│   └── signup.php              # User registration page
│
├── css/                         # Stylesheets
│   ├── main.css                # Global styles and layout
│   ├── button.css              # Button components
│   ├── Categories.css          # Category browse page styles
│   ├── contact.css             # Contact form styles
│   ├── create.css              # Flashcard creation page styles
│   ├── SignIn.css              # Login/signup page styles
│   ├── burger.css              # Mobile navigation menu
│   ├── custom-input.css        # Form input components
│   ├── flipper.css             # Flashcard flip animations
│   └── quiz.css                # Quiz mode styles
│
├── js/                          # JavaScript modules
│   ├── Categories.js           # Category and flashcard set fetching
│   ├── true-categories.js      # Homepage category display
│   ├── create.js               # Flashcard creation form logic
│   ├── flashcard.js            # Flip card interactions
│   ├── quiz.js                 # Quiz mode functionality
│   ├── signin.js               # Login form validation
│   ├── validation.js           # Form validation utilities
│   ├── contact.js              # Contact form handling
│   ├── navigation.js           # Navigation event handlers
│   └── logout.js               # Logout functionality
│
├── php/                         # Backend scripts
│   ├── connexion.php           # Database connection (gitignored)
│   ├── connexion.example.php   # Database connection template
│   ├── verify-login.php        # User authentication
│   ├── base-signup.php         # User registration handler
│   ├── fetch_categories.php    # API: Get all categories
│   ├── fetch_flashcards.php    # API: Get flashcard sets by category
│   ├── create-set.php          # API: Create new flashcard set
│   └── logout.php              # Session termination
│
├── img/                         # Images and assets
│   ├── logo.png                # Memora logo
│   ├── facebook.png            # Social media icons
│   ├── instagram.png
│   ├── mail.png
│   ├── Free.svg                # Feature icons
│   ├── Customizable.svg
│   └── Community.svg
│
├── .gitignore                   # Git exclusions
├── .gitattributes              # Git line ending normalization
└── README.md                    # This file
```

---

## 👥 Team

-  **Rayen Drira** – Frontend, Backend, UI Design – _Product Owner_
-  **Hadil Fekih** – Frontend, Documentation – _Scrum Master_
-  **Sarra Ayoub** – Frontend, System Design – _Developer_
-  **Mohamed Yassine Romdhani** – UI Design, Testing – _Developer_
-  **Mohamed Malek Sakly** – Database, Testing – _Developer_


