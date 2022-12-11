<html>
<?php 
    $pageTitle = "Auidoly | Register";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    if (isset($_SESSION['user'])) {
        header("location: index.php");
        exit();
    }

    include_once 'views/components/head.php'; 
    ?>

<body class="h-full overflow-x-hidden overflow-y-hidden">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="h-screen md:flex w-screen">
            <div
                class="relative overflow-hidden md:flex w-1/2 bg-gradient-to-tr from-blue-800 to-purple-700 i justify-around items-center hidden">
                <div class="flex justify-center items-center flex-col">
                    <h1 class="text-white font-bold text-4xl font-sans">Auidoly</h1>
                    <p class="text-white mt-1 w-1/2 text-center">Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                        veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
                        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                        mollit anim id est laborum.</p>
                    <button type="submit"
                        class="block w-28 bg-white text-indigo-800 mt-4 py-2 rounded-2xl font-bold mb-2">Read
                        More</button>
                </div>
            </div>
            <div class="flex md:w-1/2 justify-center py-10 items-center bg-white">
                <form class="bg-white w-2/3" method="post" action="includes/signup-inc.php">
                    <input type="hidden" id="admin-level" name="admin-level" value="0"/>
                    <h1 class="text-gray-800 font-bold text-2xl mb-1">Welcome!</h1>
                    <p class="text-sm font-normal text-gray-600 mb-7">Want to save checkouts and see orders?</p>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none" type="text" name="full-name" id="full-name"
                            placeholder="Full name" required/>
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none" type="text" name="username" id="username"
                            placeholder="Username" required/>
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none" type="text" name="email" id="email"
                            placeholder="Email Address" required/>
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none" type="password" name="password1" id="password1"
                            autocomplete="on" placeholder="Password" required/>
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl">
                        <input class="pl-2 outline-none border-none" type="password" name="password2" id="password2"
                            autocomplete="on" placeholder="Repeat Password" required/>
                    </div>
                    <button type="submit" name="submit" id="submit"
                        class="block w-full bg-green-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Register
                        Account</button>
                    <a href="login.php"><span class="text-sm ml-2 hover:text-blue-500 cursor-pointer">Log in
                            instead</span></a>
                </form>
                <?php
            // Path: signup-inc.php

                    if(isset($_GET['error'])) {
                        $errorMessage = $_GET['error'];

                        switch ($errorMessage) {
                            case "emptyInput":
                                echo "<h3 style='color: red;'>Fill in all fields!<h3>";
                                break;
                                case "invalidName":
                                    echo "<h3 style='color: red;'>Invalid Name!</h3>";
                                    break;
                            case "invalidEmail":
                                echo "<h3 style='color: red;'>Invalid email!</h3>";
                                break;
                            case "passwordsDontMatch":
                                echo "<h3 style='color: red;'>Passwords don't match!</h3>";
                                break;
                            case "emailAlreadyExists":
                                echo "<h3 style='color: red;'>An account with that email already exists!</h3>";
                                break;
                            case "stmtFailed":
                                echo "<h3 style='color: red;'>Something went wrong, please try again!</h3>";
                                break;
                            default:
                                echo "";
                                break;
                        }
                    }
                ?>
            </div>
        </div>
</body>

</html>