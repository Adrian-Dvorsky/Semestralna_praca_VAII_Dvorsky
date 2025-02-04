<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 left-bar">
            <div class="mini-box">
                <h1>Súkromníci pokorili vládny sektor. SpaceX za dva roky strojnásobil počet štartov rakiet</h1>
                <p class="mini-box-content">Vypúšťanie rakiet do vesmíru je drahý biznis. V minulosti to bolo také nákladné, že astronautov a satelity prepravovali výlučne vládne vesmírne agentúry. V posledných rokoch súkromný vesmírny priemysel zažíva rozmach, zdôrazňuje portál statista.com.

Súkromné spoločnosti, najmä Virgin Galactic Richarda Bransona, Blue Origin Jeffa Bezosa a SpaceX Elona Muska, spustili vlastné projekty, ktoré ponúkajú rôzne stupne suborbitálnej a orbitálnej vesmírnej dopravy. Podľa dát Bryce Tech vypustili v roku 2023 viac ako 180 rakiet, pričom samotná SpaceX vyslala na orbitálnu dráhu 96 rakiet, nasledovaná čínskou CASC so 45 štartmi.
                </p>
                <p class="description">
Autor: Jožko Mrkvička
</p>
                <div style="text-align: right">
                    <a style="text-align: right" href="https://www.nasa.gov/wp-content/uploads/2023/03/pillars_of_creation.jpg"> Obrázok </a>
                </div>
            </div>
            <div class="mini-box">
                <h1>Slovenská republika bude mať národný register vesmírnych objektov</h1>
                <p class="mini-box-content">Slovenská republika zriadi národný register vesmírnych objektov. Zapisovať sa tam budú všetky vesmírne objekty, pre ktoré je Slovenská republika vypúšťajúcim štátom a majú platné povolenie. Spravovať a prevádzkovať register bude Ministerstvo dopravy. Vyplýva to z návrhu zákona o regulácii vesmírnych aktivít, ktorý v stredu schválila vláda.

Zákon o regulácii vesmírnych aktivít ma ustanoviť jasné pravidlá v súlade s dohovormi Organizácie spojených národov, ktoré vytvárajú celosvetový základný právny rámec pre výkon vesmírnych aktivít a ktorých je Slovensko zmluvnou stranou.

Nová legislatíva má upraviť vydávanie povolení pre výkon regulovaných vesmírnych aktivít, ich zmenu a ukončenie a tiež regresný nárok štátu pre prípad vzniku škody spôsobenej vesmírnym objektom. Upravené sú tu podmienky výkonu štátneho dohľadu a bezpečnosti i proces registrácie vesmírnych objektov.
                </p>
                <p class="description">
Autor: Dvoro37
</p>
                <div style="text-align: right">
                    <a style="text-align: right" href="https://www.nasa.gov/wp-content/uploads/2023/03/pillars_of_creation.jpg"> Obrázok </a>
                </div>
            </div>
            <div class="mini-box">
                <h1>Vesmírny AST SpaceMobile konkuruje SpaceX so závratným rastom akcií o 1 800 percent</h1>
                <p class="mini-box-content">Za posledných šesť mesiacov vzrástla hodnota akcií AST SpaceMobile z dvoch na 28 dolárov, čím sa spoločnosť zaradila medzi najúspešnejšie firmy sveta. Tento dynamický rast urobil z AST konkurenta SpaceX s projektom Starlink, pričom kľúčový okamih je na obzore.

Spoločnosť totiž vypustí svojich prvých päť komerčných satelitov na nízku obežnú dráhu Zeme. Štart sa uskutoční z Cape Canaveral na Floride a zaujímavosťou je, že na vynesenie satelitov použije tím AST raketu konkurenčnej SpaceX. Družice majú následne slúžiť na vysokorýchlostné 5G pripojenie k internetu a zrejme v tom sú príčiny rastu popularity novej konkurencie Elona Muska.

Akcie AST od apríla, keď dosiahli rekordné dvojdolárové minimum, vzrástli o približne 1 300 percent na súčasnú hodnotu 28 dolárov. V priebehu tohto obdobia však zaznamenali ešte výraznejší rast. Svoj vrchol dosiahli 19. augusta, kedy sa vyšplhali až na 38,60 dolára, čo predstavuje nárast o viac ako 1 800 percent od aprílového minima.
                </p>
                <p class="description">
Autor: OpticFree
</p>
                <div style="text-align: right">
                    <a style="text-align: right" href="https://www.nasa.gov/wp-content/uploads/2023/03/pillars_of_creation.jpg"> Obrázok </a>
                </div>
            </div>

            <?php foreach($data['articles'] as $article):?>
                <div id="article-<?= $article->getId() ?>"  class="mini-box">
                    <h1>
                        <?= $article->getTitle()?>
                    </h1>
                    <p class="mini-box-content">
                        <?= htmlspecialchars_decode($article->getContent()) ?>
                    </p>
                    <?php if (!empty($article->getImage())): ?>
                        <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . htmlspecialchars($article->getImage()) ?>" class="img-fluid article-image" alt="Article Image">
                    <?php endif; ?>
                    <a href="<?= htmlspecialchars($article->getLink()) ?>" target="_blank" rel="noopener noreferrer" style="display: block; text-align: left; margin-left: 0;">Odkaz</a>
                    <p style="text-align: left">
                        <?php
                        $tags = \App\Models\ArticleTag::getAll('idArticle = ?', [$article->getId()]);
                            if (!empty($tags)) {
                                $tagsName = [];
                                foreach ($tags as $tag) {
                                    $tagObj = \App\Models\Tag::getOne($tag->getIdTag());
                                    $name = '#' . $tagObj->getName();
                                    $tagsName[] = $name;
                                }
                                echo implode(', ', $tagsName);
                            }

                        ?>
                    </p>
                    <p class="description">
                        autor: <?= htmlspecialchars($article->getAuthor()) ?>
                    </p>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] == $article->getAuthor()): ?>
                        <div class="article-buttons">
                            <button type="button" class="btn btn-danger delete-article" data-id="<?= $article->getId() ?>">Delete</button>
                            <form method="post" action="<?= $link->url('article.edit') ?>" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $article->getId() ?>">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach;?>
    </div>
    <div class="main-box col-md-6">
Treba dorobiť informácie o používateľovi, príspevkov ....
    </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-article').forEach(button => {
        button.addEventListener('click', function () {
            let articleId = this.getAttribute('data-id');
            fetch('http://localhost/?c=article&a=delete&id=' + articleId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + articleId
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('article-' + articleId).remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Chyba:', error));
        });
    });
</script>