<?php
session_start();

unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['siteid']);
unset($_SESSION['siteshortname']);

header('Location: /');
?>
