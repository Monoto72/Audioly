<nav
    class="flex items-center justify-between flex-wrap bg-white py-4 lg:px-12 shadow border-solid border-t-2 border-blue-700">
    <div
        class="flex justify-between lg:w-auto w-full lg:border-b-0 pl-6 pr-2 border-solid border-b-2 border-gray-300 pb-5 lg:pb-0">
        <div class="flex items-center flex-shrink-0 text-gray-800 mr-16">
            <a href="index.php"><span class="font-semibold text-xl tracking-tight">Audioly</span></a>
        </div>
        <div class="block lg:hidden ">
            <button id="nav"
                class="flex items-center px-3 py-2 border-2 rounded text-blue-700 border-blue-700 hover:text-blue-700 hover:border-blue-700">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="menu w-full lg:block flex-grow lg:flex lg:items-center lg:w-auto lg:px-3 px-8">
        <div class="text-md font-bold text-blue-700 lg:flex-grow">
            <div class="dropdown inline-block relative">
                <button class="hover:text-white hover:bg-blue-700 py-2 px-4 rounded inline-flex items-center">
                    <span class="mr-1">Categories</span>
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /> </svg>
            </div>
            <ul class="dropdown-menu absolute hidden text-gray-700 pt-2 w-3/12 md:w-1/12">
                <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                        href="store.php?category=guitar">Guitar</a></li>
                <li class=""><a class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                        href="store.php?category=drums">Drums</a></li>
                <li class=""><a class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                        href="store.php?category=piano">Piano</a></li>
                <li class=""><a class="rounded-b bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                        href="store.php?category=studio">Studio</a></li>
            </ul>
        </div>
        <!-- This is an example component -->
        <div class="relative mx-auto text-gray-600 lg:block hidden">
            <form method="post" action="includes/search-inc.php" class="my-auto">
                <input class="border-2 border-gray-300 bg-white h-10 pl-2 pr-8 rounded-lg text-sm focus:outline-none"
                    type="search" name="search" placeholder="Search">
                <button type="submit" class="absolute right-0 top-0 mt-3 mr-2">
                    <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" version="1.1"
                        id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966"
                        style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                        <path
                            d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                </button>
            </form>
        </div>
        <div class="flex flex-col md:flex-row">
            <?php
            if (isset($_SESSION['cart'])) {
                if (count($_SESSION['cart']) != 0) {
                    echo '<a href="cart.php" class="block mt-4 lg:inline-block lg:mt-0 hover:text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">';
                        echo '<i class="fa fa-shopping-cart mr-2"></i>';
                        echo count($_SESSION['cart']);
                    echo '</a>';
                }
            }

            if (isset($_SESSION['userId'])) {
                echo '<div class="dropdown-profile inline-block">
                    <button class="hover:text-white hover:bg-blue-700 py-2 px-4 rounded inline-flex items-center">
                        <span class="mr-1">'. $_SESSION['username'] .'</span>
                    </div>
                    <ul class="dropdown-profile-menu absolute hidden text-gray-700 pt-2 w-1/2 md:w-1/12 mt-24 md:mt-10 right-90 md:right-10">
                        <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                                href="profile.php?id='. $_SESSION['userId'] .'">View Profile</a></li>';
                if ($_SESSION['adminLevel'] == 1) {
                    echo '<li class=""><a class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap hidden md:block"
                            href="admin.php">Admin Panel</a></li>';
                    }
                echo '<li class=""><a class="rounded-b bg-gray-200 hover:bg-red-500 py-2 px-4 block whitespace-no-wrap"
                                href="logout.php">Log Out</a></li>
                    </ul>
                    <script>
                        const dropdownProfile = document.querySelector(".dropdown-profile");
                        const dropdownProfileMenu = document.querySelector(".dropdown-profile-menu");
                
                        let dropdownProfileActive = false;
                
                        dropdownProfile.addEventListener("click", () => {
                
                            if (dropdownProfileMenu.classList.contains("hidden")) {
                                dropdownProfileMenu.classList.remove("hidden");
                                dropdownProfileActive = true;
                            } else {
                                dropdownProfileMenu.classList.add("hidden");
                                dropdownProfileActive = false;
                            }
                        });
                
                        document.body.addEventListener("click", (e) => {
                            if (dropdownProfileActive) {
                                if (!dropdownProfile.contains(e.target)) {
                                    dropdownProfileMenu.classList.add("hidden");
                                    dropdownProfileActive = false;
                                }
                            }
                        });
                    </script>';
            } else {
                echo '<a href="login.php" class="block mt-4 lg:inline-block lg:mt-0 hover:text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">
                        Login
                    </a>';
            }
            ?>
        </div>
    </div>

    <script>
        const dropdown = document.querySelector(".dropdown");
        const dropdownMenu = document.querySelector(".dropdown-menu");

        let dropdownActive = false;

        dropdown.addEventListener("click", () => {

            if (dropdownMenu.classList.contains("hidden")) {
                dropdownMenu.classList.remove("hidden");
                dropdownActive = true;
            } else {
                dropdownMenu.classList.add("hidden");
                dropdownActive = false;
            }
        });

        document.body.addEventListener("click", (e) => {
            if (dropdownActive) {
                if (!dropdown.contains(e.target)) {
                    dropdownMenu.classList.add("hidden");
                    dropdownActive = false;
                }
            }
        });

        const navButton = document.querySelector("#nav");
        const navMenu = document.querySelector(".menu");

        navButton.addEventListener("click", () => {
            if (navMenu.classList.contains("hidden")) {
                navMenu.classList.remove("hidden");
            } else {
                navMenu.classList.add("hidden");
            }
        });
    </script>

</nav>