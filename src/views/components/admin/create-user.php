<modal>
    <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center fixed top-0'>
        <form class="bg-white w-1/3 items-center rounded-lg flex flex-col py-6" method="post" action="includes/signup-inc.php">
            <h1 class="w-2/3 text-gray-800 font-bold text-2xl mb-1 text-center">Create User</h1>
            <p class="w-2/3 text-sm font-normal text-gray-600 mb-7 justify-center text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input class="pl-2 outline-none border-none w-full" type="text" name="full-name" id="full-name"
                    placeholder="Full name" required/>
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input class="pl-2 outline-none border-none w-full" type="text" name="username" id="username"
                    placeholder="Username" required/>
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl mb-4">
                <input id="bordered-checkbox-1" type="checkbox" value="" name="bordered-checkbox" class="w-4 h-4">
                <label for="bordered-checkbox-1" class="ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Admin | <span class="text-gray-600">This will determine if the user is allowed to view the panel.</span></label>
            </div>
            <div class="w-2/3 flex items-center border-2 py-2 px-3 rounded-2xl">
                <input class="pl-2 outline-none border-none w-full" type="password" name="password" id="password"
                    autocomplete="on" placeholder="Password" required/>
            </div>
            <button type="submit" name="submit" id="submit"
                class="w-2/3 block bg-green-600 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Make
                Account</button>
        </form>
        <a href="admin.php?content=users" class='bg-gray-800 text-white font-bold mt-2 py-2 px-4 rounded-full hover:-700 inline-block align-middle cursor-pointer'>Close</a>
    </div>
</modal>