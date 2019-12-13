<?php
session_start();
session_destroy(); // Destroying All Sessions
header("Location: https://web.njit.edu/~cfl4/index.html"); // Redirecting To Home Page

?>