<html>
    <?php 
        $pageTitle = "Auidoly | Profile";

        require_once 'includes/dbh-inc.php';
        require_once 'includes/functions-inc.php';

        if (strpos($_SERVER['REQUEST_URI'], "id") !== false) {
            $url_components = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url_components['query'], $params);

            if ($params['id'] != $_SESSION['userId']) {
                header("location: index.php?error=unauthorized");
                exit();
            }
            
            include_once 'views/components/head.php'; 

            echo '<body class="h-screen overflow-x-hidden overflow-y-auto md:overflow-y-hidden">';
            echo '<navbar>';
                include_once 'views/components/navbar.php';
            echo '</navbar>';

            if (isset($params['action'])) {
                switch ($params['action']) {
                    case "billing info":
                        if (count($params) == 3) {
                            $billingType = $params['type'];
                            include_once 'views/components/profile/billing-address.php';
                        } else {
                            header("location: index.php?error=incomplete");
                        }
                        break;
                    default:
                        header("location: index.php?error=unauthorized");
                        exit();
                }
            }

        } else {
            header("location: ../index.php");
        }


    ?>
        <div class="text-center bg-gray-50 text-gray-800 py-4 px-2 h-screen space-y-4 w-full">
            <h1 class='text-2xl font-bold mt-0'>Your Account</h1>
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 w-full md:w-3/6 h-1/6 mx-auto font-bold">
                <?php
                    if (isset($_SESSION['billingAddress'])) {
                        echo '<a href="profile.php?id='. $_SESSION['userId'] .'&action=billing info&type=edit" class="cursor-pointer w-full md:w-1/3 bg-white h-1/2 shadow-lg hover:shadow-xl rounded-md flex items-center justify-center">
                            Edit Billing Address
                        </a>';
                    } else {
                        echo '<a href="profile.php?id='. $_SESSION['userId'] .'&action=billing info&type=add" class="cursor-pointer w-full md:w-1/3 bg-white h-1/2 shadow-lg hover:shadow-xl rounded-md flex items-center justify-center">
                            Add Billing Address
                        </a>';
                    }
                ?>
                <a class="cursor-pointer w-full md:w-1/3 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center">
                    Edit Account Details
                </a>                
                <a class="cursor-pointer w-full md:w-1/3 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center">
                    Add Payment Option
                </a>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 w-full md:w-3/6 h-1/6 mx-auto font-bold">
                <a class="cursor-pointer w-full md:w-1/3 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center">
                    Show Orders
                </a>
                <a class="cursor-pointer w-full md:w-1/3 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center">
                    Contact Us
                </a>                
                <a class="cursor-pointer w-full md:w-1/3 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center">
                    Coming Soon...
                </a>
            </div>
        </div>
    </body>
</html>