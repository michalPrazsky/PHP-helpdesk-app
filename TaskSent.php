<?php

require "inc/db.php";

$pageTitle= "Zadat nový task";

include "inc/header.php";

?>



<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="px-4 py-5 my-5  text-center">
            <div class="col-xl">
                <img class="d-block mx-auto mb-5 mt-5" src="inc/rating.png" alt="" width="125" height="125">
                <h1 class="display-5 fw-bold">Váš požadavek byl zaevidován, Děkujeme!</h1>
                <p class="lead mb-4">Pokusíme se Váš požadavek vyřešit co nejdříve a nejlépe.</p>
                <button type="button" onclick="window.location.href='UserTasks.php'" class="btn btn-success btn-lg px-4">Zobrazit mé požadavky</button>
                <button type="button" onclick="window.location.href='user_index.php'" class="btn btn-outline-secondary btn-lg px-4 gap-3 justify-content-center">Zpět</button>
            </div>
        </div>
    </div>
</section>


<?php

require "inc/footer.php"

?>