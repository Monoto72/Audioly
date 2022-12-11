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

function createUser($conn, $fullName, $username, $email, $password, $adminLevel = 0, $adminCreated = false) {
    $sql = "INSERT INTO users (full_name, username, email, password, admin_level) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=statementFailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssi", $fullName, $username, $email, $hashedPassword, $adminLevel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$adminCreated) {
        $userData = getUserByEmail($conn, $email);

        $_SESSION["loggedIn"] = true;
        $_SESSION['fullName'] = $userData['first_name'] . " " . $userData['second_name'];
        $_SESSION['userId'] = $userData['id'];
        $_SESSION['email'] = $userData['first_name'];
        $_SESSION['password'] = $userData['second_name'];
        $_SESSION['adminLevel'] = $userData['admin_level'];

        header("location: ../index.php");
    }

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

        $userCart = getUserCart($conn, $userData['id']);

        if (count($userCart) !== 0) {
            $_SESSION['cart'] = $userCart;
        }

        if (isset($_SESSION['billingAddress']) === false) {
            $_SESSION['billingAddress']['address'] = $userData['address'];
            $_SESSION['billingAddress']['city'] = $userData['city'];
            $_SESSION['billingAddress']['postCode'] = $userData['post_code'];
            $_SESSION['billingAddress']['country'] = $userData['country'];
        }

        header("location: ../index.php");

        exit();
    }
}

function emptyBillingAddress($address, $city, $postCode, $country) {
    $result = false;

    if (empty($address) || empty($city) || empty($postCode) || empty($country)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function addBillingAddress($conn, $address, $city, $postCode, $country) {
    $sql = "UPDATE users SET address = ?, city = ?, post_code = ?, country = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../billingAddress.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssi", $address, $city, $postCode, $country, $_SESSION['userId']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['billingAddress']['address'] = $address;
    $_SESSION['billingAddress']['city'] = $city;
    $_SESSION['billingAddress']['postCode'] = $postCode;
    $_SESSION['billingAddress']['country'] = $country;

    header("location: ../billingAddress.php?error=none");
    exit();
}

/**
 * Gets top 5 items from database
 * 
 * @param object $conn - the database connection
 * @return array $row - the top 5 items
 **/

function getTopFive($conn, $type) {
    $sql = "SELECT * FROM store_items WHERE type = ? AND name != 'deleted' ORDER BY price DESC LIMIT 5";
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

function getProduct($conn, $slug) {
    $sql = "SELECT * FROM store_items WHERE slug = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $slug);
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
 * Gets an amount of products from database
 * 
 * @param object $conn - the database connection
 * @param string $type - the product type
 * @param int $i - the start point
 * @param int $j - the end point
 * @return array $row - the product data
 * 
 **/

function getCategoryPagination($conn, $type, $i, $j) {
    $sql = "SELECT * FROM store_items WHERE type = ? AND name != 'deleted' ORDER BY id LIMIT ?,?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sii", $type, $i, $j);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $entries = array();

    while ($row = mysqli_fetch_assoc($resultData)) {
        $entries[] = $row;
    }

    return $entries;
}

/**
 * Gets an amount of products from database based on a search query
 * 
 * @param object $conn - the database connection
 * @param string $query - the product type
 * @param int $i - the start point
 * @param int $j - the end point
 * @return array $row - the product data
 * 
 **/

function getSearchPagination($conn, $query, $i, $j) {
    $sql = "SELECT * FROM store_items WHERE name LIKE ? OR description LIKE ? OR type LIKE ? AND name != 'deleted' ORDER BY id LIMIT ?,?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    $search = "%" . $query . "%";

    mysqli_stmt_bind_param($stmt, "sssii", $search, $search, $search, $i, $j);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $entries = array();

    while ($row = mysqli_fetch_assoc($resultData)) {
        $entries[] = $row;
    }

    return $entries;
}

function emptySearch($search) {
    $result = false;

    if (empty($search)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function emptyInputAddToCart($quantity) {
    $result = false;

    if (empty($quantity)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function productExistsSlug($conn, $slug) {
    $sql = "SELECT * FROM store_items WHERE slug = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return true;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function productExistsName($conn, $name) {
    $sql = "SELECT * FROM store_items WHERE name = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return true;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function createProduct($conn, $name, $description, $price, $type, $imageUrl) {
    $slug = createSlugFromName($name);

    $sql = "INSERT INTO store_items (name, slug, description, price, type, image_url) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $name, $slug, $description, $price, $type, $imageUrl);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}

function createSlugFromName($name) {
    $slug = strtolower($name);
    $slug = str_replace(" ", "-", $slug);
    return $slug;
}

function removeProduct($conn, $productSlug) {
    $sql = "UPDATE store_items SET name = 'deleted' WHERE slug = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $productSlug);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    exit();
}

function getUserCart($conn) {
    $sql = "SELECT * FROM cart INNER JOIN store_items ON store_items.id = cart.item_id WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId']);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $entries = array();

    while ($row = mysqli_fetch_assoc($resultData)) {
        $entries[] = $row;
    }

    return $entries;
}

function addToCart($conn, $slug, $quantity) {
    $cartItem = getProduct($conn, $slug);

    if (isset($_SESSION['userId'])) {
        $sql = "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=statementFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iii", $_SESSION['userId'], $cartItem['id'], $quantity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    if (isset($_SESSION['cart']) === false) {
        $_SESSION['cart'] = array();
    }

    $cartItem['quantity'] = $quantity;
    array_push($_SESSION['cart'], $cartItem);
}

function addProductDuplicate($conn, $slug, $quantity) {
    $cartItem = getProduct($conn, $slug);

    $sql = "SELECT * FROM cart WHERE item_id = ? AND user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $cartItem['id'], $_SESSION['userId']);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $sql2 = "UPDATE cart SET quantity = quantity + $quantity WHERE item_id = ? AND user_id = ?;";
        $stmt2 = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt2, $sql2)) {
            header("location: ../index.php?error=statementFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt2, "ii", $cartItem['id'], $_SESSION['userId']);
        mysqli_stmt_execute($stmt2);

        mysqli_stmt_close($stmt2);

        return true;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function updateUserCart($conn, $quantity, $slug) {
    $cartItem = getProduct($conn, $slug);
    $sql = "";

    if ($quantity == 0) {
        $sql = "DELETE FROM cart WHERE item_id = ? AND user_id = ?;";

        foreach ($_SESSION['cart'] as $key=>$item) {
            if ($item['id'] == $cartItem['id']) {
                array_splice($_SESSION['cart'], $key, 1);
            }
        }
    } else {
        $sql = "UPDATE cart SET quantity = ? WHERE item_id = ? AND user_id = ?;";

        foreach ($_SESSION['cart'] as $key=>$item) {
            if ($item['id'] == $cartItem['id']) {
                $_SESSION['cart'][$key]['quantity'] = $quantity;
            }
        }
    }

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    if ($quantity == 0) {
        mysqli_stmt_bind_param($stmt, "ii", $cartItem['id'], $_SESSION['userId']);
    } else {
        mysqli_stmt_bind_param($stmt, "iii", $quantity, $cartItem['id'], $_SESSION['userId']);
    }

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function getCartTotal($conn) {
    $sql = "SELECT SUM(store_items.price * cart.quantity) AS total FROM cart INNER JOIN store_items ON store_items.id = cart.item_id WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId']);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $entries = array();

    while ($row = mysqli_fetch_assoc($resultData)) {
        $entries[] = $row;
    }

    return $entries;
}

function getCartTotalUnlogged() {
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return $total;
}

function emptyInputCreateProduct($name, $price, $description, $type, $image) {
    $result = false;

    if (empty($name) || empty($price) || empty($description) || empty($type) || empty($image)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function emptyInputProduct($productSlug) {
    $result = false;

    if (empty($productSlug)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
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