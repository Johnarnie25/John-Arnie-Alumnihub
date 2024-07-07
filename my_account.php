<?php 

$conn= new mysqli('localhost','root','','alumni_db')or die("Could not connect to mysql".mysqli_error($con));
// Assume session_start() is called somewhere before this point to start the session.

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'update_account') {
    // Validate and sanitize the inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    // Add more validations if necessary

    // Check if the email already exists in the database
    $existingEmailQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $existingEmailQuery->bind_param('s', $email);
    $existingEmailQuery->execute();
    $existingEmailQuery->store_result();
    
    if ($existingEmailQuery->num_rows > 0) {
        // Email already exists, return an error response
        echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
        exit();
    }

    // Continue with the update process since email is unique
    // Add your update logic here...

    // Return a success response
    echo json_encode(['status' => 'success', 'message' => 'Account successfully updated.']);
    exit();
}
?>

<!-- Continue with the rest of your HTML code -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        body {
            background-color: white;
            color: black;
        }

        .masthead {
            background-color: white !important;
        }

        .card {
            background-color: white !important;
            color: black;
        }

        /* Add any additional styles here */
    </style>
</head>
<body>
    <header class="masthead">
        <div class="container-fluid h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end mb-4 page-title">
                    <h3 class="text-white">Manage Account</h3>
                    <hr class="divider my-4" />
                </div>
            </div>
        </div>
    </header>

<div class="container mt-3 pt-2">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <form action="" id="update_account">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="<?php echo isset($_SESSION['bio']['lastname']) ? $_SESSION['bio']['lastname'] : ''; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="<?php echo isset($_SESSION['bio']['firstname']) ? $_SESSION['bio']['firstname'] : ''; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" value="<?php echo isset($_SESSION['bio']['middlename']) ? $_SESSION['bio']['middlename'] : ''; ?>">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">Gender</label>
                                    <select class="custom-select" name="gender" required>
                                        <option <?php echo (isset($_SESSION['bio']['gender']) && $_SESSION['bio']['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option <?php echo (isset($_SESSION['bio']['gender']) && $_SESSION['bio']['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Batch</label>
                                    <input type="input" class="form-control datepickerY" name="batch" value="<?php echo isset($_SESSION['bio']['batch']) ? $_SESSION['bio']['batch'] : ''; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Course Graduated</label>
                                    <select class="custom-select select2" name="course_id" required>
                                        <option></option>
                                        <?php
                                        $course = $conn->query("SELECT * FROM courses order by course asc");
                                        while ($row = $course->fetch_assoc()):
                                        ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo (isset($_SESSION['bio']['course_id']) && $_SESSION['bio']['course_id'] == $row['id']) ? 'selected' : ''; ?>><?php echo $row['course'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <label for="" class="control-label">Currently Connected To</label>
                                    <textarea name="connected_to" id="" cols="30" rows="3" class="form-control"><?php echo isset($_SESSION['bio']['connected_to']) ? $_SESSION['bio']['connected_to'] : ''; ?></textarea>
                                </div>
                                <div class="col-md-5">
                                    <label for="" class="control-label">Image</label>
                                    <input type="file" class="form-control" name="img" onchange="displayImg(this, $(this))">
                                    <img style="display:block;width:325px;" src="admin/assets/uploads/<?php echo isset($_SESSION['bio']['avatar']) ? $_SESSION['bio']['avatar'] : ''; ?>" alt="" id="cimg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo isset($_SESSION['bio']['email']) ? $_SESSION['bio']['email'] : ''; ?>" >
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                    <small><i>Leave this blank if you dont want to change your password</i></small>
                                </div>
                            </div>
                            <div id="msg"></div>
                            <hr class="divider">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary">Update Account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
   $('.datepickerY').datepicker({
        format: " yyyy", 
        viewMode: "years", 
        minViewMode: "years"
   })
   $('.select2').select2({
    placeholder:"Please Select Here",
    width:"100%"
   })
   function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$('#update_account').submit(function(e){
    e.preventDefault()
    start_load()
    $.ajax({
        url:'admin/ajax.php?action=update_account',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success:function(resp){
            if(resp == 1){
                alert_toast("Account successfully updated.",'success');
                setTimeout(function(){
                 location.reload()
                },700)
            }else{
                $('#msg').html('<div class="alert alert-danger">email already exist.</div>')
                end_load()
            }
        }
    })
})
</script>