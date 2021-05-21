<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: CumberlandACLogin.php"); // Redirecting To Home Page
}
?>