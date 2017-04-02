<article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10">
                	 <p>Par <em><?php echo $episodes->getAuthor();?></em>, le <?php echo $episodes->getAddDate()->format('d/m/Y à H\hi');?></p>
					<h2><?php echo $episodes->getTitle();?></h2>
					<p><?php echo (nl2br($episodes->getContent()));?></p>

					<?php if ($episodes->getAddDate() != $episodes->getModDate()) { ?>
					  <p style="text-align: right;"><small><em>Modifiée le <?php echo $episodes->getModDate()->format('d/m/Y à H\hi');?></em></small></p>
					<?php } ?>

					<?php
					if (empty($comments))
					{
					?>
					<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
					<?php
					}
					 
					foreach ($comments as $comment)
					{
					?>
					<fieldset>
					  <legend>
					    Posté par <strong><?= htmlspecialchars($comment->getAuthor()) ?></strong> le <?= $comment->getDate()->format('d/m/Y à H\hi') ?>
					    <?php if ($user->isAuthenticated()) { ?> -
					      <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
					      <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
					    <?php } ?>
					  </legend>
					  <p><?= nl2br(htmlspecialchars($comment->getMessage())) ?></p>
					</fieldset>
					<?php
					}
					?>
					 
					<p><a href="commenter-<?= $episodes->getId() ?>.html">Ajouter un commentaire</a></p> 
                </div>
            </div>
        </div>
</article>
