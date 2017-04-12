<h2 class="post-heading">Gestion des commentaires</h2>

<p style="text-align: center">Il y a actuellement XX commentaires signalés. En voici la liste :</p>
 
<table class="table">
	<thead>
  		<tr>
  			<th>Auteur</th>
  			<th>Message</th>
  			<th>Date</th>
  			<th>Status</th>
  			<th>(Signalement)</th>
  			<th>Episode</th>
  			<th>Action</th>
  		</tr>
  	</thead>
  	<tbody>
		<?php
		foreach ($listeComments as $comment)
		{
		?>
			<tr <?=($comment->getState() == 0) ? '' : 'class="reported-comment"'?>>
				<td><?=$comment->getAuthor()?></td>
				<td><?=$comment->getMessage()?></td>
				<td>le <?=$comment->getDate()->format('d/m/Y à H\hi')?></td>
				<td><?=$comment->getState() ? 'public' : 'censuré'?></td>
				<td><?=($comment->getReport() == 0) ? 'aucun' : $comment->getReport()?></td>
				<td><?=$comment->getEpisodeId()?></td>
				<td><a href="/admin/comment-update-<?=$comment->getId()?>.html"><i class="fa fa-edit"></i></a> <a href="/admin/comment-delete-<?=$comment->getId()?>.html"><i class="fa fa-trash"></i></a></td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
