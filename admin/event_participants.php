<?php
require_once('db_connect.php');
$eventParams = $_GET['event_id'];
$query = "SELECT 
e.id AS event_commit_id,
e.event_id,
e.user_id,
e.role,
u.id AS user_id,
u.name,
u.username,
u.password,
u.type,
u.auto_generated_pass,
u.alumnus_id,
ab.firstname,
ab.middlename,
ab.lastname,
ab.batch,
ab.email
FROM 
event_commits e
JOIN 
users u ON e.user_id = u.id
JOIN 
alumnus_bio ab ON u.alumnus_id = ab.id
WHERE 
e.event_id = $eventParams;
";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participants List</title>
    <!-- Include Bootstrap CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <button class="btn btn-primary btn-sm" id="download">Download as PDF</button>
        <div class="row justify-content-center">
            <div class="card" id="participantstable">
                <div class="card-header">
                    <h1 class="display-6 text-center">Participants</h1>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <tr class="bg-dark text-white">
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Batch</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <!-- <th>Delete</th> -->
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row['firstname']; ?></td>
                                <td><?php echo $row['middlename']; ?></td>
                                <td><?php echo $row['lastname']; ?></td>
                                <td><?php echo date('Y', strtotime($row['batch'])); ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <!-- <td><button class="btn btn-sm btn-outline-danger delete_event" type="button" data-id="<?php echo $row['id'] ?>">Delete</button></td> -->
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
			const button = document.getElementById('download');

			function generatePDF() {
				const element = document.getElementById('participantstable');
				html2pdf().from(element).save();
			}

			button.addEventListener('click', generatePDF);
		</script>
    <!-- Include Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>