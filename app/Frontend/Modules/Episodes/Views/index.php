<?php
foreach ($listeEpisodes as $episodes)
{
  echo '<h2><a href="episodes-'.$episodes['id'].'.html">'.$episodes->getTitle().'</a></h2>';
  echo '<br/><p>'.$episodes->getContent().'</p>';
}
