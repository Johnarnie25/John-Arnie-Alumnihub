<?php include 'admin/db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM careers where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<p>Company: <b><large><?php echo ucwords($company) ?></large></b></p>
	<p>Job Title: <b><large><?php echo ucwords($job_title) ?></large></b></p>
	<p>Location: <i class="fa fa-map-marker"></i> <b><large><?php echo $company ?></large></b></p>
	<hr class="divider">
	<?php echo html_entity_decode($description) ?>
</div>
<div class="modal-footer display">
	<div class="input-group mb-3">
		<input type="file" class="form-control" id="cv-file">
		<button class="btn btn-outline-secondary" type="button" onclick="handleUploadCV('<?php echo $_GET['id'];?>')">Upload CV</button>
	</div>
	<div class="row">
		<div class="col-md-12 p-0">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
<script>
	const handleUploadCV = async (careerId) => {
		const cvFileInput = document.getElementById('cv-file');
        const cvFile = cvFileInput.files[0];
        
        if (!cvFile) {
            alert('Please select a file.');
            return;
        }
		console.log(cvFile)
        const formData = new FormData();
        formData.append('cv', cvFile);
        formData.append('career_id', careerId);

		try {
			const api = await fetch('admin/ajax.php?action=uploadcv', {
				method: 'POST',
				body: formData,
			})

			const resp = await api.text()

			if (resp == "1") {
				alert('CV uploaded successfully.');
				location.reload()
			} else {
				alert('CV upload failed.');
			}
		} catch (error) {
            console.error('Error:', error);
            alert('CV upload failed.');
        }
	}
</script>
<style>
	p{
		margin:unset;
	}
	#uni_modal .modal-footer{
		display: none;
	}
	#uni_modal .modal-footer.display {
		display: block;
	}
</style>
<script>
	$('.text-jqte').jqte();
	$('#manage-career').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=save_career',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})
</script>