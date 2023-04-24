<?php

require "inc/db.php";

$pageTitle= "Homepage uživatele";

include "inc/header.php";

?>

<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="px-4 py-5 my-5  text-center">
            <div class="col-xl">
                <img class="d-block mx-auto mb-5 mt-5" src="inc/pc.png" alt="" width="125" height="125">
                <h2 class="display-5 fw-bold">Vítejte uživateli <?php echo htmlspecialchars($_SESSION['username']);?>,</h2>
                <p class="lead mb-4">Vyberte zdali chcete vytvořit nový požadavek či se podívat na své stávající.</p>
                <button type="button" onclick="window.location.href='TaskForm.php'" class="btn btn-success btn-lg px-4 gap-3 justify-content-center">Nový požadavek</button>
                <button type="button" onclick="window.location.href='UserTasks.php'" class="btn btn-outline-secondary btn-lg px-4">Mé požadavky</button>
            </div>
        </div>
    </div>
</section>
<?php

require "inc/footer.php"

?>
