<html>
<?php 
    $pageTitle = "Auidoly | Home";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    include_once 'views/components/head.php'; 
    ?>

<body class="overflow-y-hidden">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <header class='h-1/3 bg-no-repeat bg-center bg-contain bg-gray-700 hidden md:block'
        style='background-image: url(/media/landing.jpg)'>
        <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center'>
            <h1 class='text-5xl font-bold text-white font-mono'>Audioly</h1>
        </div>
    </header>;
    <div class="text-center flex flex-row text-gray-800 py-4 px-2">
        <div class="w-full md:w-1/3 mx-auto border-l-2 border-r-2 border-gray-500 px-8">
            <p>
                Your one-stop shop for all things musical. We offer a wide selection of guitars, drums,
                pianos, and studio gear at affordable prices. Whether you're a beginner or a seasoned musician, you'll find
                everything you need to make beautiful music. Our team of experts is here to help you find the perfect
                instrument or studio equipment to suit your needs. Shop now and start making music today!
            </p>
            <div class="flex flex-row mt-4 shadow-inner bg-gray-100 p-4 rounded-md">
                <a href="store.php?category=guitar" class="mx-auto hover:font-bold text-lg">Guitars</a>
                <span class="">&#8226;</span>
                <a href="store.php?category=drums" class="mx-auto hover:font-bold text-lg">Drums</a>
                <span class="">&#8226;</span>
                <a href="store.php?category=piano" class="mx-auto hover:font-bold text-lg">Pianos</a>
                <span class="">&#8226;</span>
                <a href="store.php?category=studio" class="mx-auto hover:font-bold text-lg">Studio</a>
            </div>
            <div class="flex flex-col mt-4">
                <h2>Please ensure to read our TOS</h2>
                <a href="tos.php" class="mx-auto hover:font-bold font-normal text-blue-800">Click here!</a>
            </div>
        </div>
    </div>
    <?php
            include_once 'views/components/footer.php';

            if(isset($_GET['success']) || isset($_GET['error'])) {
                if(isset($_GET['success'])) {
                    $urlMessage = $_GET['success'];
                } else {
                    $urlMessage = $_GET['error'];
                }

                switch ($urlMessage) {
                    case "loginSuccess":
                        $toast = "success";
                        $message = "Login successful";
                        include_once 'views/components/toast.php';
                        break;
                    case "logoutSuccess":
                        $toast = "success";
                        $message = "Logout successful";
                        include_once 'views/components/toast.php';
                        break;
                    case "signupSuccess":
                        $toast = "success";
                        $message = "Signup successful";
                        include_once 'views/components/toast.php';
                        break;
                    case "statementFailed":
                        $toast = "error";
                        $message = "An error has occurred";
                        include_once 'views/components/toast.php';
                        break;
                    case "orderCompleted":
                        $toast = "success";
                        $message = "Order completed";
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