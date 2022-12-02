<html>
<?php 
    $page_title = "Auidoly | Store";

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

<body class="h-screen overflow-x-hidden overflow-y-auto bg-gray-50">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <?php
        if (count($params) !== 2) {
            echo "<header class='h-1/3 bg-no-repeat bg-center bg-contain bg-gray-700 hidden md:block'
                    style='background-image: url(../media/". $params['category'] .".png)'>
                    <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center'>
                        <h1 class='text-5xl font-bold text-white font-mono mr-60'>". strtoupper($params['category']) ."</h1>
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
                    echo "<main class='flex flex-col md:flex-row md:m-4 space-y-4 md:space-x-4 items-center justify-items-center'>";
                    
                    for ($index = 0; $index < count($topFiveItems); $index++) {
                        $item = $topFiveItems[$index];

                        echo "<a href='product.php?category=". $item["type"] ."&item=". $item['slug'] ."' class='w-3/4 md:w-1/4 rounded-md bg-white md:shadow-md md:p-" . $cssPadding[$index] . " hover:shadow-xl'>
                                <img src='". $item['image_url'] ."' class='w-60 h-40 mx-auto'></img>
                                <h1 class='text-xl font-bold mt-2'>". $item['name'] ."</h1>
                                <p class='text-sm font-normal text-gray-600 mb-7 hidden md:block'>". $item['description'] ."</p>
                                <hr class='mb-4'>
                                <h2 class='text-xs font-bold mt-0 pb-4 md:pb-" . $cssBottomPadding[$index] . " my-auto'>£". $item['price'] ."</h2>
                            </a>";
                    }

                    echo "</main>";
                    echo "<div class=''>
                            <a href='store.php?category=". $params['category'] ."&all=true' class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>View More</a>
                        </div>";

                } else if ($params['all'] && count($params) === 2) {
                    echo "<header class='overflow-x-auto relative shadow-md sm:rounded-lg w-2/3 mx-auto'>
                        <table class='w-full text-sm text-gray-500 dark:text-gray-400 mt-6 table-auto'>
                            <thead class='text-xs text-gray-700 uppercase dark:text-gray-400 text-center'>
                                <tr>
                                    <th scope='col' class='py-3 px-6 bg-gray-50 dark:bg-gray-800'>
                                        Product Image
                                    </th>
                                    <th scope='col' class='py-3 px-6 bg-gray-50 dark:bg-gray-800'>
                                        Product name
                                    </th>
                                    <th scope='col' class='py-3 px-6'>
                                        Category
                                    </th>
                                    <th scope='col' class'py-3 px-6 bg-gray-50 dark:bg-gray-800'>
                                        Price
                                    </th>
                                    <th scope='col' class='py-3 px-6'>
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>";

                    //$allItems = getAllItems($conn, $params['category']);

                    //if (count($allItems) === 0) header("location: index.php");

                    for ($index = 0; $index < 7; $index++) {
                        echo "<tr class='border-b border-gray-200 dark:border-gray-700 text-center'>
                                <th scope='row' class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800'>
                                    <img class='cursor-pointer hover:shadow-md rounded-full mx-auto' src='../media/categories/". $params['category'] . "/". $params['category']."-". $index+1 .".jpg' style='width:64px; height:64px'></img>
                                </th>
                                <th class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800'>
                                    Apple MacBook Pro 17
                                </th>
                                <td class='py-4 px-6'>
                                    Guitar
                                </td>
                                <td class='py-4 px-6 bg-gray-50 dark:bg-gray-800'>
                                    $2999
                                </td>
                                <td class='py-4 px-6'>
                                    <a href='product.php?category=". $params['category'] ."&item=". $params['category']."-". $index+1 ."' class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>View</a>
                                </td>
                            </tr>";
                    }

                    echo "</tbody></table>";
                    echo "</main></div>";

                    echo "<div class='flex justify-center space-x-4 mt-4'>
                            <a href='#' class='bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>Back</a>
                            <a href='#' class='bg-gray-800 text-white font-bold py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>Next</a>
                        </div>";
                }
            ?>

    <modal class="overlay hidden">
        <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
            <img src='' class='w-1/3 h-1/2 mx-auto rounded-lg'></img>
            <button class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>Hide Image</button>
        </div>`
    </modal>
</body>
<script>
    const storeHTML = document.querySelector('html');
    const storeBody = document.querySelector('body');
    const modal = document.querySelector('modal');

    let imageOverlay = false;

    const storeImages = document.querySelectorAll('img').forEach(img => {
        img.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            imageOverlay = true;

            storeBody.classList.add('overflow-y-hidden');

            modal.querySelector('img').src = img.src;
        });
    });

    const storeImageButton = modal.querySelector('button').addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        imageOverlay = false;

        storeBody.classList.remove('overflow-y-hidden');
    });

</script>
</html>