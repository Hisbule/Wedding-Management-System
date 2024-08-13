<?php include 'admin/include/init.php'; ?>
<?php
    $count = 0;
    $error = '';
    $user_firstname = $user_lastname = $user_password = $user_email = $wedding_date = '';

    $account_details = new Account_Details();
    $accounts = new Accounts();
    $booking = new Booking();
    $category = Category::find_all();
    $blogEvent = EventWedding::getEventBlogs();

    if (isset($_POST['register'])) {

        $user_firstname = clean($_POST['user_firstname']);
        $user_lastname = clean($_POST['user_lastname']);
        $user_email = clean($_POST['user_email']);
        $user_phone = clean($_POST['user_phone']);
        $wedding_date = clean($_POST['wedding_date']);

        $checkdate = $booking->check_wedding_date($wedding_date);

        if ($checkdate) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  The wedding you enter is already booked. Please Try another set of date!
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if (empty($user_firstname) ||
            empty($user_phone) ||
            empty($user_email) ||
            empty($user_lastname) ||
            empty($wedding_date)) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Please Fill up all the fields.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Incorrect email format.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();

        }

        $check_email = $accounts->email_exists($user_email);

        if ($check_email) {
            redirect_to("index.php");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  Email is already Exists.
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        } else {
            if ($error == '') {
                $count = $count + 1;
                $account_details->firstname = $user_firstname;
                $account_details->lastname = $user_lastname;
                $account_details->status = 'pending';
                $account_details->datetime_created  = date("y-m-d h:m:i");
                $account_details->phone= $user_phone;
                if ($account_details->save()) {
                    $account_details->user_id = mysqli_insert_id($db->connection);

                    if($account_details->update()) {
                        $accounts->user_id = $account_details->user_id;
                        $accounts->user_email= $user_email;


                         if($accounts->save()) {
                             $booking->user_id = $accounts->user_id;
                             $booking->user_email = $user_email;
                             $booking->wedding_date =  $wedding_date;
                             $booking->save();
                             redirect_to("thank_you.php");
                         }
                    }
                }
            }
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Home</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
          
   <link rel="stylesheet" href="./navigation.css">
    
    
    <style>
        .alert {
            font-size: 12px;
        }
        .error {
            background-color: #F2DEDE;
        }
        .alert.alert-danger.text-center {
            font-size: 16px;
        }
        .mdi.mdi-alert-circle.mr-3 {
            font-size: 16px;
        }

        .bgact{
                
                background: rgb(14 14 14 / 49%);
                padding: 15px;
        }

    </style>
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

<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="hero" >
            
            <div class="row justify-content-md-center">
                <div class="col col-lg-3">
                </div>
                <div class="col col-lg-5" style="margin-top: 10%;">
                    
                    <?php
                        if ($session->message()) {
                            echo $session->message();
                        }
                    ?>
                    
                    <form class="bgact" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h2 class="text-center hero-lead">Welcome to Wedding Management System</h2>
                    <p class="lead text-center" style="color:white;"></p>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="user_firstname" placeholder="First Name" id="user_firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" id="user_lastname" class="form-control" name="user_lastname" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="youremailaddress@mail.com">
                        </div>
                        <div class="form-group">
                            <input type="text" aria-describedby="phoneHelpBlock" class="form-control" name="user_phone" id="user_phone" placeholder="Contact Number">
                        </div>
                        <div class="form-row">
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" name="wedding_date" data-provide="datepicker" id="wedding_date"
                                       placeholder="Wedding Date">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background: white;"><i
                                                style="font-size: 20px;color:#19b5bc;" class="mdi mdi-calendar-check"
                                                id="review" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                     
                            <button type="submit" name="register" class="btn btn-danger btn-sm text-uppercase fb"
                                    style="margin-top: -5px;">Sign Up
                            </button>
                        </div>
                    </form>
                    
                </div>
                <div class="col col-lg-3">
                </div>
            </div>
        </div>



<div class="container">
    <div class="row">
        <div class="col-lg-12">
            
            <h6 class="h6 text-uppercase text-center text-muted mb-3">Discover the best ideas, tips and articles to
                inspire
                your wedding.</h6>

            <div class="card-columns">

                <?php foreach($blogEvent as $blog_item) : ?>
                   <div class="card">
                    <img class="card-img-top" src="admin/<?= $blog_item->preview_image_picture(); ?>" alt="Card image cap">
                        <div class="card-body">
                            <a href="wedding_details.php?id=<?= $blog_item->id; ?>" class="btn-stamp">
                                <h6 class="card-title mt-0 mb-0 text-center font-weight-bold font-custom text-uppercase"><?= $blog_item->title; ?></h6>
                                <p class="card-text mt-0 mb-0 text-center color_gray"><?= $blog_item->wedding_type; ?> Wedding</p>
                                <p class="card-text mt-0 mb-0 text-center color_light text-capitalize"><i class="mdi mdi-map-marker"></i>
                                    <?= $blog_item->location; ?></p>
                            </a>
                        </div>
                    </div> 
                <?php endforeach; ?>

               
            </div>
        </div>





    $(document).ready(function () {
        $('#wedding_date').datepicker();
    <?php
        if($count == 0) {
    ?>
        $('#user_firstname').savy('load');
        $('#user_lastname').savy('load');
        $('#user_email').savy('load');
        $('#user_phone').savy('load');
        $('#wedding_date').savy('load');
    <?php } else { ?>
        $('#user_firstname').savy('destroy');
        $('#user_email').savy('destroy');
        $('#user_lastname').savy('destroy');
        $('#user_phone').savy('destroy');
        $('#wedding_date').savy('destroy');
    <?php } ?>
    });
</script>
</body>
</html>