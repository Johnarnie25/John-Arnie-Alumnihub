<?php include('db_connect.php');?>

<div class="container-fluid">
	
<div class="card col-lg-12" style="border: 1px solid 
#ffb703; background-color: 
#FEFBF6;">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-12">
					<button class="btn btn-primary float-right btn-sm" id="new_alumni"><i class="fa fa-plus"></i> New Alumni</button>
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Request ID</b>
						<!-- <span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=manage_alumni" id="new_alumni">
					<i class="fa fa-plus"></i> New Entry
				</a></span> -->
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<!-- <colgroup>
								<col width="5%">
								<col width="10%">
								<col width="15%">
								<col width="15%">
								<col width="30%">
								<col width="15%">
							</colgroup> -->
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Image</th>
									<th class="">Name</th>
									<th class="">Course</th>
									<th class="">SY</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$request = $conn->query("SELECT 
								req.`id`, 
								req.`lastname`, 
								req.`firstname`, 
								req.`middlename`, 
								req.`img`, 
								req.`sy_start`, 
								req.`sy_end`, 
								req.`course_id`, 
								req.`dateCreated`,
								courses.`course`,
								courses.`about`
							FROM 
								`requesti_id` AS req
							JOIN 
								`courses` AS courses ON req.`course_id` = courses.`id`
							WHERE 
								req.`course_id` IS NOT NULL;");
								while($row=$request->fetch_assoc()):
									
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<div class="avatar">
										 <img src="assets/uploads/<?php echo $row['img']; ?>" class="" alt="">
										</div>
									</td>
									<td class="">
										 <p> <b><?php echo ucwords($row['firstname']).' '.ucwords($row['middlename']).' '.ucwords($row['lastname']); ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['course'] ?></b></p>
									</td>
									<td class="text-center">
										<p> <b><?php echo $row['sy_start'].'-'.$row['sy_end']; ?></b></p>

									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
	.avatar {
	    display: flex;
	    border-radius: 100%;
	    width: 100px;
	    height: 100px;
	    align-items: center;
	    justify-content: center;
	    border: 3px solid;
	    padding: 5px;
	}
	.avatar img {
	    max-width: calc(100%);
	    max-height: calc(100%);
	    border-radius: 100%;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#new_alumni').click(function(){
		uni_modal('New Alumni','new_alumni.php')
	})
	$('.view_alumni').click(function(){
		uni_modal("Bio","view_alumni.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.delete_alumni').click(function(){
		_conf("Are you sure to delete this alumni?","delete_alumni",[$(this).attr('data-id')])
	})
	
	function delete_alumni($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_alumni',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				console.log(resp)
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>