<p style="text-align: center">Il y a actuellement XX commentaires. En voici la liste :</p>
 
<table>
  <tr><th>Auteur</th><th>Titre</th><th>Date</th><th>Status</th><th>Action</th></tr>
<?php
/*foreach ($listeEpisodes as $episode)
{
  echo '<tr ', $episode->getState() ? '' : 'class="private-episode"', '><td>', $episode->getAuthor(), '</td><td>', $episode->getTitle(), '</td><td>le ', $episode->getAddDate()->format('d/m/Y à H\hi'), '</td><td>', ($episode->getAddDate() == $episode->getModDate() ? '-' : 'le '.$episode->getModDate()->format('d/m/Y à H\hi')), '</td><td>', $episode->getState() ? 'public' : 'privé', '</td><td><a href="episode-update-', $episode->getId(), '.html"><i class="fa fa-edit"></i></a> <a href="episode-delete-', $episode->getId(), '.html"><i class="fa fa-trash"></i></td></tr>', "\n";
}*/
?>
</table>
