<html>
    <?php 
    $pageTitle = "Auidoly | Dashboard";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    if (isset($_SESSION['userId'])) {
        if (isset($_SESSION['adminLevel'])) {
            if ($_SESSION['adminLevel'] == 0) {
                header("location: index.php?error=unauthorized");
                exit();
            }
        } else {
            header("location: index.php");
            exit();
        }
    } else {
        header("location: index.php");
        exit();
    }

    if (strpos($_SERVER['REQUEST_URI'], "content") !== false) {
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url_components['query'], $params);

        $pageTitle = "Auidoly | ". $params['content'];

        if (count($params) > 1 && !isset($params['error'])) {
            if (isset($params['action'])) {
                switch ($params['action']) {
                    case 'create user':
                        $pageTitle = "Auidoly | Create User";
                        include_once 'views/components/admin/create-user.php';
                        break;
                    case 'create product':
                        $pageTitle = "Auidoly | Create Product";
                        include_once 'views/components/admin/create-product.php';
                        break;
                    case 'edit product':
                        $pageTitle = "Auidoly | Edit Product";
                        include_once 'views/components/admin/edit-product.php';
                        break;
                    case 'remove product':
                        $pageTitle = "Auidoly | Remove Product";
                        include_once 'views/components/admin/remove-product.php';
                        break;
                    default:
                        $pageTitle = "Auidoly | Dashboard";
                        break;
                }
            } else if (isset($params['sub-action'])) {

                switch($params['sub-action']) {
                    case 'edit product':
                        $pageTitle = "Auidoly | Edit Product";
                        include_once 'views/components/admin/sub-edit-product.php';
                        break;
                    default:
                        $pageTitle = "Auidoly | Dashboard";
                        break;
                }
            }
        }
    } else {
        $pageTitle = "Auidoly | Dashboard";
    }
    
    include_once 'views/components/head.php';

    ?>
    <body class="overflow-y-auto flex flex-row">
        <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/admin/navbar.php'; ?>
        </navbar>
        <div class="w-full flex flex-col">
            <?php
                if(isset($params['content'])) {
                    switch ($params['content']) {
                        case 'users':
                            echo "<h1 class='text-5xl font-bold mr-60 ml-4'>User Panel</h1>
                                <div class='flex flex-col w-1/6 text-center'>
                                    <a href='admin.php?content=users&action=create user' class='bg-slate-400 text-white font-bold py-2 px-4 rounded m-4'>Create User</a>
                                </div>";
                            break;
                        case 'products':
                            echo "<h1 class='text-5xl font-bold mr-60 ml-4'>Product Panel</h1>
                                <div class='flex flex-col w-1/6 text-center'>
                                    <a href='admin.php?content=products&action=create product' class='bg-slate-400 text-white font-bold py-2 px-4 rounded m-4'>Create Product</a>
                                    <a href='admin.php?content=products&sub-action=edit product' class='bg-slate-400 text-white font-bold py-2 px-4 rounded m-4'>Edit Product</a>
                                    <a href='admin.php?content=products&action=remove product' class='bg-slate-400 text-white font-bold py-2 px-4 rounded m-4'>Remove Product</a>
                                </div>";
                            break;
                        case 'orders':
                            echo "<h1 class='text-5xl font-bold mr-60 ml-4'>Order Panel</h1>";
                            break;
                        default:
                            echo "<h1 class='text-5xl font-bold mr-60 ml-4'>Dashboard</h1>";
                            break;
                    }
                } else {
                    echo "<h1 class='text-5xl font-bold mr-60 ml-4'>Dashboard</h1>";
                }
            ?>
        </div>
    </body>
</html>