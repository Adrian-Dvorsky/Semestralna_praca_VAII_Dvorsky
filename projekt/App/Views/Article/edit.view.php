<?php


/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>

<form method="post" action="<?= $link->url('article.saveEdit') ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="container">
        <input type="hidden" name="id" value="<?=$data['article']?->getId()?>'">
        <div class="mb-3">
            <label for="titleInlut" class="form-label input-title">Nadpis článku</label>
            <input type="text" class="form-control" id="titleInput" name="title" value="<?=$data['article']?->getTitle()?>">
        </div>
        <div class="mb-3">
            <label for="inputContent" class="form-label input-title">Obsah</label>
            <textarea class="form-control" id="inputContent" rows="3" style="height: 300px" name="content"> <?= htmlspecialchars($data['article']?->getContent() ?? '') ?></textarea>
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
            <label for="inputTags" class="form-label input-title">Tagy </label>
            <?php
                $selectedTags = \App\Models\ArticleTag::getAll('idArticle = ?', [$data['article']->getId()]);
                $selectedId = [];
                foreach ($selectedTags as $tag) {
                    $selectedId[] = $tag->getIdTag();
                }
            ?>
            <?php foreach ($data['tags'] as $tag): ?>
                <div class="form-check">
                    <input
                            class="form-check-input"
                            type="checkbox"
                            id="tag_<?= htmlspecialchars($tag->getId()) ?>"
                            name="tags[]"
                            value="<?= htmlspecialchars($tag->getId()) ?>"
                        <?php if (in_array($tag->getId(), $selectedId)): ?> checked <?php endif; ?>
                    >
                    <label class="form-check-label label-add" for="tag_<?= htmlspecialchars($tag->getId()) ?>">
                        <?= htmlspecialchars($tag->getName()) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mb-3">
            <label for="inputLinks" class="form-label input-title">Pridaj odkazy (jeden na riadok)</label>
            <input type="text" class="form-control" placeholder="https://example.com" id="inputLinks" name="link" value="<?=$data['article']?->getLink()?>">
        </div>
        <button type="submit" class="btn btn-primary">Vytvoriť príspevok</button>
    </div>
</form>


<script>
    window.onload = function() {
        tinymce.init({
            selector: '#inputContent',
            plugins: 'advlist autolink lists link charmap preview anchor',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent',
            menubar: false,
            height: 300
        });
    };

    function validateForm() {
        let title = document.getElementById('titleInput').value;
        let content = tinymce.get('inputContent').getContent();
        let image = document.getElementById('formFile').files[0];
        let link = document.getElementById('inputLinks').value;
        let urlRegex = /^(https?:\/\/)?([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})(:[0-9]+)?(\/[^\s]*)?$/;

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

        if (link.trim() !== "") {
            if (!urlRegex.test(link)) {
                alert('Odkaz nie je v správnom formáte.');
                return false;
            }
        }

        return true;
    }
</script>