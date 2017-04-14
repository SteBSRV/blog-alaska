<?php
foreach ($comments as $comment)
{
	if ($comment->getState() == 0) {
		$censuredClass = 'comment-censured';
		$censuredMessage = '"Message censuré en raison de plusieurs signalement" (Modération BSPA).';
	} else {
		$censuredClass = '';
	}
	?>
	<div class="comment-body level-<?= $comment->getLevel()?>">
	  	<header class="comment-header">
			<span class="post-byline">
				<span class="comment-author"><?= htmlspecialchars($comment->getAuthor()) ?></span>
			</span>

			<span class="post-meta">
				<span class="bullet time-ago-bullet" aria-hidden="true">•</span>
				<?= $comment->getDate()->format('d/m/Y à H\hi') ?>
			</span>
		</header>
	  	<div class="comment-message <?= $censuredClass?>">
	  		<?php
	  		if ($comment->getState() == 0) {
	  			echo '<p>'.$censuredMessage.'</p>';
	  		} else { ?>
			<p><?= nl2br(htmlspecialchars($comment->getMessage())) ?></p>
			<?php
			} 
			if ($comment->getLevel() < 3) {?>
				<span style="float: right;"><a href="/commenter-reponse-<?= $comment->getId() ?>.html">Répondre</a></span>
			<?php
			}
			?>
		</div>
		<footer class="comment-footer">
			<?php if ($user->isAuthenticated()) { ?>
				<a href="admin/comment-update-<?= $comment->getId() ?>.html">Modifier</a> |
				<a href="admin/comment-delete-<?= $comment->getId() ?>.html">Supprimer</a> |
		    <?php } ?>
		    	<a href="/comment-report-<?= $comment->getId() ?>.html">Signaler</a>
		</footer>
	</div>
<?php
}
?>