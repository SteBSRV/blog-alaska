<?php

echo '<h1 class="post-heading">Liste des episodes</h1>';?>
<div class="content-list">
    <?php
    foreach ($listeEpisodes as $episodes)
    {
    ?>
    <div class="post-preview col-xs-12 col-md-6">
        <?php echo '<a href="episode-'.$episodes->getId().'.html">'?>
            <h2 class="post-title">
                <?php echo $episodes->getTitle();?>
            </h2>
                <?php echo strip_tags($episodes->getContent());?>
        </a>
        <p class="post-meta">
        	Posté par <?php echo $episodes->getAuthor()?>, le <?php echo $episodes->getAddDate()->format('d/m/Y à H\hi')?>
        </p>
    </div>
<?php
}
?>
</div>
</div>
<?php
/* Pager */
if ($page < $nbrPages) {?>
    <hr>
    <ul class="pager">
        <li class="next">
            <a href="<?= '/page-' . ((int)$page + 1) ?>">Plus anciens &rarr;</a>
        </li>
    </ul>
<?php } if ($page > 1) {?>
    <ul class="pager">
        <li class="previous">
            <a href="<?= '/page-' . ((int)$page - 1) ?>">&larr; Plus récents</a>
        </li>
    </ul>
<?php }
