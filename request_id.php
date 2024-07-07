<?php 
include 'admin/db_connect.php'; 
?>
<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Request ID</h3>
                <hr class="divider my-4" />

            <div class="col-md-12 mb-2 justify-content-center">
            </div>                        
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
                        <form action="" id="create_account">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label ">First Name</label>
                                    <input type="text" class="form-control" name="firstname" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label ">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" >
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label">SY</label>
                                    <input type="input" class="form-control datepickerY" name="sy_start" required>
                                    <label for="" class="control-label">To</label>
                                    <input type="input" class="form-control datepickerY" name="sy_end" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="control-label ">Course</label>
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
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="" class="control-label ">Image</label>
                                    <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                                    <img src="" alt="" id="cimg">
                                </div>  
                            </div>
                            <div id="msg">
                                
                            </div>
                            <hr class="divider">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary">Request ID</button>
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
$('#create_account').submit(function(e){
    e.preventDefault()
    start_load()
    $.ajax({
        url:'admin/ajax.php?action=requestid',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success:function(resp){
            if(resp == 1){
                // location.replace('index.php')
            }else{
                $('#msg').html('<div class="alert alert-danger">Error Occured</div>')
                end_load()
            }
        }
    })
})
</script>