
<h1>Message d'un utilisateur du site BSPA</h1>

<h2>Contenu du message :</h2>
<ul>
    <li>Auteur : <?=$contact->getAuthor()?></li>
    <li>Email : <?=$contact->getMail()?></li>
    <li>Sujet : <?=$contact->getTitle()?></li>
    <li>Message : <?=$contact->getMessage()?></li>
    <li>Date : <em><?=$contact->getDate()->format('d/m/Y à H\hi')?></em></li>
</ul>
