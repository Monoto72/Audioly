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
                            echo "<h1 class='text-5xl font-bold text-center'>Product Panel</h1>
                                <hr class='mt-2'>
                                <div class='flex flex-row w-full text-center bg-gray-50 shadow-inner'>
                                    <a href='admin.php?content=users&action=create user' class='w-1/4 bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded m-4 mx-auto'>Create User</a>
                                    <a href='' class='w-1/4 bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded m-4 mx-auto'><i class='fa fa-lock'></i> Edit User - SoonTM</a>
                                    <a href='' class='w-1/4 bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded m-4 mx-auto'><i class='fa fa-lock'></i> Remove User - SoonTM</a>
                                </div>";
                            echo "<hr class=''><h2 class='text-3xl font-bold text-center'>Coming Soon...</h2>";
                            break;
                        case 'products':
                            echo "<h1 class='text-5xl font-bold text-center'>Product Panel</h1>
                                <hr class='mt-2'>
                                <div class='flex flex-row w-full text-center bg-gray-50 shadow-inner'>
                                    <a href='admin.php?content=products&action=create product' class='w-1/4 bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded m-4 mx-auto'>Create Product</a>
                                    <a href='admin.php?content=products&sub-action=edit product' class='w-1/4 bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded m-4 mx-auto'>Edit Product</a>
                                    <a href='admin.php?content=products&action=remove product' class='w-1/4 bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded m-4 mx-auto'>Remove Product</a>
                                </div>";
                            echo "<hr class=''><h2 class='text-3xl font-bold text-center'>Recent Purchases</h2>";
                            echo "<div class='text-center text-gray-800 py-4 px-2'>
                                <div class='overflow-x-auto relative shadow-md sm:rounded-lg w-full mx-auto'>
                                    <table class='w-full text-sm text-gray-500 dark:text-gray-400 mt-6 table-auto'>
                                        <thead class='text-xs text-gray-700 uppercase dark:text-gray-400 text-center'>
                                            <tr>
                                                <th scope='col' class='py-3 px-6'>
                                                    Purchaser ID
                                                </th>
                                                <th scope='col' class='py-3 px-6'>
                                                    Product name
                                                </th>
                                                <th scope='col' class='py-3 px-6'>
                                                    Category
                                                </th>
                                                <th scope='col' class='py-3 px-6'>
                                                    Price
                                                </th>
                                                <th scope='col' class='py-3 px-6'>
                                                    Date
                                                </th>
                                                <th scope='col' class='py-3 px-2'>
                        
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                                    $orderedItems = getLastFiveOrderItems($conn, true);
                                                    $orders = array();
                                                    
                                                    for ($index = 0; $index < count($orderedItems); $index++) {
                                                        $order = $orderedItems[$index];
                                                        for ($index2 = 0; $index2 < count($order['order_items']['id']); $index2++) {
                                                            $id = $order['order_items']['id'][$index2];
                                                            array_push($orders,
                                                                array(
                                                                    "product"=>getProductFromId($conn, $id),
                                                                    "quantity"=>$order['order_items']['quantity'][$index2],
                                                                    "date"=>$orderedItems[$index]['order_date'],
                                                                    "userId"=>$orderedItems[$index]['user_id']
                                                                )
                                                            );
                                                        }
                                                    }
                                                    
                                                    for ($index = 0; $index < 5; $index++) {
                                                        if(!isset($orders[$index])) {
                                                            break;
                                                        }
                                                        $item = $orders[$index]['product'];
                                                        $itemAmount = $orders[$index]['quantity'];
                                                        $purchaseDate = $orders[$index]['date'];
                                                        $purchaserId = $orders[$index]['userId'];
                        
                                                        echo "<tr class='border-b border-gray-200 dark:border-gray-700 text-center'>
                                                                <th class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap'>
                                                                    ". $purchaserId ."
                                                                </th>
                                                                <th class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap'>
                                                                    ". $item['name'] ."
                                                                </th>
                                                                <td class='py-4 px-6'>
                                                                    ". $item['type'] ."
                                                                </td>
                                                                <td class='py-4 px-6 -50 dark:-800'>
                                                                    £". $item['price'] ." x ". $itemAmount ."
                                                                </td>
                                                                <td class='py-4 px-6 -50 dark:-800'>
                                                                    ". $purchaseDate."
                                                                </td>
                                                                <td class='py-4 px-6'>
                                                                    <a href='product.php?category=". $item['type'] ."&item=". $item['slug'] ."' class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>View</a>
                                                                </td>
                                                            </tr>";
                                                    }
                                        echo "</tbody>
                                    </table>
                                </div>
                            </div>";
                            echo "<a href='admin.php?content=products' class='mx-auto w-1/5'><button class='w-full checkout-close bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>Refresh</button></a>";
                            break;
                        case 'orders':
                            echo "<h1 class='text-5xl font-bold mr-60 ml-4'>Order Panel</h1>";
                            break;
                        default:
                            echo "<h1 class='text-5xl font-bold mr-60 ml-4'>Dashboard</h1>";
                            break;
                    }
                } else {
                    echo "<h1 class='text-5xl font-bold text-center'>Dashboard</h1>";
                    echo "<div class='flex flex-row space-x-4 w-full h-3/6 mx-auto font-bold mt-20'>
                        <div class='my-auto flex flex-col w-3/4 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center'>
                            <h1 class='text-3xl font-bold'>Total Orders</h1>
                            <h3 class='text-gray-600'>". getTotalOrders($conn)[0]['total'] ."</h3>
                        </div>
                        <div class='my-auto flex flex-col w-3/4 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center'>
                            <h1 class='text-3xl font-bold'>Total Profit</h1>
                            <h3 class='text-gray-600'>£". getTotalProfit($conn)[0]['total'] ."</h3>
                        </div>                
                        <div class='my-auto flex flex-col w-3/4 bg-white h-1/2 shadow-lg rounded-md hover:shadow-xl flex items-center justify-center'>
                            <h1 class='text-3xl font-bold'>Users Created</h1>
                            <h3 class='text-gray-600'>". getTotalUsers($conn)[0]['total'] ."</h3>
                        </div>
                    </div>";
                }
            ?>
    </div>
    <?php include_once 'views/components/footer.php';?>
</body>

</html>