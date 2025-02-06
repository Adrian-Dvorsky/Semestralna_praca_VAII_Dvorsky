<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>
<form method="post" action="<?= $link->url('article.save') ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="container">
      <div class="mb-3">
        <label for="titleInput" class="form-label input-title">Nadpis článku</label>
        <input type="text" class="form-control" id="titleInput" name="title">
      </div>
      <div class="mb-3">
        <label for="inputContent" class="form-label input-title">Obsah</label>
        <textarea class="form-control" id="inputContent" rows="3" style="height: 300px" name="content"></textarea>
      </div>
      <div class="mb-3">
        <label for="formFileMultiple" class="form-label input-title">Vlož obrázky</label>
          <input type="file" class="form-control" id="formFile" name="image" accept="image/*">
      </div>
    <div class="mb-3">
        <label for="inputTags" class="form-label input-title">Tagy </label>
            <?php foreach ($data['tags'] as $tag): ?>
                <div class="form-chech">
                    <input class="form-check-input" type="checkbox" id="tag_<?= htmlspecialchars($tag->getId()) ?>"  name="tags[]"  value="<?= htmlspecialchars($tag->getId()) ?>">
                        <label class="form-check-label label-add" for="tag_<?= htmlspecialchars($tag->getId()) ?>">
                            <?= htmlspecialchars($tag->getName()) ?>
                        </label>
                </div>
            <?php endforeach; ?>
    </div>
    <div class="mb-3">
        <label for="inputLinks" class="form-label input-title">Pridaj odkazy (jeden na riadok)</label>
        <textarea class="form-control" id="inputLinks" rows="3" placeholder="https://example.com" name="link"></textarea>
    </div>
      <button type="submit" class="btn btn-primary">Vytvoriť príspevok</button>
    </div>
</form>


<script>

    function validateForm() {
        let title = document.getElementById('titleInput').value;
        let content = tinymce.get('inputContent').getContent();
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

        if (link.trim() !== "") {
            if (!urlRegex.test(link)) {
                alert('Odkaz nie je v správnom formáte.');
                return false;
            }
        }

        return true;
    }
</script>

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
</script>