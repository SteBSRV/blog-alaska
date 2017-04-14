
<h1>Signalement d'un commentaire</h1>

<?php if ($parentComment != false) { ?>
    <h2><em>En réponse au commentaire de <?= $parentComment->getAuthor()?></em></h2>
<?php
} ?>

<h2>Contenu du commentaire :</h2>
<ul>
    <li>Auteur : <?=$comment->getAuthor()?></li>
    <li>Episode : <?=$episode->getTitle()?></li>
    <li>Message : <?=$comment->getMessage()?></li>
    <li>Date : <em><?=$comment->getDate()?></em></li>
    <li>Statut : <?=$comment->getState() ? 'publique' : 'censuré'?></li>
    <li>Nombre de signalement : <?=$comment->getReport()?></li>
</ul>

<p>Editer le commentaire : <a href="/admin/comment-update-<?=$comment->getId()?>.html">Edition</a></p>
