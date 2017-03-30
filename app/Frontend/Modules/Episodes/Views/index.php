<?php
echo '<h2>Liste des episodes</h2>';
foreach ($listeEpisodes as $episodes)
{
  echo '<h3><a href="episode-'.$episodes['id'].'.html">'.$episodes->getTitle().'</a></h2>';
  echo '<br/><p>'.$episodes->getContent().'</p>';
}
