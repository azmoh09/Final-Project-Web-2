<?php
session_start();
if (!isset($_SESSION['id'])) {
     header('location:login.php');
}
$user_id = $_SESSION['id'];
