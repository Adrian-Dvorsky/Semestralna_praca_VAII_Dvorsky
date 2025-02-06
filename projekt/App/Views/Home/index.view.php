<?php

/** @var Array $data */
/** @var \App\Models\Post $post */
/** @var App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>
<?php if(isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 text-background">
            <div class="row">
                <div class="col-md-6 photos order-2 order-md-1">
                    <h1>Andromeda galaxia</h1>
                    <img src="public/images/andromeda.jpg" class="img-fluid" alt="andromeda galaxy">
                </div>
                <div class="col-md-6 photos order-1 order-md-2">
                    <p class="photos-description">
                        Veľká galaxia v Andromede je najpreskúmanejšia galaxia zo všetkých okrem Mliečnej dráhy. Má priemer 150 000 až 200 000 svetelných rokov a obsahuje vyše 450 miliárd hviezd. Jej hmotnosť je 360 miliárd hmotností Slnka. Je 2-krát väčšia a 3-krát hmotnejšia ako naša Galaxia. Okrem svetla vyžaruje aj rádiové a röntgenové žiarenie. Rovina M 31 je odklonená od zorného smeru o 15°. Pri takomto malom sklone nevynikne celkom jej špirálová štruktúra. Vzhľadom na veľkosť galaxie je jej jadro dosť malé – len 15 krát 30 svetelných rokov a má hmotnosť 160 miliónov hmotností Slnka. Jadro rotuje ako tuhé teleso, dynamicky nezávislé od ostatných častí galaxie.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 photos order-2 order-md-1">
                    <h1>Stĺpy stvorenia</h1>
                    <img src="public/images/pillar-of-creation.jpg" class="img-fluid" alt="andromeda galaxy">
                </div>
                <div class="col-md-6 photos order-1 order-md-2">
                    <p class="photos-description">
                        Jeden z najznámejších snímkov ďalekého vesmíru, ktorý zobrazuje takzvané Stĺpy stvorenia v Orlej hmlovine, sa po 27 rokoch dočkal novej verzie. Veľkolepé stĺpce prachu a plynov zachytil po svojom predchodcovi Hubblovom ďalekohľade do detailu vesmírny teleskop Jamesa Webba a zverejnila Európska kozmická agentúra (ESA) a americký Národný úrad pre letectvo a vesmír (NASA).
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/TijClV4uHIk?si=oXZCemoaY7ci3xbJ" title="YouTube video player" allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="video-size"></iframe>
            </div>
            <div class="ratio ratio-16x9">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/nGnX6GkrOgk?si=FE4BO2jAqd3Sce9N" title="YouTube video player" allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="video-size"></iframe>
            </div>
        </div>
    </div>
</div>