<?php include 'admin/include/init.php'; ?>
<?php 
$category = Category::find_all();
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Package</title>
    
          
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <style>
       body {
            font-family: 'Open Sans', 'Roboto', sans-serif;
            line-height: 1.5em;
            margin-bottom: 0%;
            width: 100%;
            margin-top: 4%;
            overflow-x: hidden;
            background: #f1f1f1;
        }

        .navbar-light .navbar-brand {
            color: #1a1a1a;
            font-weight: bold;
            line-height: 22px;
        }

        .navbar {
            font-weight: 700;
            padding: 12px;
            font-style: normal;
            font-size: 14px;
            text-transform: uppercase;
            color: black;
            border-bottom: 1px solid #ddd;
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

        .hero {
            height: 550px;
            width: 100%;
            border-color: rgba(0, 0, 0, 0.02);
            background: url(images/fornt.jpg);
            background-size: contain;
            background-size: 100% 100%;

        }

        .form-control {
            font-size: 14px;
        }

        .hero-lead {
            font-size: 36px;
            color: white;
            font-style: normal;
        }

        .form-control {
            outline: none;
            border-radius: 0;
        }

        .btn.btn-info.text-uppercase {
            font-size: 14px;
        }

        .btn.btn-info.text-uppercase.font-weight-bold {
            width: 150px;
            padding: 6px;
            border-radius: 0;
        }

        .btn.btn-danger.text-uppercase {
        font-size: 14px;
        }

        .btn.btn-danger.text-uppercase.fb {
        width: 150px;
        padding: 6px;
        border-radius: 0;
        }

        .datepicker {
            width: 250px;
            font-size: 12px;
        }

        .pricing {
            width: 18%;
            min-height: 200px;
            float: left;
            background: gray;
            margin-left: 2%;
        }

        .container-fluid.custom-container {
            width: 90%;
        }

        a.btn.btn-custom {
            background: none;
            border-radius: 0;
            font-size: 12px;
            width: 100%;
            border: 2px solid #17a2b8;
            color: #17a2b8;
            font-weight: 700;
            text-transform: uppercase;
        }

        a.btn.btn-custom:hover {
            background: green;
            color: white;
        }

        .list-group-item.text-center.text-uppercase {
            background: white;
            color: black;
            font-weight: 700;
            font-size: 18px;
            padding: 10px;
        }

        .list-group-item {
            font-size: 12px;
            padding: 5px 10px;
        }

        .card-columns {
            column-count: 4;
        }
        .modal-content {
            -webkit-border-radius:0;
            -moz-border-radius:0;
            border-radius:0;
            font-size: 14px;
        }
        .btn.btn-primary.mr-2.custom-btn {
            background: #22adb5;
            border: 1px solid #22adb5;
        }
        .btn.btn-primary.mr-2.custom-btn:hover {
            background: green;
        }
        .modal-header {
            border-bottom: 0;
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 10px;
            padding-bottom: 0;
        }
        .modal-body {
            padding-bottom: 0;
        }
        .bgact{
               
                background: green;
                padding: 15px;
        }
    </style>
</head>
<body>
<?php include 'include/nav.php'; ?>

<div class="container" style="width: 70%;">

    <div class="row mb-3">
        <div class="col-lg-12">
            <h3 class="h5 text-uppercase text-center text-muted">Wedding</h3>
            <h2 class="h2 text-uppercase text-center mb-0">Select Package</h2>
        </div>
    </div>

    <?php foreach ($category as $category_row) : ?>
     <div class="row">
        <div class="col-md-12 p-0" style="margin-bottom: 20px;"> 

            <div class="float-left">
                <img src="admin/<?= $category_row->preview_image_picture(); ?>" style="width: 500px;" alt="">
            </div>
            
            <div class="float-left" style="width: 47%;"> 
                <ul class="list-group">
                    <li class="list-group-item bg-danger active" style="padding-top: 12px;"><h6 class="h6 text-center"><?= $category_row->wedding_type; ?> Package Wedding - Price: Tk <?= number_format($category_row->price,2); ?></h6></li>
                    <li class="list-group-item  list-group-item-light " style="color:green"><b>THIS PACKAGE INCLUDES:</b></li>
                    <?php $feature = Features::find_by_feature_all($category_row->id); ?>
                    <?php foreach ($feature as $feature_item) : ?>
                        <li class="list-group-item"><?= $feature_item->title; ?></li>
                    <?php endforeach; ?>
                </ul>
                 <div class="float-right">
                <a href="package_detail.php?id=<?= $category_row->id; ?>" class="btn btn-sm btn-success active" style="border-radius: 3px;margin-top: 9px;">Book Now</a>
                <a href="package_detail.php?id=<?= $category_row->id; ?>" class="btn btn-sm btn-primary active" style="border-radius: 3px;margin-top: 9px;">More Detail</a>
            </div>
            </div>
            </div>
        </div>
        <?php endforeach; ?>

</div>




</body>
</html>