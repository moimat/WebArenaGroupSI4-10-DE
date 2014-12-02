<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Accueil WebArena</title>
        <!-- Bootstrap core CSS -->
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!--<script src="./Carousel Template for Bootstrap_files/ie-emulation-modes-warning.js"></script><style type="text/css"></style><style type="text/css"></style>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Custom styles for this template -->
        <link href="http://getbootstrap.com/examples/carousel/carousel.css" rel="stylesheet">
    </head>
    <!-- NAVBAR
    ================================================== -->
    <body>

        <h1> WebArena Fighters </h1>
        <!-- Carousel
        ================================================== -->   
        <div id="myCarousel" class="carousel slide" style="width: 300px; margin: 0 auto">
            <div class="carousel-inner">
                <?php
                foreach ($fighters as $key => $value) {
                    $name = $fighters[$key]['Fighter']['name'];
                    $id = $fighters[$key]['Fighter']['id'];
                    if ($id == 1) {
                        echo'<div class="item active">';
                    } else {
                        echo '<div class="item">';
                    }

                    echo $this->Html->image('Avatars/avatar-' . $id . '.jpg', array('alt' => 'CakePHP', 'width' => '20%', 'height' => '20%'));
                    echo'<div class="carousel-caption"><h4>' . $name . '</h4></div>';
                    echo '</div>';
                }
                ?>
            </div> <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>

            <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
        </div>
    </body>
</html>
<!-- Bootstrap core JavaScript
       ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php
echo $this->Html->script('docs.min');
echo $this->Html->script('jquery.min');
echo $this->Html->script('bootstrap.min');
?>