<html>
<?php 
    $pageTitle = "Auidoly | Home";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    include_once 'views/components/head.php'; 
    ?>

<body class="overflow-y-auto">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <h2 class="font-medium leading-tight text-4xl mt-0 mb-2 text-black-600 text-center mt-4">Past Orders</h2>
    <div class="text-center text-gray-800 py-4 px-2">
        <div class='overflow-x-auto relative shadow-md sm:rounded-lg w-2/3 mx-auto'>
            <table class='w-full text-sm text-gray-500 dark:text-gray-400 mt-6 table-auto'>
                <thead class='text-xs text-gray-700 uppercase dark:text-gray-400 text-center'>
                    <tr>
                        <th scope='col' class='py-3 px-6'>
                            Product Image
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
                <tbody>
                    <?php 

                            $orderedItems = getLastFiveOrderItems($conn, false);
                            $orders = array();
                            
                            for ($index = 0; $index < count($orderedItems); $index++) {
                                $order = $orderedItems[$index];
                                for ($index2 = 0; $index2 < count($order['order_items']['id']); $index2++) {
                                    $id = $order['order_items']['id'][$index2];
                                    array_push($orders,
                                        array(
                                            "product"=>getProductFromId($conn, $id),
                                            "quantity"=>$order['order_items']['quantity'][$index2],
                                            "date"=>$orderedItems[$index]['order_date']
                                        )
                                    );
                                }
                            }
                            
                            for ($index = 0; $index < 5; $index++) {
                                $item = $orders[$index]['product'];
                                $itemAmount = $orders[$index]['quantity'];
                                $purchaseDate = $orders[$index]['date'];

                                if ($item['name'] != "deleted") {
                                    echo "<tr class='border-b border-gray-200 dark:border-gray-700 text-center'>
                                            <th scope='row' class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap'>
                                                <img class='hover:shadow-md rounded-full mx-auto' src='". $item['image_url'] ."' style='width:64px; height:64px'></img>
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
                            }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include_once 'views/components/footer.php'; ?>
</body>
</html>