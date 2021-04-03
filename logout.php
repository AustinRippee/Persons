<?php
    // Ends the currently entered session
    session_start();
    session_destroy();
    // The page in which user will be redirected
    header("Location:login.php");