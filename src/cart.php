<html>
<?php 
    $pageTitle = "Auidoly | Search";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    include_once 'views/components/head.php'; 

    if (count($_SESSION['cart']) == 0) {
        header("location: index.php");
    }
    ?>

<body class="overflow-y-hidden">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <div class="text-center text-gray-800 py-4 px-2">
        <header class='overflow-x-auto relative shadow-md sm:rounded-lg w-2/3 mx-auto'>
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
                            Quantity
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
                            for ($index = 0; $index < count($_SESSION['cart']); $index++) {
                                $item = $_SESSION['cart'][$index];
                                echo "<tr class='border-b border-gray-200 dark:border-gray-700 text-center'>
                                        <form method='post'>
                                            <input type='hidden' name='slug' value='". $item['slug'] ."'></input>
                                            <th scope='row' class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap'>
                                                <img class='cursor-pointer hover:shadow-md rounded-full mx-auto' src='". $item['image_url'] ."' style='width:64px; height:64px'></img>
                                            </th>
                                            <th class='py-4 px-6 font-medium text-gray-900 whitespace-nowrap'>
                                                ". $item['name'] ."
                                            </th>
                                            <td class='py-4 px-6'>
                                                <input type='number' name='quantity' value='". $item['quantity'] ."' min='0' max='99'></input>
                                            </td>
                                            <td class='py-4 px-6 -50 dark:-800'>
                                                £". $item['quantity'] * $item['price'] ."
                                            </td>
                                            <td class='py-4 px-6'>
                                                <a href='product.php?category=". $item['type'] ."&item=". $item['slug'] ."' class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>View</a>
                                            </td>
                                            <td class='py-4 px-2'>
                                                <button submit='submit' name='submit' value='update' class='bg-green-600 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-green-500 inline-block align-middle cursor-pointer'>Update</button>
                                            </td>
                                        </form>
                                    </tr>";
                            }
                        ?>
                </tbody>
            </table>
        </header>
        <div class='w-2/3 mx-auto'>
            <a href='checkout.php'
                class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Continue
                to Checkout</a>
        </div>
        <modal class="imageOverlay hidden">
            <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
                <img src='' class='w-1/3 h-1/2 mx-auto rounded-lg'></img>
                <button
                    class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Hide
                    Image</button>
            </div>
        </modal>
        <?php
            if (isset($_POST['submit'])) {
                $quantity = $_POST['quantity'];
                $slug = $_POST['slug'];

                updateUserCart($conn, $quantity, $slug);

                header("location: cart.php");
            }
        ?>
        <?php include_once 'views/components/footer.php'; ?>
</body>

</html>