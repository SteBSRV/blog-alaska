<h2>Modifier un épisode</h2>
<form action="" method="post">
  <p>
    <?= $form ?>
 
    <button type="submit" class="btn btn-primary">Valider</button>
  </p>
</form>

<!-- TinyMCE -->
<script src='/../../js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>