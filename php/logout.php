<?php
session_start();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();
echo "<script>
    alert('See You Soon!\\n\\nYou have been successfully logged out.\\n\\nThank you for using Memora. Come back soon!');
    window.location.href = '../index.php';
</script>";
exit();
?>