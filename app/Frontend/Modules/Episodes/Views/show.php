<article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10">
                	 <p>Par <em><?php echo $episodes->getAuthor();?></em>, le <?php echo $episodes->getAddDate()->format('d/m/Y à H\hi');?></p>
					<h2><?php echo $episodes->getTitle();?></h2>
					<p><?php echo (nl2br($episodes->getContent()));?></p>

					<?php if ($episodes->getAddDate() != $episodes->getModDate()) { ?>
					  <p style="text-align: right;"><small><em>Modifiée le <?php echo $episodes->getModDate()->format('d/m/Y à H\hi');?></em></small></p>
					<?php }
					if ($user->isAuthenticated() === true) {
						echo '<a href="/admin/episode-update-' . $episodes->getId() . '.html"><em>Modifier</em></a>';
					}

					if (empty($comments)) {
					?>
					<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
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
