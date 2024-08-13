<?php 
    include 'admin/include/init.php'; 

    $gallery = Gallery::find_all(); 

?>
<!doctype html>
<html lang="en">
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Gallery</title>
    
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    
    <style>
        body {
            font-family: 'Open Sans', 'Roboto', sans-serif;
            line-height: 1.5em;
            margin-bottom: 2%;
            margin-top: 2%;
            width: 100%;
            overflow-x: hidden;
            background: #A59996;
        }

        .navbar-light .navbar-brand {
            color: red;
            font-weight: bold;
            line-height: 22px;
        }

        .navbar {
            border:green;
            font-weight: 700;
            padding: 12px;
            font-style: normal;
            font-size: 14px;
            text-transform: uppercase;
            color: black;
            border-bottom: 1px solid green;
        }

        li.nav-item > a.nav-link {
            color: green !important;
            font-weight: bold !important;
        }

        #review {
            font-size: 16px;
            font-weight: bold;
            margin-right: 5px;
        }

        .form-inline > a.mr-2, .btn.btn-sm.my-2.my-sm-0 {
            color: black;
            font-size: 14px;
            font-weight: 700;
            margin-left: 10px;
        }

        .form-inline > a.mr-2:hover, .btn.btn-sm.my-2.my-sm-0:hover {
            color: green;
            text-decoration: none;
        }

        a.btn.btn-sm.my-2.my-sm-0.mr-2.loginbtn {
            background: green;
            font-size: 14px;
            color: white;
            padding: 5px;
            border: 2px solid transparent;
            width: 85px;
        }

        a.btn.btn-sm.my-2.my-sm-0.mr-2.loginbtn:hover {
            background: white;
            border: 2px solid green;
            color: green;
        }

        .navbar-expand-lg .navbar-nav .nav-link {
            padding-right: .9rem;
        }

        .navbar-brand {
            margin-left: 20px;
            width: 200px;
        }
        .card {
            -webkit-border-radius:0;
            -moz-border-radius:0;
            border-radius:0;
        }
        .card img {
            -webkit-border-radius:0;
            -moz-border-radius:0;
            border-radius:0;
        }

    </style>
</head>
<body>
<?php include 'include/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="text-center mb-0 mt-5">Wedding Photos</h4>
            <p class="text-center mt-0 text-muted">Photos That Capture Your Moment</p>

            <div class="card-columns">
                <?php foreach($gallery as $galleries) : ?>
                <div class="card" style="position: relative;">
                    <a href="admin/<?= $galleries->picture_path(); ?>" data-lightbox="gallery-group-4">
                        <img class="card-img-top" src="admin/<?= $galleries->picture_path(); ?>" alt="Card image cap">
                    </a>
                    <div class="card-body" style="position: absolute;bottom: 0;left:0; width: 100%;background: rgba(0,0,0, 0.5);color:white;padding: 10px 10px 0 10px;">
                        <p class="card-title text-capitalize" style="font-size:12px;"><?= empty($galleries->title) ? 'No Title' : $galleries->title; ?></p>
                    </div>
                </div><!-- end of body -->
                <?php endforeach; ?>
            </div><!-- end of card columns -->
        </div>
    </div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.2.1.slim.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="lightbox/js/lightbox-2.6.min.js"></script>
</body>
</html>