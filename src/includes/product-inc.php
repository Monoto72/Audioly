<?php

    if (isset($_POST['submit'])) {

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        $formType = $_POST['form-type'];

        if ($formType === "create") {
            $productName = $_POST['name'];
            $productPrice = $_POST['price'];
            $productDescription = $_POST['description'];
            $productType = $_POST['category'];
            $productImage = $_POST['file-url'];

            if (emptyInputCreateProduct($productName, $productPrice, $productDescription, $productType, $productImage) !== false) {
                header("location: ../admin.php?content=products&error=emptyInput");
                exit();
            } else if (productExistsName($conn, $productName) !== false) {
                header("location: ../admin.php?content=products&error=productExists");
                exit();
            } else {
                createProduct($conn, $productName, $productDescription, $productPrice, $productType, $productImage);
                header("location: ../admin.php?content=products&success=productCreated");
                exit();
            }
        } else if ($formType === "sub-edit") {
            $productSlug = $_POST['slug'];

            if (emptyInputProduct($productSlug) !== false) {
                header("location: ../admin.php?content=products&error=emptyInput");
                exit();
            } else if (productExistsSlug($conn, $productSlug) === false) {
                header("location: ../admin.php?content=products&error=productDoesntExist");
                exit();
            } else {
                header("location: ../admin.php?content=products&action=edit product&item=$productSlug");
            }
        } else if ($formType === "edit") {

        } else if ($formType === "remove") {
            $productSlug = $_POST['slug'];

            if (emptyInputProduct($productSlug) !== false) {
                header("location: ../admin.php?content=products&error=emptyInput");
                exit();
            } else if (productExistsSlug($conn, $productSlug) === false) {
                header("location: ../admin.php?content=products&error=productDoesntExist");
                exit();
            } else {
                removeProduct($conn, $productSlug);
                header("location: ../admin.php?content=products&success=productRemoved");
            }

        }
    }

?>