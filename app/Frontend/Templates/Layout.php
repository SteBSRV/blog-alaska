<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Billet simple pour l'Alaska">
    <meta name="author" content="Steve Ebizet">

    <title>
      <?= isset($title) ? $title : "Billet Simple Pour l'Alaska" ?>
    </title>

    <!-- Bootstrap Core CSS -->
    <link href="/../../css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="/../../css/clean-blog.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/../../css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/">Billet Simple Pour l'Alaska</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/">Accueil</a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Episodes <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <?php foreach ($listeEpisodes as $episode) {
                            $title = $episode->getTitle();
                            echo '<li><a href="/episode-' . $title . '.html">Episode ' . $title . '</a></li>';
                        }
                        ?>
                      </ul>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li>
                        <a href="#">A propos</a>
                    </li>
                    <?php if ($user->isAuthenticated() === false) { ?>
                    <li>
                        <a href="/admin/login/">Connexion</a>
                    </li>
                    <?php }
                    if ($user->isAuthenticated()) { ?>
                    <li>
                        <a href="/admin/">Admin</a>
                    </li>
                    <li>
                        <a href="/admin/logout/">Déconnexion</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('/../../img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Billet Simple Pour l'Alaska</h1>
                        <hr class="small">
                        <span class="subheading">Une histoire en ligne.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
              <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
                <?php
                  echo $content;
                ?>
            </div>
        </div>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-muted">Copyright &copy; BSPA 2017</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="/../../js/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/../../js/bootstrap/bootstrap.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="/../../js/clean-blog.js"></script>

</body>

</html>
