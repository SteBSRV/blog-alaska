<article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10">
                	<p>Par <em><?php echo $episodes->getAuthor();?></em>, le <?php echo $episodes->getAddDate()->format('d/m/Y à H\hi');?></p>
					<h2><?php echo $episodes->getTitle();?></h2>
					<p><?php echo (nl2br($episodes->getContent()));?></p>

					<p style="text-align: right;">
					<?php if ($episodes->getAddDate() != $episodes->getModDate()) { ?>
					  <span><small><em>Modifiée le <?php echo $episodes->getModDate()->format('d/m/Y à H\hi');?></em></small></span><br/>
					<?php }
					if ($user->isAuthenticated() === true) {
						echo '<span><a href="/admin/episode-update-' . $episodes->getId() . '.html">Modifier</a></span>';
					} ?>
					</p>
					<?php
					if (empty($comments)) {
					?>
					<p class="comment-empty">Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
					<?php
					}

					// Affichage lien en haut et en bas si "beaucoup" de commentaires sont présents
					if ($nbrComments >= 5) { ?>
						<p><a href="commenter-<?= $episodes->getId() ?>.html">Ajouter un commentaire</a></p> 
					<?php }

					require('comments.php'); ?>
					 
					<p><a href="commenter-<?= $episodes->getId() ?>.html">Ajouter un commentaire</a></p> 
                </div>
            </div>
        </div>
</article>
