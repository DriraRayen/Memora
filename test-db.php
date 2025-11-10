<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>

<head>
   <title>Database Test</title>
   <style>
      body {
         font-family: Arial;
         padding: 20px;
         background: #1a1a2e;
         color: white;
      }

      .success {
         color: #00ff00;
      }

      .error {
         color: #ff6b6b;
      }

      .warning {
         color: #ffa500;
      }

      pre {
         background: #16213e;
         padding: 15px;
         border-radius: 5px;
         overflow-x: auto;
      }
   </style>
</head>

<body>
   <h1>🔍 Database Connection Test</h1>
   <hr>

   <?php
   $servername = "sql101.infinityfree.com";
   $username = "if0_40232630";
   $password = "Ylr18bP9C80LPF";
   $dbname = "if0_40232630_001";

   echo "<h2>Testing with:</h2>";
   echo "<pre>";
   echo "Host: $servername\n";
   echo "User: $username\n";
   echo "Pass: " . str_repeat('*', strlen($password)) . "\n";
   echo "DB:   $dbname\n";
   echo "</pre>";

   mysqli_report(MYSQLI_REPORT_OFF);

   echo "<h2>Step 1: Connect to MySQL Server (without database)</h2>";
   $conn = @new mysqli($servername, $username, $password);

   if ($conn->connect_error) {
      echo "<p class='error'>❌ FAILED: " . $conn->connect_error . "</p>";
      echo "<p>This means your username or password is wrong.</p>";
      die();
   } else {
      echo "<p class='success'>✅ SUCCESS! Connected to MySQL server.</p>";
   }

   echo "<h2>Step 2: List All Databases You Have Access To</h2>";
   $result = $conn->query("SHOW DATABASES");
   if ($result) {
      echo "<ul>";
      $found_db = false;
      while ($row = $result->fetch_assoc()) {
         $db = $row['Database'];
         if (strpos($db, 'if0_40232630') !== false) {
            echo "<li class='success'><strong>$db</strong> ← YOUR DATABASE!</li>";
            $found_db = $db;
         } else {
            echo "<li>$db</li>";
         }
      }
      echo "</ul>";

      if ($found_db) {
         echo "<h2>Step 3: Test Connection to Your Database</h2>";
         $conn->select_db($found_db);
         if ($conn->error) {
            echo "<p class='error'>❌ Cannot select database: " . $conn->error . "</p>";
         } else {
            echo "<p class='success'>✅ Successfully connected to: <strong>$found_db</strong></p>";

            echo "<h2>Step 4: Check Tables</h2>";
            $tables = $conn->query("SHOW TABLES");
            if ($tables && $tables->num_rows > 0) {
               echo "<ul>";
               while ($row = $tables->fetch_array()) {
                  $table = $row[0];
                  $count_result = $conn->query("SELECT COUNT(*) as cnt FROM `$table`");
                  $count = $count_result->fetch_assoc()['cnt'];
                  echo "<li><strong>$table</strong> - $count rows</li>";
               }
               echo "</ul>";
            } else {
               echo "<p class='warning'>⚠️ No tables found. Did you import memora.sql?</p>";
            }

            echo "<hr>";
            echo "<h2>✅ SOLUTION</h2>";
            echo "<p>Update your <code>connexion.php</code> with:</p>";
            echo "<pre>\$dbname = \"$found_db\";</pre>";
         }
      } else {
         echo "<p class='error'>❌ No database found starting with 'if0_40232630'</p>";
         echo "<p>Go to InfinityFree Control Panel → MySQL Databases → Create a new database</p>";
      }
   } else {
      echo "<p class='error'>❌ Cannot list databases: " . $conn->error . "</p>";
   }

   $conn->close();
   ?>

</body>

</html>