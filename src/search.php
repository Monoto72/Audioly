<html>
    <?php 
    $pageTitle = "Auidoly | Search";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    include_once 'views/components/head.php'; 

    if (strpos($_SERVER['REQUEST_URI'], "search") !== false) {
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url_components['query'], $params);
    } else {
        header("location: ../index.php");
    }
    ?>
    <body class="overflow-y-hidden bg-gray-50">
        <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
        </navbar>
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
                                
                            </th>
                            <th scope='col' class='py-3 px-2'>
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $pageAmount = 5;
                            $offset = ($params['page'] - 1) * $pageAmount;

                            $paginatedItems = getSearchPagination($conn, $params['search'], $offset, $offset+$pageAmount);

                            if (count($paginatedItems) === 0) header("location: index.php");

                            for ($index = 0; $index < 5; $index++) {
                                $item = $paginatedItems[$index];
                                if ($item['name'] != "deleted") {
                                    echo "<tr class='border-b border-gray-200 dark:border-gray-700 text-center'>
                                            <th scope='row' class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap'>
                                                <img class='cursor-pointer hover:shadow-md rounded-full mx-auto' src='". $item['image_url'] ."' style='width:64px; height:64px'></img>
                                            </th>
                                            <th class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap'>
                                                ". $item['name'] ."
                                            </th>
                                            <td class='py-4 px-6'>
                                                ". $item['type'] ."
                                            </td>
                                            <td class='py-4 px-6 -50 dark:-800'>
                                                £". $item['price'] ."
                                            </td>
                                            <td class='py-4 px-6'>
                                                <a href='product.php?category=". $item['type'] ."&item=". $item['slug'] ."' class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>View</a>
                                            </td>
                                            <td class='py-4 px-2'>
                                                <button value='". $item['slug'] ."' class='bg-green-600 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-green-500 inline-block align-middle cursor-pointer'>Buy Now</button>
                                            </td>
                                        </tr>";
                                }
                            }
                        ?>
                    </tbody>    
                </table>
            </div>
            <?php
                echo "<div class='flex justify-center space-x-4 mt-4'>";
                if ($params['page'] > 1) echo "<a href='search.php?search=". $params['search'] ."&page=". $params['page'] - 1 ."' class='bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Back</a>";
                if (count($paginatedItems) > 4) echo "<a href='search.php?search=". $params['search'] ."&page=". $params['page'] + 1 ."' class='bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Next</a>";
                echo "</div>";
            ?>
        </div>
        <modal class="imageOverlay hidden">
            <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
                <img src='' class='w-1/3 h-1/2 mx-auto rounded-lg'></img>
                <button class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Hide Image</button>
            </div>
        </modal>

        <modal class="checkout hidden">
            <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
                <div class="bg-white w-1/4 items-center rounded-lg flex flex-col py-4 px-4">
                    <h1 class="w-full text-gray-800 font-bold text-2xl mb-1 text-center">Purchase Product</h1>
                    <form action="includes/basket-inc.php" method="post" class="w-1/2 h-full">
                        <input type="hidden" id="slug" name="slug" value=""/>
                        <input type="number" name="quantity" id="quantity" class="py-2 my-2 border-2 border-slate-400 rounded-md text-center w-full" value="1"/>
                        <button submit="submit" name="submit" value="continue" class='w-full mb-2 bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Add to cart</button>
                        <button submit="submit" name="submit" value="checkout" class='w-full bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Continue to checkout</button>
                    </form>
                </div>
                <button class='checkout-close bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Close</button>
            </div>
        </modal>
        <?php include_once 'views/components/footer.php'; ?>
    </body>
    <script src="views/js/store.js"></script>
</html>