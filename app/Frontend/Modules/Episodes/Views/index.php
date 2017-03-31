<?php
echo '<h1 class="post-heading">Liste des episodes</h1>';
foreach ($listeEpisodes as $episodes)
{
?>
<div class="post-preview">
    <?php echo '<a href="episode-'.$episodes['id'].'.html">';?>
        <h2 class="post-title">
            <?php echo $episodes->getTitle();?>
        </h2>
        <h3 class="post-subtitle">
            <?php echo $episodes->getContent();?>
        </h3>
    </a>
    <p class="post-meta">
    	Posté par <?php echo $episodes->getAuthor();?>, le <?php echo $episodes->getAddDate()->format('d/m/Y à H\hi');?>
    </p>
</div>
<?php
}
