<!DOCTYPE html>
<html lang="cs">
<head>
    <title><?php echo (!empty($pageTitle)?$pageTitle.' - ':'')?>Helpdesk</title>
    <link rel="icon" href="inc/helpdesk.png">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<header>
    <nav class="navbar sticky-top navbar-light " style="background-color: #376E6F;">
        <div class="container-fluid">
            <a class="navbar-brand text-white px-4 pt-2" href="#">
            <img class="bi pb-2" src="inc/helpdesk.png" alt="" width="50" height="50">
                <span class="fs-3 fw-bold ms-2">HelpdeskApp</span>
            </a>
            <?php
            require_once 'inc/user.php';

            echo '<div class="text-end text-white">';
            if (!empty($_SESSION['technician_id'])){
                echo 'Technik: ';
                echo '<strong class="fs-4 mx-2 mt-2">'.htmlspecialchars($_SESSION['username']).'</strong>';
                echo '<a href="logout.php" class="btn btn-outline-light mb-1 mx-2">odhlásit se</a>';
            }
            elseif (!empty($_SESSION['user_id'])){
                echo 'Uživatel: ';
                echo '<strong class="fs-4 mx-2 mt-2">'.htmlspecialchars($_SESSION['username']).'</strong>';
                echo '<a href="logout.php" class="btn btn-outline-light mb-1 mx-2">odhlásit se</a>';
            }
            else{
                echo '<button type="button" class="btn btn-success btn-md  gap-3 mx-1" data-bs-toggle="modal" data-bs-target="#myModalUser">Přihlášení uživatel</button>';
                echo '<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#myModalTechnician">Přihlášení Technik</button>';
            }
            echo '</div>';
            ?>

        </div>
    </nav>
</header>