<?php
foreach ($comments as $comment)
{
	?>
	<fieldset class="level-<?= $comment->getLevel()?>">
	  <legend>
	    Posté par <strong><?= htmlspecialchars($comment->getAuthor()) ?></strong> le <?= $comment->getDate()->format('d/m/Y à H\hi') ?>
	    <?php if ($user->isAuthenticated()) { ?> -
			<a href="admin/comment-update-<?= $comment->getId() ?>.html">Modifier</a> |
			<a href="admin/comment-delete-<?= $comment->getId() ?>.html">Supprimer</a> |
	    <?php } ?>
	    	<a href="/comment-report-<?= $comment->getId() ?>.html">Signaler</a>
	  </legend>
	  <p><?= nl2br(htmlspecialchars($comment->getMessage())) ?></p>
	  <?php if ($comment->getLevel() < 3) {?><p style="text-align: right;"><small><em><a href="/commenter-reponse-<?= $comment->getId() ?>.html">Répondre</a></em></small></p><?php }?>
	</fieldset>
<?php
}
?>