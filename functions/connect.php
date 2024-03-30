<?php 
    define('CONNECTION', mysqli_connect('localhost', 'root', '', 'data'));

    function isLoggedIn() : bool
    {
        return isset($_SESSION[SESSION_CURRENT_ACCOUNT]);
    }

    function linkToLoginIfNot() : void
    {
        if (!isLoggedIn())
        {
            echo 'login.php?redirect=';
        }
    }
?>