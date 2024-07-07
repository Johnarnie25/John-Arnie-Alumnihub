<?php 
include('db_connect.php');
?>
<style>
    .masthead{
        min-height: 23vh !important;
        height: 23vh !important;
    }
     .masthead:before{
        min-height: 23vh !important;
        height: 23vh !important;
    }
    img#cimg{
        max-height: 10vh;
        max-width: 6vw;
    }
</style>
    <form action="" id="create_account">
        <div class="row form-group mb-3">
            <div class="col-md-6">
                <label for="" class="control-label ">Last Name</label>
                <input type="text" class="form-control" name="lastname" required>
            </div>
            <div class="col-md-6">
                <label for="" class="control-label ">First Name</label>
                <input type="text" class="form-control" name="firstname" required>
            </div>
            <div class="col mt-2">
                <label for="" class="control-label ">Middle Name</label>
                <input type="text" class="form-control" name="middlename" >
            </div>
        </div>
        <div class="row form-group mb-3">
            <div class="col-md-6">
                <label for="" class="control-label ">Gender</label>
                <select class="custom-select" name="gender" required>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="" class="control-label ">Batch</label>
                <input type="input" class="form-control datepickerY" name="batch" required>
            </div>
            <div class="col mt-2">
                <label for="" class="control-label ">Course Graduated</label>
                <select class="custom-select select2" name="course_id" required>
                    <option></option>
                    <?php 
                    $course = $conn->query("SELECT * FROM courses order by course asc");
                    while($row=$course->fetch_assoc()):
                    ?>
                        <option value="<?php echo $row['id'] ?>"><?php echo $row['course'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="row form-group mb-3">
            <div class="col-md-12">
                <label for="" class="control-label ">Currently Connected To</label>
                <textarea name="connected_to" id="" cols="30" rows="3" class="form-control"></textarea>
            </div>
            <div class="col mt-2">
                <label for="" class="control-label ">Image</label>
                <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                <img src="" alt="" id="cimg">

            </div>  
        </div>
        <div class="row">
                <div class="col-md-6">
                <label for="" class="control-label ">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="" class="control-label ">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
        </div>
        <div id="msg">
            
        </div>
    </form>
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
$('#create_account').submit(function(e){
    e.preventDefault()
    start_load()
    $.ajax({
        url:'ajax.php?action=signup',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success:function(resp){
            if(resp == 1){
                alert_toast("Data successfully saved",'success')
                setTimeout(function(){
                    location.reload()
                },1500)
            }else{
                $('#msg').html('<div class="alert alert-danger">email already exist.</div>')
                end_load()
            }
        }
    })
})
</script>