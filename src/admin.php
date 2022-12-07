<html>
    <?php 
    $pageTitle = "Auidoly | Dashboard";

    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';

    if (strpos($_SERVER['REQUEST_URI'], "content") !== false) {
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url_components['query'], $params);

        $pageTitle = "Auidoly | ". $params['content'];

        if (count($params) === 2) {
            switch ($params['action']) {
                case 'create user':
                    $pageTitle = "Auidoly | Create User";
                    include_once 'views/components/admin/create-user.php';
                    break;
                default:
                    $pageTitle = "Auidoly | Dashboard";
                    break;
            }
        }
    } else {
        $pageTitle = "Auidoly | Dashboard";
    }
    
    include_once 'views/components/head.php';

    ?>
    <body class="overflow-y-hidden flex flex-row">
        <navbar>
        <?php include_once 'views/components/admin/navbar.php'; ?>
        </navbar>
        <section class="w-full flex flex-col">
            <h1 class='text-5xl font-bold mr-60 ml-4'>User Panel</h1>
            <div class="flex flex-row justify-center">
                <a href="admin.php?content=users&action=create user" class="bg-slate-400 text-white font-bold py-2 px-4 rounded m-4">Create User</a>
        </section>
    </body>
</html>