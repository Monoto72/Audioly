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
    </body>
</html>