<?php
    if (strpos($_SERVER['REQUEST_URI'], "content") !== false) {
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url_components['query'], $params);

        $product = getProduct($conn, $params['item']);
    }
?>

<modal class="z-40">
    <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
        <form class="bg-white w-1/3 items-center rounded-lg flex flex-col py-6" method="post"
            action="includes/product-inc.php" enctype="multipart/form-data">
            <input type="hidden" id="form-type" name="form-type" value="edit"/>
            <h1 class="w-2/3 text-gray-800 font-bold text-2xl mb-1 text-center">Edit Product</h1>
            <p class="w-2/3 text-sm font-normal text-gray-600 mb-7 justify-center text-center">Lorem ipsum dolor sit
                amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input class="pl-2 outline-none border-none w-full" type="text" name="name" id="name"
                    placeholder="Product name" value="<?php echo $product['name'] ?>" required />
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <textarea class="pl-2 outline-none border-none w-full" type="text" name="description" id="description"
                    placeholder="Description" required></textarea>
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <span class="pl-2">£</span>
                <input class="pl-2 outline-none border-none w-full" type="number" name="price" id="price"
                    placeholder="Price" value="<?php echo $product['price'] ?>" required />
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <select class="w-full outline-none border-none" name="category" id="category" required>
                    <option value="guitar" <?php if ($product['type'] === 'guitar') echo 'selected' ?>>Guitar</option>
                    <option value="drums" <?php if ($product['type'] === 'drums') echo 'selected' ?>>Drums</option>
                    <option value="piano" <?php if ($product['type'] === 'piano') echo 'selected' ?>>Piano</option>
                    <option value="studio" <?php if ($product['type'] === 'studio') echo 'selected' ?>>Studio</option>
                </select>
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input class="pl-2 outline-none border-none w-full" type="text" name="file-url" id="file-url"
                    placeholder="Image URL" value="<?php echo $product['image_url'] ?>" required />
            </div>
            <p class="flex flex-col mt-1 text-sm text-gray-500 text-center" id="file-help">Please provide a link to the Image, for example, <a class="text-blue-600 text-bold" href="https://imgur.com/upload">Imgur</a> (MAX.
                800x400px).</p>
            <button type="submit" name="submit" id="submit"
                class="w-2/3 block bg-green-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Edit
                Product</button>
        </form>
        <a href="admin.php?content=products"
            class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:bg-gray-700 inline-block align-middle cursor-pointer'>Close</a>
    </div>
</modal>

<script>
    const textArea = document.querySelector('textarea');
    // Why does HTML not allow for value to be set in the textarea???????????? Big stupid
    textArea.value = `<?php echo $product['description'] ?>`;
</script>