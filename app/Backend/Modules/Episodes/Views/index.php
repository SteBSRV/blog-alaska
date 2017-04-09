<h2 class="post-heading">Gestion des épisodes</h2>

<p style="text-align: center">Il y a actuellement <?= $nombreEpisodes ?> épisodes. En voici la liste :</p>
 
<table class="table">
	<thead>
  		<tr>
  			<th>Auteur</th>
  			<th>Titre</th>
  			<th>Date d'ajout</th>
  			<th>Dernière modification</th>
  			<th>Status</th>
  			<th>Action</th>
  		</tr>
  	</thead>
  	<tbody>
		<?php
		foreach ($listeEpisodes as $episode)
		{
		?>
			<tr <?=$episode->getState() ? '' : 'class="private-episode"'?>>
				<td><?=$episode->getAuthor()?></td>
				<td><?=$episode->getTitle()?></td>
				<td>le <?=$episode->getAddDate()->format('d/m/Y à H\hi')?></td>
				<td><?=($episode->getAddDate() == $episode->getModDate() ? '-' : 'le '.$episode->getModDate()->format('d/m/Y à H\hi'))?></td>
				<td><?=$episode->getState() ? 'public' : 'privé'?></td>
				<td><a href="episode-update-<?=$episode->getId()?>.html"><i class="fa fa-edit"></i></a> <a href="episode-delete-<?=$episode->getId()?>.html"><i class="fa fa-trash"></i></a></td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>

<div class="col-xs-4 col-xs-offset-4">
	<a href="/admin/episode-insert.html"><button class="btn btn-primary">Ajouter un épisode</button></a>
</div>
