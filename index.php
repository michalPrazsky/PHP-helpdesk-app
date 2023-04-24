<?php

require "inc/db.php";

$pageTitle= "Úvod";

include "loginUser.php";
include "loginTechnician.php";

include "inc/header.php";

?>

<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="px-4 py-5 my-5  text-center">
            <div class="col-xl">
                <img class="d-block mx-auto mb-5 mt-5" src="inc/headphone.png" alt="" width="125" height="125">
                <h1 class="display-5 fw-bold">Vítejte v helpdeskové aplikaci pro správu požadavků</h1>
                <p class="lead mb-4">Pokud chcete zadat nový požadavek přihlaste se. Pokud ještě nemáte přístup
                do helpdeskové aplikace kontaktujte své IT oddělení o přidělení přístupu.</p>
                <button type="button" class="btn btn-success btn-lg px-4 gap-3 justify-content-center" data-bs-toggle="modal" data-bs-target="#myModalUser">Přihlásit jako uživatel</button>
                <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#myModalTechnician">Přihlásit jako technik</button>
            </div>
        </div>
    </div>
</section>



<div class="modal" id="myModalUser">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Přihlášení do aplikace jako uživatel</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Přihlašovací jméno:</label>
                        <input type="username" name="username" id="username" required class="form-control <?php echo htmlspecialchars($_SESSION['username']); ?>" value="<?php echo htmlspecialchars(@$_POST['username'])?>"/>
                        <?php
                        echo ($errors?'<div class="invalid-feedback">Neplatná kombinace přihlašovacího jména a hesla.</div>':'');
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Heslo:</label>
                        <input type="password" name="password" id="password" required class="form-control <?php echo ($errors?'is-invalid':''); ?>" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Přihlásit se</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Zavři</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal" id="myModalTechnician">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Přihlášení do aplikace jako technik</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Přihlašovací jméno:</label>
                        <input type="username" name="username" id="username" required class="form-control <?php echo ($errors?'is-invalid':''); ?>" value="<?php echo htmlspecialchars(@$_POST['username'])?>"/>
                        <?php
                        echo ($errors?'<div class="invalid-feedback">Neplatná kombinace přihlašovacího jména a hesla.</div>':'');
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Heslo:</label>
                        <input type="password" name="password" id="password" required class="form-control <?php echo ($errors?'is-invalid':''); ?>" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Přihlásit se</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Zavři</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php

require "inc/footer.php"



?>
