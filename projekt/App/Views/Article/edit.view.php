<?php


/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>
<form method="post" action="<?= $link->url('article.save') ?>" enctype="multipart/form-data">
    <div class="container">
        <input type="hidden" name="id" value="<?=$data['article']?->getId()?>'">
        <div class="mb-3">
            <label for="titleInlut" class="form-label input-title">Nadpis článku</label>
            <input type="text" class="form-control" id="titleInlut" name="title" value="<?=$data['article']?->getTitle()?>">
        </div>
        <div class="mb-3">
            <label for="inputContent" class="form-label input-title">Obsah</label>
            <textarea class="form-control" id="inputContent" rows="3" style="height: 300px" name="content">
                <?= htmlspecialchars($data['article']?->getContent() ?? '') ?>
            </textarea>
        </div>
        <?php if (!empty($data['article']?->getImage())): ?>
            <div class="mb-3">
                <label class="form-label input-title">Aktuálny obrázok</label>
                <div>
                    <img src="<?= \App\Helpers\FileStorage::UPLOAD_DIR . '/' . $data['article']->getImage() ?>"
                         alt="Aktuálny obrázok"
                         style="max-width: 100%; max-height: 200px; display: block; margin-bottom: 10px;">
                </div>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label input-title">Vlož obrázky</label>
            <input type="file" class="form-control" id="formFile" name="image" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="inputTags" class="form-label input-title">Tagy (oddelené čiarkami začinajúce #)</label>
            <input type="text" class="form-control" id="inputTags" placeholder="napr. #vesmír, #technológia, #planéty"
                   name="tags" value="<?=$data['article']?->getTags()?>">
        </div>
        <div class="mb-3">
            <label for="inputLinks" class="form-label input-title">Pridaj odkazy (jeden na riadok)</label>
            <input type="text" class="form-control" placeholder="https://example.com" id="inputLinks" name="link" value="<?=$data['article']?->getLink()?>">
        </div>
        <button type="submit" class="btn btn-primary">Vytvoriť príspevok</button>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        function validateForm() {
            let title = document.getElementById('titleInput').value;
            let content = document.getElementById('inputContent').value;
            let image = document.getElementById('formFile').files[0];

            if (title.trim() === "") {
                alert('Nadpis je povinný.');
                return false;
            }
            if (content.trim() === "") {
                alert('Obsah je povinný.');
                return false;
            }
            if (image) {
                let allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                if (!allowedTypes.includes(image.type)) {
                    alert('Obrázok musí byť vo formáte JPG, PNG alebo GIF.');
                    return false;
                }
            }
            return true;
        }
    });
</script>