<html>
<?php 
    $pageTitle = "Auidoly | Home";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    include_once 'views/components/head.php'; 
    ?>

<body class="overflow-y-hidden">
    <navbar class="sticky top-0 z-50">
        <?php include_once 'views/components/navbar.php'; ?>
    </navbar>
    <header class='h-1/3 bg-no-repeat bg-center bg-contain bg-gray-700 hidden md:block'
        style='background-image: url(/media/landing.jpg)'>
        <div class='h-full w-full bg-black bg-opacity-50 flex flex-col justify-center items-center'>
            <h1 class='text-5xl font-bold text-white font-mono'>Audioly</h1>
        </div>
    </header>;
    <?php include_once 'views/components/footer.php'; ?>
</body>

</html>