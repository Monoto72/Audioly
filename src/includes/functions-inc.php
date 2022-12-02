<?php
    session_start();
    ob_start();

/**
* Ensures all fields are complete and none are null
* 
* @param string $firstName
* @param string $secondName
* @param string $email
* @param string $password
* @param string $verifyPassword
* @return bool true if all fields are complete, false if not
**/

function emptyInputSignup($fullName, $username, $email, $password, $verifyPassword) {
    $result = false;

    if (empty($fullName) || empty($username) || empty($email) || empty($password) || empty($verifyPassword)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

/**
 * Ensures that the email is valid
 * 
 * @param string $email
 * @return bool true if valid, false if not
 **/

function invalidEmail($email) {
    $result = false;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

/**
 * Ensures that the password and verify password fields match
 * 
 * @param string $password
 * @param string $verifyPassword
 * @return bool true if they match, false if not
 **/

function passwordMatch($password, $verifyPassword) {
    $result = false;

    if ($password !== $verifyPassword) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

/**
 * Ensures that the username is not already taken
 * 
 * @param object $conn
 * @param string $username
 * @param string $email
 * @return bool true if taken, false if not
 **/

function usernameExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

/**
 * Creates a new user in the database
 * 
 * @param object $conn
 * @param string $firstName
 * @param string $secondName
 * @param string $email
 * @param string $password
 * @return bool true if successful, false if not
 **/

function createUser($conn, $fullName, $username, $email, $password) {
    $sql = "INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=statementFailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $fullName, $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $userData = getUserByEmail($conn, $email);

    $_SESSION["loggedIn"] = true;
    $_SESSION['fullName'] = $userData['first_name'] . " " . $userData['second_name'];
    $_SESSION['userId'] = $userData['id'];
    $_SESSION['email'] = $userData['first_name'];
    $_SESSION['password'] = $userData['second_name'];
    $_SESSION['adminLevel'] = $userData['admin_level'];

    header("location: ../index.php");
    exit();
}

/**
 * Gets the user data from the database
 * 
 * @param object $conn
 * @param string $email
 * @return array $row - the user data
 **/

function getUserByEmail($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

/**
 * Ensures all fields are complete and none are null
 * 
 * @param string $email
 * @param string $password
 * @return bool true if all fields are complete, false if not
 **/

function emptyInputLogin($email, $password) {
    $result = false;

    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

/**
 * Logs the user in
 * 
 * @param object $conn - the database connection
 * @param string $email
 * @param string $password
 * @return bool true if successful, false if not
 **/

function loginUser($conn, $email, $password) {
    $userData = getUserByEmail($conn, $email);

    if ($userData === false) {
        header("location: ../login.php?error=wrongLogin");
        exit();
    }

    $passwordHashed = $userData['password'];
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        header("location: ../login.php?error=wrongLogin");
        exit();
    } else if ($checkPassword === true) {
        $_SESSION["loggedIn"] = true;
        $_SESSION['fullName'] = $userData['full_name'];
        $_SESSION['username'] = $userData['username'];
        $_SESSION['userId'] = $userData['id'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['adminLevel'] = $userData['admin_level'];

        header("location: ../index.php");

        exit();
    }
}

/**
 * Gets top 5 items from database
 * 
 * @param object $conn - the database connection
 * @return array $row - the top 5 items
 **/

function getTopFive($conn, $type) {
    $sql = "SELECT * FROM store_items WHERE type = ? ORDER BY price DESC LIMIT 5;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $type);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $entries = array();

    while ($row = mysqli_fetch_assoc($resultData)) {
        $entries[] = $row;
    }

    return $entries;
}

/**
 * Gets product from database
 * 
 * @param object $conn - the database connection
 * @param string $id - the product id
 * @return array $row - the product data
 * 
 **/

function getProduct($conn, $id) {
    $sql = "SELECT * FROM store_items WHERE slug = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

/**
 * Log out the user
 */

function logout() {
    session_start();
    session_unset();
    session_destroy();

    header("location: index.php");
    exit();
}

?>