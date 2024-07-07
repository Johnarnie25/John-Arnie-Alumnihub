<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
session_start();
include('admin/db_connect.php');

include('header.php');
?>
    <style>

        header.masthead {
        background: url(admin/assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>);
        background-repeat: no-repeat;
        background-size: cover;
    }

    #viewer_modal .btn-close {
        position: absolute;
        z-index: 999999;
        background: unset;
        color: white;
        border: unset;
        font-size: 27px;
        top: 0;
    }

    #viewer_modal .modal-dialog {
        width: 80%;
        max-width: unset;
        height: calc(90%);
        max-height: unset;
    }

    #viewer_modal .modal-content {
        background: black;
        border: unset;
        height: calc(100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #viewer_modal img,
    #viewer_modal video {
        max-height: calc(100%);
        max-width: calc(100%);
    }

    body {
        background: #F5F5F5!important;
    }

    footer {
        background-color: 
#FEFBF6!important;
    }

    a.jqte_tool_label.unselectable {
        height: auto !important;
        min-width: 4rem !important;
        padding: 5px
    }

    ul {
    margin: 0px;
    padding: 0px;
}

.wave {
            position: fixed;
            bottom: 0;
            left: 0;
            height: 100%;
            z-index: -1;
        }

        .container90 {
            width: 100vw;
            height: 70vh;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 7rem;
            padding: 0 2rem;
        }

        .img {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .login-content {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            text-align: center;
        }

        .img img {
            width: 0px;
        }

        form {
            width: 350px;
        }

        .login-content img {
            height: 100px;
        }

        .login-content h2 {
            margin: 15px 0;
            color: #333;
            text-transform: uppercase;
            font-size: 2.9rem;
        }

        .login-content .input-div {
            position: relative;
            display: grid;
            grid-template-columns: 7% 93%;
            margin: 25px 0;
            padding: 5px 0;
            border-bottom: 2px solid #293242;
        }

        .login-content .input-div.one {
            margin-top: 0;
        }

        .i {
            color:#293242;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .i i {
            transition: .3s;
        }

        .input-div > div {
            position: relative;
            height: 45px;
        }

        .input-div > div > h5 {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            transition: .3s;
        }

        .input-div:before,
        .input-div:after {
            content: '';
            position: absolute;
            bottom: -2px;
            width: 0%;
            height: 2px;
            background-color: #293242;
            transition: .4s;
        }

        .input-div:before {
            right: 50%;
        }

        .input-div:after {
            left: 50%;
        }

        .input-div.focus:before,
        .input-div.focus:after {
            width: 50%;
        }

        .input-div.focus > div > h5 {
            top: -5px;
            font-size: 15px;
        }

        .input-div.focus > .i > i {
            color: #293242;
        }

        .input-div > div > input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: none;
            padding: 0.5rem 0.7rem;
            font-size: 1.2rem;
            color: #555;
            font-family: 'poppins', sans-serif;
        }

        .input-div.pass {
            margin-bottom: 4px;
        }

        .error-message {
            color: #ff0000; /* Set color to red */
            margin-top: 10px;
            font-size: 0.9rem;
        }

        a {
            display: block;
            text-align: ;
            text-decoration: none;
            color: #999;
            font-size: 0.9rem;
            transition: .3s;
        }

        a:hover {
            color: #293242;
        }

        .btn {
    display: block;
    width: 100%;
    height: 50px;
    border-radius: 25px;
    outline: none;
    border: none;
    background-color: #ffb703; /* Changed this line */
    background-size: 200%;
    font-size: 1.2rem;
    color: #fff;
    font-family: ; /* Remember to specify a font family */
    text-transform: uppercase;
    margin: 1rem 0;
    cursor: pointer;
    transition: .5s;
}


        .btn:hover {
            background-position: right;
        }

        .hide {
            display: none;
        }

        .action-link {
            color: #272829;
            cursor: pointer;
            margin-top: 10px;
            font-size: 0.9rem;
        }
/* Media query for screens up to 600px */
@media (max-width: 600px) {
    .container90 {
        grid-template-columns: 1fr; /* Adjusting grid layout to a single column */
        grid-gap: 3rem; /* Decreasing grid gap */
        height: auto; /* Removing fixed height */
    }

    .img {
        justify-content: center; /* Centering image */
    }

    .login-content {
        justify-content: center; /* Centering login content */
    }

    form {
        width: 90%; /* Adjusting form width */
    }

    .login-content h2 {
        font-size: 2rem; /* Decreasing heading font size */
    }

    .input-div > div > h5 {
        font-size: 15px; /* Decreasing input label font size */
    }

    .input-div > div > input {
        font-size: 1rem; /* Decreasing input font size */
    }
}
        .footer-section {
  background: #FEFBF;
  position: relative;
}
.footer-cta {
  border-bottom: 1px solid #ffb703;
}
.single-cta i {
  color: #ffb703;
  font-size: 30px;
  float: left;
  margin-top: 8px;
}
.cta-text {
  padding-left: 15px;
  display: inline-block;
}
.cta-text h4 {
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 2px;
}
.cta-text span {
  color: #ffb703;
  font-size: 15px;
}
.footer-content {
  position: relative;
  z-index: 2;
}
.footer-pattern img {
  position: absolute;
  top: 0;
  left: 0;
  height: 330px;
  background-size: cover;
  background-position: 100% 100%;
}
.footer-logo {
  margin-bottom: 0px;
}
.footer-logo img {
    width: 150px;
    height: 100px; /* Example height */
}

.footer-text p {
  margin-bottom: 14px;
  font-size: 14px;
      color: #7e7e7e;
  line-height: 28px;
}
.footer-social-icon span {
  color: #fff;
  display: block;
  font-size: 20px;
  font-weight: 700;
  font-family: 'Poppins', sans-serif;
  margin-bottom: 20px;
}
.footer-social-icon a {
  color: #fff;
  font-size: 16px;
  margin-right: 15px;
}
.footer-social-icon i {
  height: 40px;
  width: 40px;
  text-align: center;
  line-height: 38px;
  border-radius: 50%;
}
.facebook-bg{
  background: #27282;
}
.twitter-bg{
  background: #55ACEE;
}
.google-bg{
  background: #DD4B39;
}
.footer-widget-heading h3 {
  color: #272829;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 40px;
  position: relative;
}
.footer-widget-heading h3::before {
  content: "";
  position: absolute;
  left: 0;
  bottom: -15px;
  height: 2px;
  width: 50px;
  background: #ffb703;
}
.footer-widget ul li {
  display: inline-block;
  float: left;
  width: 50%;
  margin-bottom: 12px;
}
.footer-widget ul li a:hover{
  color: #ffb703;
}
.footer-widget ul li a {
  color: #878787;
  text-transform: capitalize;
}
.subscribe-form {
  position: relative;
  overflow: hidden;
}
.subscribe-form input {
  width: 100%;
  padding: 14px 28px;
  background: #2E2E2E;
  border: 1px solid #2E2E2E;
  color: #fff;
}
.subscribe-form button {
    position: absolute;
    right: 0;
    background: #ff5e14;
    padding: 13px 20px;
    border: 1px solid #ff5e14;
    top: 0;
}
.subscribe-form button i {
  color: #fff;
  font-size: 22px;
  transform: rotate(-6deg);
}
.copyright-area{
  background: #272829;
  padding: 25px 0;
}
.copyright-text p {
  margin: 0;
  font-size: 14px;
  color: #FEFBF6;
}
.copyright-text p a{
  color: #ffb703;
}
.footer-menu li {
  display: inline-block;
  margin-left: 20px;
}
.footer-menu li:hover a{
  color: #ffb703;
}
.footer-menu li a {
  font-size: 14px;
  color: #FEFBF6;
}


    </style>
</head>
<body>
    <section>]
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white">
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="./">
    <img src="images/Alumnihub.png" alt="Logo" height="40" width="80">
    ALUMNI HUB
</a>



        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Events</a></li>
                
                <?php if (isset($_SESSION['login_id'])): ?>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=careers">Jobs</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=forum">Forums</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a></li>
                <?php if (!isset($_SESSION['login_id'])): ?>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="login.php" id="login">Login</a></li>
                <?php else: ?>
                    <li class="nav-item">
                        <div class=" dropdown mr-4">
                            <a href="#" class="nav-link js-scroll-trigger" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-angle-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
                                <a class="dropdown-item" href="index.php?page=my_account" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a>
                                <a class="dropdown-item" href="admin/ajax.php?action=logout2"><i class="fa fa-power-off"></i> Logout</a>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
                </section>

    <img class="wave" src="wave.png">
    <div class="container90">
        <div class="img">
            <img src="happy-diverse-students-celebrating-graduation-from-school_74855-5853.avif" alt="">
        </div>
        <div class="login-content">
            <!-- Login Form -->
            <form action="index.html" method="post" id="login-frm">
                <img src="images/Alumnihub.png">
                <h2 class="title">Alumni Hub</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="username">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password">
                    </div>
                </div>
                <div class="g-recaptcha" data-sitekey="6LcQ4nYpAAAAALIR24fu6zLgh98vn6mCgM42e8oW"></div>
                <div class="error-message" id="login-error-message"></div>
                <a href="#" class="action-link" id="forgot_password">Forgot Password?</a>
                <a href="#" class="action-link" id="create_account">Create New Account</a>
                <input type="submit" class="btn" value="Login">
                <p>Please check your email for account verification</p>
            </form>

            <!-- Create Account Form -->
            <form action="index.php?page=signup" method="post" class="hide" id="create-account-form">
                <!-- Add your create account form fields here -->
                <a href="#" class="action-link" id="cancel_create_account">Cancel</a>
                <input type="submit" class="btn" value="Create Account">
            </form>

            <!-- Forgot Password Form -->
            <form action="resetpass.php" method="post" class="hide" id="forgot-password-form">
                <!-- Add your forgot password form fields here -->
                <a href="#" class="action-link" id="cancel_forgot_password">Cancel</a>
                <input type="submit" class="btn" value="Reset Password">
            </form>
        </div>
    </div>
   


    <?php include('footer.php') ?>
<?php if (isset($_SESSION['login_id']) && $_SESSION['login_id'] !== '') include('./chat/chatbox_alumni.php') ?>
<script type="text/javascript">
    $('#login').click(function () {
        uni_modal("Login", 'login.php')
    })
</script>
    <script type="text/javascript" src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $('#login-frm').submit(function(e){
            e.preventDefault();
            $('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');
            if ($(this).find('.error-message').length > 0)
                $(this).find('.error-message').remove();
            $.ajax({
                url: 'admin/ajax.php?action=unilogin',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err);
                    $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                },
                success: function(resp) {
                    const data = JSON.parse(resp)
                    if (data.status === true) {
                        const loginType = Number(data.user_type)

                        if(loginType === 3) 
                            location.href ='<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
                        else
                            location.href = 'admin/index.php?page=home';
                        // Redirect or perform any other action on successful login
                    } else {
                        $('#login-frm').append('<div class="error-message">' + data.message + '</div>');
                        $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    }
                }
            });
        });

        const inputs = document.querySelectorAll(".input");

        function addcl(){
            let parent = this.parentNode.parentNode;
            parent.classList.add("focus");
        }

        function remcl(){
            let parent = this.parentNode.parentNode;
            if(this.value == ""){
                parent.classList.remove("focus");
            }
        }

        inputs.forEach(input => {
            input.addEventListener("focus", addcl);
            input.addEventListener("blur", remcl);
        });

        // Additional JavaScript for showing/hiding forms
        $('#forgot_password').click(function() {
            $('#login-frm').addClass('hide');
            $('#forgot-password-form').removeClass('hide');
        });

        $('#cancel_forgot_password').click(function() {
            $('#login-frm').removeClass('hide');
            $('#forgot-password-form').addClass('hide');
        });

        $('#create_account').click(function() {
            $('#login-frm').addClass('hide');
            $('#create-account-form').removeClass('hide');
        });

        $('#cancel_create_account').click(function() {
            $('#login-frm').removeClass('hide');
            $('#create-account-form').addClass('hide');
        });
    </script>
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
// Check if the reCAPTCHA response is present
if(isset($_POST['g-recaptcha-response'])){
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    // Your secret key from Google reCAPTCHA admin console
    $secretKey = '6LcQ4nYpAAAAADGgThvZxux0DYHzYY9ktQk8v2Ja'; // Replace with your actual secret key
    
    // Verify the reCAPTCHA response
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$recaptchaResponse);
    $responseData = json_decode($verifyResponse);
    
    // If reCAPTCHA response is valid
    if($responseData->success){
        // Proceed with login
        // Your existing login logic here
        if(isset($_POST['login'])){
            // Your existing login logic here
            $customer_email = $_POST['username'];
            $customer_pass = $_POST['password'];
            // Your authentication logic...
        }
    } else {
        // If reCAPTCHA response is invalid, display an error message
        $captcha_error = true;
    }
}
?>

<script>
// Function to handle form submission and validation
function validateForm(event) {
    event.preventDefault(); // Prevent form submission

    // Check if the email and password fields are not empty
    var email = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    
    if (email == "" || password == "") {
        alert("Please fill in all the fields.");
        return false;
    }
    
    // Check if the reCAPTCHA is completed
    if (!grecaptcha.getResponse()) {
        alert("Please complete the CAPTCHA.");
        return false;
    }
    
    // If everything is complete, submit the form
    event.target.submit(); // Submit the form
}
</script>

</body>
</html>
