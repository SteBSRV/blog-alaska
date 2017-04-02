<p style="text-align: center">Il y a actuellement <?= $nombreEpisodes ?> news. En voici la liste :</p>

<a href="/admin/episode-insert.html"><button class="btn btn-primary">Ajouter un épisode</button></a>
 
<table>
  <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
<?php
foreach ($listeEpisodes as $episode)
{
  echo '<tr><td>', $episode->getAuthor(), '</td><td>', $episode->getTitle(), '</td><td>le ', $episode->getAddDate()->format('d/m/Y à H\hi'), '</td><td>', ($episode->getAddDate() == $episode->getModDate() ? '-' : 'le '.$episode->getModDate()->format('d/m/Y à H\hi')), '</td><td><a href="episode-update-', $episode->getId(), '.html"><img src="/img/update.png" alt="Modifier" /></a> <a href="episode-delete-', $episode->getId(), '.html"><img src="/img/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
}
?>
</table>
