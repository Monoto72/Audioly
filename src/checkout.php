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
    <header class="w-full">
        <div class="leading-loose flex flex-col justify-center items-center mb-6">
            <form method="post" action="" class="max-w-xl m-4 p-10 bg-white rounded shadow-xl">
                <p class="text-gray-800 font-medium">Customer information</p>
                <div class="">
                    <label class="text-sm text-gray-00" for="name">Name</label>
                    <input class="w-full px-2 py-1 text-gray-700 bg-gray-200 rounded" id="name" name="name"
                        type="text" required placeholder="Your Name" value="<?php if (isset($_SESSION['userId'])) echo $_SESSION['fullName']; ?>">
                </div>
                <div class="mt-2">
                    <label class="text-sm text-gray-600" for="email">Email</label>
                    <input class="w-full px-2 py-1 text-gray-700 bg-gray-200 rounded" id="email" name="email"
                        type="text" required placeholder="Your Email" value="<?php if (isset($_SESSION['userId'])) echo $_SESSION['email']; ?>">
                </div>
                <div class="mt-2">
                    <label class="text-sm text-gray-600" for="address">Address</label>
                    <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="address" name="address"
                        type="text" required placeholder="Street" value="<?php if (isset($_SESSION['billingAddress'])) echo $_SESSION['billingAddress']['address']; ?>">
                </div>
                <div class="mt-2">
                    <label class="hidden text-sm text-gray-600" for="city">City</label>
                    <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="city" name="city"
                        type="text" required placeholder="City" value="<?php if (isset($_SESSION['billingAddress'])) echo $_SESSION['billingAddress']['city']; ?>">
                </div>
                <div class="inline-block mt-2 w-1/2 pr-1">
                    <label class="hidden text-sm text-gray-600" for="country">Country</label>
                    <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="country" name="country"
                        type="text" required placeholder="Country" value="<?php if (isset($_SESSION['billingAddress'])) echo $_SESSION['billingAddress']['country']; ?>">
                </div>
                <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                    <label class="hidden text-sm text-gray-600" for="post-code">Post Code</label>
                    <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="post-code" name="post-code"
                        type="text" required placeholder="Post Code" value="<?php if (isset($_SESSION['billingAddress'])) echo $_SESSION['billingAddress']['postCode']; ?>">
                </div>
                <p class="mt-4 text-gray-800 font-medium">Payment information</p>
                <div class="">
                    <label class="text-sm text-gray-600" for="card-number">Card</label>
                    <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="card-number" name="card-number"
                        type="number" required="" placeholder="Card Number" aria-label="Name">
                </div>
                <div class="inline-block mt-2 w-1/2 pr-1">
                    <label class="hidden text-sm text-gray-600" for="country">Expiry Date</label>
                    <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="exp-date" name="exp-date"
                        type="text" required placeholder="Expiry Date">
                </div>
                <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                    <label class="hidden text-sm text-gray-600" for="cvv">CVV</label>
                    <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cvv" name="cvv"
                        type="number" required placeholder="CVV">
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" required><span
                            class="ml-2 text-gray-700">I agree to the <a href="tos.php"
                                class="underline">Terms and Conditions</a></span>
                    </label>
                <div class="mt-4">
                    <button class="px-4 py-1 text-white text-bold tracking-wider bg-gray-900 rounded w-full"
                        type="submit">£<?php if (isset($_SESSION['userId'])) { echo getCartTotal($conn)[0]['total']; } else { echo getCartTotalUnlogged(); }?></button>
                    <button class="px-4 py-1 text-white text-bold tracking-wider bg-indigo-500 hover:bg-indigo-600 rounded w-full my-2"
                        type="submit">PayPal</button>
                </div>
            </form>
        </div>
    </header>
    <?php include_once 'views/components/footer.php'; ?>
</body>

</html>