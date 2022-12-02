<html>
    <?php 
    $page_title = "Auidoly | Store";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    include_once 'views/components/head.php'; 
    ?>
    <body class="md:overflow-y-hidden overflow-x-hidden h-screen">
        <navbar>
        <?php include_once 'views/components/navbar.php'; ?>
        </navbar>
        <div class="text-center bg-gray-50 text-gray-800 py-4 px-2 h-screen">
                <?php
                if (strpos($_SERVER['REQUEST_URI'], "item") !== false) {
                    $url_components = parse_url($_SERVER['REQUEST_URI']);
                    parse_str($url_components['query'], $params);

                    echo '<h1 class="text-1xl font-bold text-slate-400 text-left ml-10 mb-4 hidden md:block">
                            <a href="index.php">home</a> /
                            <a href="store.php?category='. $params['category'] .'">'. $params['category'] .'</a>  /
                            <a class="pointer-events-none text-slate-500"> '. $params['item'] .' </a>
                        </h1>
                        <hr>
                        <main class="flex flex-col md:flex-row md:m-4 space-y-4 md:space-x-4 items-center justify-items-center">
                        </main>';

                    $item = getProduct($conn, $params['item']);

                    echo '<div class="flex flex-col md:flex-row md:m-4 space-y-4 md:space-x-16 items-center justify-center w-full">
                        <div class="flex flex-col items-center justify-items-center w-1/4">
                            <h1 class="text-2xl font-bold text-slate-400">'. $item['name'] .'</h1>
                            <p class="text-xl font-bold text-slate-400">'. $item['description'] .'</p>
                        </div>
                        <div class="flex flex-col items-center justify-items-center md:w-fit shadow-xl">
                            <img src="'. $item['image_url'] .'" alt="'. $item['name'] .'" class="w-48 h-48 md:w-96 md:h-96">
                        </div>
                        <div class="flex flex-col items-center justify-items-center w-1/4">
                            <p class="text-xl font-bold text-slate-400">£'. $item['price'] .'</p>
                            <p class="text-xl font-bold text-black mb-4">★★★★☆</p>
                            <form class="flex flex-col">
                                <input type="number" name="quantity" id="quantity" class="py-2 px-4 border-2 border-slate-400 rounded-md text-center" value="1">
                                <br>
                                <button type="submit" class=" bg-slate-400 text-white font-bold py-2 px-4 rounded">Add to cart</button>
                            </form>
                        </div>
                    </div>';
                }
                ?>

        </div>
    </body>
</html>