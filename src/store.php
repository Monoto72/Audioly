<html>
<?php 
    $pageTitle = "Auidoly | Store";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    include_once 'views/components/head.php'; 

    if (strpos($_SERVER['REQUEST_URI'], "category") !== false) {
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url_components['query'], $params);
    } else {
        header("location: ../index.php");
    }
    ?>

<body class="h-screen overflow-x-hidden overflow-y-auto bg-gray-50 mb-10">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <?php
        if (count($params) < 2) {
            echo "<header class='h-1/3 bg-no-repeat bg-center bg-contain bg-gray-700 hidden md:block'
                    style='background-image: url(/media/". $params['category'] .".png)'>
                    <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center'>
                        <h1 class='text-5xl font-bold text-white font-mono'>". strtoupper($params['category']) ."</h1>
                    </div>
                </header>";
        }
    ?>
    <div class="text-center text-gray-800 py-4 px-2">
        <?php
                if ($params['category'] && count($params) === 1) {

                    $cssPadding = array(2, 4, 6, 4, 2);
                    $cssBottomPadding = array(2, 2, 4, 2, 2);

                    $topFiveItems = getTopFive($conn, $params['category']);

                    if (count($topFiveItems) === 0) header("location: index.php");

                    echo "<h1 class='text-2xl font-bold mt-0'>Featured Products</h1>";
                    echo "<main class='flex flex-col md:flex-row md:m-4 md:space-x-4 items-center justify-items-center'>";
                    
                    for ($index = 0; $index < count($topFiveItems); $index++) {
                        $item = $topFiveItems[$index];
                        if ($item['name'] != "deleted") {

                            echo "<a href='product.php?category=". $item["type"] ."&item=". $item['slug'] ."' class='h-80 w-3/4 md:w-1/4 rounded-md bg-white md:shadow-md md:p-4 hover:shadow-xl" ."'>
                                    <img src='". $item['image_url'] ."' class='w-60 h-40 mx-auto'></img>
                                    <h1 class='text-xl font-bold mt-2 h-25 text-ellipsis overflow-hidden'>". $item['name'] ."</h1>
                                    <hr class='mb-4 mt-2'>
                                    <h2 class='inset-x-0 bottom-0 text-xs font-bold mt-0 pb-4 md:pb-4 my-auto'>£". $item['price'] ."</h2>
                                </a>";
                        }
                    }

                    echo "</main>";
                    echo "<div class=''>
                            <a href='store.php?category=". $params['category'] ."&all=true&page=1' class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>View More</a>
                        </div>";

                } else if ($params['all'] && $params['page'] && count($params) === 3 ) {
                    echo "<div class='overflow-x-auto relative shadow-md sm:rounded-lg w-2/3 mx-auto'>
                        <table class='w-full text-sm text-gray-500 dark:text-gray-400 mt-6 table-auto'>
                            <thead class='text-xs text-gray-700 uppercase dark:text-gray-400 text-center'>
                                <tr>
                                    <th scope='col' class='py-3 px-6 bg-gray-50 dark:-800'>
                                        Product Image
                                    </th>
                                    <th scope='col' class='py-3 px-6 bg-gray-50 dark:-800'>
                                        Product name
                                    </th>
                                    <th scope='col' class='py-3 px-6'>
                                        Category
                                    </th>
                                    <th scope='col' class'py-3 px-6 bg-gray-50 dark:-800'>
                                        Price
                                    </th>
                                    <th scope='col' class='py-3 px-6'>
                                        
                                    </th>
                                    <th scope='col' class='py-3 px-2'>
                                        
                                    </th>
                                </tr>
                            </thead>
                        <tbody>";

                    $pageAmount = 5;
                    $offset = ($params['page'] - 1) * $pageAmount;

                    $paginatedItems = getCategoryPagination($conn, $params['category'], $offset, $offset+$pageAmount);
                    if (count($paginatedItems) === 0) header("location: index.php");

                    for ($index = 0; $index < count($paginatedItems); $index++) {
                        $item = $paginatedItems[$index];
                        if ($item['name'] != "deleted") {
                            echo "<tr class='border-b border-gray-200 dark:border-gray-700 text-center'>
                                    <th scope='row' class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:-800'>
                                        <img class='cursor-pointer hover:shadow-md rounded-full mx-auto' src='". $item['image_url'] ."' style='width:64px; height:64px'></img>
                                    </th>
                                    <th class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:-800'>
                                        ". $item['name'] ."
                                    </th>
                                    <td class='py-4 px-6'>
                                        ". $params['category'] ."
                                    </td>
                                    <td class='py-4 px-6 bg-gray-50 dark:-800'>
                                        £". $item['price'] ."
                                    </td>
                                    <td class='py-4 px-6'>
                                        <a href='product.php?category=". $params['category'] ."&item=". $item['slug'] ."' class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>View</a>
                                    </td>
                                    <td class='py-4 px-2'>
                                        <button value='". $item['slug'] ."' class='bg-green-600 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-green-500 inline-block align-middle cursor-pointer'>Buy Now</button>
                                    </td>
                                </tr>";
                        }
                    }

                    echo "</tbody></table>";
                    echo "</div>";

                    echo "<div class='flex justify-center space-x-4 mt-4'>";
                    $nextPageURL = "store.php?category=". $params['category'] ."&all=true&page=". ($params['page'] + 1);
                    $backPageURL = "store.php?category=". $params['category'] ."&all=true&page=". ($params['page'] - 1);

                    if ($params['page'] > 1) echo "<a href='". $backPageURL ."' class='bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>Back</a>";
                    if (count($paginatedItems) === 5) echo "<a href='". $nextPageURL ."' class='bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>Next</a>";
                    echo "</div>";
                }
            ?>

        <modal class="imageOverlay hidden">
            <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
                <img src='' class='w-1/3 h-1/2 mx-auto rounded-lg'></img>
                <button
                    class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Hide
                    Image</button>
            </div>
        </modal>

        <modal class="checkout hidden">
            <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
                <div class="bg-white w-1/4 items-center rounded-lg flex flex-col py-4 px-4">
                    <h1 class="w-full text-gray-800 font-bold text-2xl mb-1 text-center">Purchase Product</h1>
                    <form action="includes/basket-inc.php" method="post" class="w-1/2 h-full">
                        <input type="hidden" id="slug" name="slug" value="" />
                        <input type="number" name="quantity" id="quantity"
                            class="py-2 my-2 border-2 border-slate-400 rounded-md text-center w-full" value="1" />
                        <button submit="submit" name="submit" value="continue"
                            class='w-full mb-2 bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Add
                            to cart</button>
                        <button submit="submit" name="submit" value="checkout"
                            class='w-full bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Continue
                            to checkout</button>
                    </form>
                </div>
                <button
                    class='checkout-close bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Close</button>
            </div>
        </modal>
</body>
<?php include_once 'views/components/footer.php'; ?>
<script src="views/js/store.js"></script>

</html>