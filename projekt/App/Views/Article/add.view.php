<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>
<form method="post" action="<?= $link->url('article.save') ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="container">
      <div class="mb-3">
        <label for="titleInlut" class="form-label input-title">Nadpis článku</label>
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
        <label for="inputTags" class="form-label input-title">Tagy (oddelené čiarkami začinajúce #)</label>
        <input type="text" class="form-control" id="inputTags" placeholder="napr. #vesmír, #technológia, #planéty" name="tags">
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
        let content = document.getElementById('inputContent').value;
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