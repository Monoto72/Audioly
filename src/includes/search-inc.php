<?php

    var_dump($_POST);

    if (isset($_POST['search'])) {
        $query = $_POST['search'];
        $url.= $_SERVER['REQUEST_URI'];    

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptySearch($query) !== false) {
            header("location: ../index.php?error=emptyInput");
            exit();
        } else {
            header("location: ../search.php?search=". $query ."&page=1");
            exit();
        };
    }
?>