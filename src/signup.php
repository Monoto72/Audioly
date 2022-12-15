<html>
<?php 
    $pageTitle = "Auidoly | Register";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    if (isset($_SESSION['userId'])) {
        header("location: index.php");
        exit();
    }

    include_once 'views/components/head.php'; 
    ?>

<body class="h-full overflow-x-hidden overflow-y-auto md:overflow-y-hidden">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="h-screen md:flex w-screen">
            <div
                class="relative overflow-hidden md:flex w-1/2 bg-gradient-to-tr from-blue-800 to-purple-700 i justify-around items-center hidden">
                <div class="flex justify-center items-center flex-col">
                    <h1 class="text-white font-bold text-4xl font-sans">Auidoly</h1>
                    <p class="text-white mt-1 w-1/2 text-center">At Audioly, we are passionate about music and dedicated
                        to providing musicians with the tools they need to create and share their art. We offer a wide
                        selection of guitars, drums, pianos, and studio gear from top brands at affordable prices. Our
                        team of experts is here to help you find the perfect instrument or equipment for your needs. We
                        are committed to providing exceptional customer service and a seamless shopping experience. </p>
                    <p class="text-white mt-1 w-1/2 text-center mt-6">Please Ensure to read our TOS below</p>
                        <a href="tos.php"
                        class="block w-28 bg-white text-black-800 mt-4 py-2 rounded-2xl font-bold mb-2 text-center">Click
                        here!</a>
                </div>
            </div>
            <div class="flex md:w-1/2 justify-center py-10 items-center bg-white">
                <form class="bg-white w-2/3" method="post" action="includes/signup-inc.php">
                    <h1 class="text-gray-800 font-bold text-2xl mb-1">Welcome!</h1>
                    <p class="text-sm font-normal text-gray-600 mb-7">Want to save checkouts and see orders?</p>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none w-full" type="text" name="full-name" id="full-name"
                            placeholder="Full name" required />
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none w-full" type="text" name="username" id="username"
                            placeholder="Username" required />
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none w-full" type="text" name="email" id="email"
                            placeholder="Email Address" required />
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                        <input class="pl-2 outline-none border-none w-full" type="password" name="password1"
                            id="password1" autocomplete="on" placeholder="Password" required />
                    </div>
                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl">
                        <input class="pl-2 outline-none border-none w-full" type="password" name="password2"
                            id="password2" autocomplete="on" placeholder="Repeat Password" required />
                    </div>
                    <button type="submit" name="submit" id="submit"
                        class="block w-full bg-green-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Register
                        Account</button>
                    <a href="login.php"><span class="text-sm ml-2 hover:text-blue-500 cursor-pointer">Log in
                            instead</span></a>
                </form>
            </div>
        </div>
        <?php
            include_once 'views/components/footer.php';

            if(isset($_GET['error'])) {
                $urlMessage = $_GET['error'];

                switch ($urlMessage) {
                    case "emptyinput":
                        $toast = "error";
                        $message = "Fill in all fields!";
                        include_once 'views/components/toast.php';
                        break;
                    case "invalidEmail":
                        $toast = "error";
                        $message = "Email is Invalid!";
                        include_once 'views/components/toast.php';
                        break;
                    case "usernameTaken":
                        $toast = "error";
                        $message = "Username is already taken!";
                        include_once 'views/components/toast.php';
                        break;
                    case "passwordsDontMatch":
                        $toast = "error";
                        $message = "Passwords don't match!";
                        include_once 'views/components/toast.php';
                        break;
                    default:
                        $toast = "error";
                        $message = "An unknown error has occurred";
                        include_once 'views/components/toast.php';
                        break;
                }
            }
        ?>
</body>

</html>