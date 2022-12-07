<modal>
    <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
        <form class="bg-white w-full md:w-1/3 items-center rounded-lg flex flex-col py-6" method="post" action="includes/billing-inc.php">
            <h1 class="w-2/3 text-gray-800 font-bold text-2xl mb-1 text-center"><?php echo ucfirst($billingType). " Billing Address" ?></h1>
            <p class="w-2/3 text-sm font-normal text-gray-600 mb-7 justify-center text-center"><b>Important!</b> It is vital that your billing address is correct, otherwise you will most likely not recieve the product.</p>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input class="pl-2 outline-none border-none w-full" type="text" name="address" id="address"
                    placeholder="Address" required value="<?php if ($billingType == "edit") echo $_SESSION['billingAddress']['address'] ?>">
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input class="pl-2 outline-none border-none w-full" type="text" name="city" id="city"
                    placeholder="City" required value="<?php if ($billingType == "edit") echo $_SESSION['billingAddress']['city'] ?>">
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input class="pl-2 outline-none border-none w-full" type="text" name="post-code" id="post-code"
                    placeholder="Post Code" required value="<?php if ($billingType == "edit") echo $_SESSION['billingAddress']['postCode'] ?>">
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl">
                <input class="pl-2 outline-none border-none w-full" type="text" name="country" id="country"
                    placeholder="Country" required value="<?php if ($billingType == "edit") echo $_SESSION['billingAddress']['country'] ?>">
            </div>
            <button type="submit" name="submit" id="submit"
                class="w-2/3 block bg-green-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">
                Submit </button>
        </form>
        <a href="profile.php?id=<?php echo $_SESSION['userId'] ?>" class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Close</a>
    </div>
</modal>