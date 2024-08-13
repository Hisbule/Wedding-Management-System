<?php include 'admin/include/init.php'; ?>
<?php 
    $id = $_GET['id'];
    $category = Category::find_by_id($id);

    $count = 0;
    $error =$user_firstname = $user_lastname = $user_password = $user_email = $wedding_date = '';

    $account_details = new Account_Details();
    $accounts = new Accounts();
    $booking = new Booking();

    if (isset($_POST['register'])) {

        $user_firstname = clean($_POST['user_firstname']);
        $user_lastname  = clean($_POST['user_lastname']);
        $user_email     = clean($_POST['user_email']);
        $user_password  = clean($_POST['user_password']);
        $wedding_date   = clean($_POST['wedding_date']);
        $user_phone     = clean($_POST['user_phone']);
        $bid = clean($_POST['booking_id']);

        $checkdate = $booking->check_wedding_date($wedding_date);

        if ($checkdate) {
            redirect_to("package_detail.php?id=$bid");
            $session->message("
            <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
              <strong><i class='mdi mdi-alert'></i></strong>  The wedding you enter is already booked. Please Try another set of date!
              <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>
            </div>");
            die();
        }

        // if (empty($user_firstname) ||
        //     empty($user_password) ||
        //     empty($user_email) ||
        //     empty($user_lastname) ||
        //     empty($wedding_date)) {
        //     redirect_to("package_detail.php?id=$bid");
        //     $session->message("
        //     <div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">
        //       <strong><i class='mdi mdi-alert'></i></strong>  Please Fill up all the fields.
        //       <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        //         <span aria-hidden=\"true\">&times;</span>
        //       </button>
        //     </div>");
        //     die();
        // } else {
        //     if ($error == '') {
        //         $count = $count + 1;
        //         $account_details->firstname = $user_firstname;
        //         $account_details->lastname = $user_lastname;
        //         $account_details->status = 'pending';
        //         $account_details->phone = $user_phone;
        //         $account_details->datetime_created  = date("y-m-d h:m:i");

        //         if ($account_details->save()) {
        //             $account_details->user_id = mysqli_insert_id($db->connection);

        //             if($account_details->update()) {
        //                 $accounts->user_id = $account_details->user_id;
        //                 $accounts->user_email= $user_email;

        //                  if($accounts->save()) {
        //                      $booking->user_id = $accounts->user_id;
        //                      $booking->wedding_type = $bid;
        //                      $booking->user_email = $user_email;
        //                      $booking->wedding_date =  $wedding_date;
        //                      $booking->save();
        //                      redirect_to("package_detail.php?id=".$bid);
        //                  }
        //             }
        //         }
        //     }
        // }

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
            redirect_to("package_detail.php?id=$bid");
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
            redirect_to("package_detail.php?id=$bid");
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
                $account_details->phone = $user_phone;
                $account_details->datetime_created  = date("y-m-d h:m:i");

                if ($account_details->save()) {
                    $account_details->user_id = mysqli_insert_id($db->connection);

                    if($account_details->update()) {
                        $accounts->user_id = $account_details->user_id;
                        $accounts->user_email= $user_email;

                         if($accounts->save()) {
                             $booking->user_id = $accounts->user_id;
                             $booking->wedding_type = $bid;
                             $booking->user_email = $user_email;
                             $booking->wedding_date =  $wedding_date;
                             $booking->save();
                             redirect_to("package_detail.php?id=".$bid);
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wedding Booking</title>
  
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
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
            color: green;
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
            color: green;
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
        body {
            margin-top: 6%;
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
            color: green;
            border-bottom: 1px solid #ddd;
        }

        li.nav-item > a.nav-link {
            color: black ;
            font-weight: bold ;
        }

        #review {
            font-size: 16px;
            font-weight: bold;
            margin-right: 5px;
        }

      
        .navbar-expand-lg .navbar-nav .nav-link {
            padding-right: .9rem;
        }

        .navbar-brand {
            margin-left: 20px;
            width: 200px;
        }

        img.img-fluid.img-custom {
            width: 344px;
            height:230px;
        }
        .btn.btn-sm.btn-light.active:hover {
            background: white;
        }
        .list-group-item:first-child {
            border-top-left-radius: 0rem;
            border-top-right-radius: 0rem;
        }

        .list-group-item.active{
            border-color: green;
        }
</style>

</head>
<body>
<?php include 'include/nav.php'; ?>

<div class="container">
    
     <div class="row">
        <div class="col-md-8 p-0" style="margin-bottom: 20px;"> 
           
            <div class="float-left bg-white">
                <h5 class="h5 text-uppercase mb-5 pt-3 pl-3 pr-3">
                    <span class="float-left text-capitalize"><?= $category->wedding_type; ?> Package Wedding</span>
                    <span class="float-right text-capitalize">Price: TK <?= number_format($category->price,2); ?></span>
                </h5>
                <img src="admin/<?= $category->preview_image_picture(); ?>" style="width: 700px;" alt="">

                <ul class="list-group">
                        <li class="list-group-item list-group-item-action bg-danger flex-column align-items-start active">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="" >FUNCTIONS AND SERVICES</h5>
                            </div>
                        </li>
                    <?php $feature = Features::find_by_feature_no_limit($category->id); ?>
                        <?php foreach ($feature as $feature_item) : ?>
                            <li class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><i class="mdi mdi-check mr-3"></i><?= $feature_item->title; ?></h5>
                                </div>
                                <p class="mb-1 ml-3 text-capitalize"><?= $feature_item->description; ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div><!-- end of col-md-8 p-0 pl-3 -->

            <div class="col-md-4" style="margin-bottom: 20px;">
               
                        
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="background:pink;padding: 20px;">
                        <?php
                            if ($session->message()) {
                                echo $session->message();
                            }
                        ?>
                         <h5 class="h5 text-center mb-3 m-0">Wedding Planning Starts Here</h5>
                        <div class="form-group">
                            <input type="text" class="form-control" name="user_firstname" placeholder="First name" id="user_firstname">
                        </div>

                        <div class="form-group">
                            <input type="text" id="user_lastname" class="form-control" name="user_lastname" placeholder="Last name">
                        </div>

                        <div class="form-group">
                            <input type="number" id="user_phone" class="form-control" name="user_phone" placeholder="Phone number">
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" name="user_email" id="user_email" placeholder="youremail@gmail.com">
                        </div>

                       


                        <div class="form-row">
                            <div class="input-group col-md-12">
                                <input type="text" class="form-control" name="wedding_date" data-provide="datepicker" id="wedding_date"
                                       placeholder="Wedding Date">

                                <div class="input-group-append">
                                    <span class="input-group-text" style="background: white;"><i
                                                style="font-size: 20px;color:#19b5bc;" class="mdi mdi-calendar-check"
                                                id="wedding_date" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <input type="hidden" name="booking_id" value="<?= $_GET['id']; ?>">
                            <button type="submit" name="register" class="btn btn-success btn-sm text-uppercase font-weight-bold"
                                    style="margin-top: -5px;">Book Now
                            </button>
                        </div>
                    </form>
            </div>
        </div>
       

</div>

<script>

    $(document).ready(function () {
        $('#wedding_date').datepicker();
    });
</script>
</body>
</html>