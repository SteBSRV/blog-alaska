<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : "Billet Simple Pour l'Alaska" ?>
    </title>
 
    <meta charset="utf-8" />
 
    <link rel="stylesheet" href="/../../css/style.css" type="text/css" />
  </head>
 
  <body>
    <div id="wrap">
      <header>
        <h1><a href="/">Billet Simple Pour l'Alaska</a></h1>
      </header>
 
      <nav>
        <ul>
          <li><a href="/">Accueil</a></li>
          <?php if ($user->isAuthenticated()) { ?>
          <li><a href="/admin/">Admin</a></li>
          <?php } ?>
        </ul>
      </nav>
 
      <div id="content-wrap">
        <section id="main">
          <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
 
          <?php
          echo $content;
          ?>
        </section>
      </div>
 
      <footer></footer>
    </div>
  </body>
</html>