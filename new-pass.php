<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center pt-5 bg-dark">
    <div class="shadow rounded p-4 bg-light" style="max-width:500px;width:100%">
        <label>New Password</label>
        <input type="password" class="d-block form-control w-100 mb-3" id="new-pass"/>
        <input type="hidden" id="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>"/>
        <center>
            <button class="btn btn-primary" id="resetButton">Reset</button>
        <center>
    </div>
<script>
    document.getElementById('resetButton').addEventListener('click', function() {
        var newPassword = document.getElementById('new-pass').value;
        var email = document.getElementById('email').value;

        fetch('reset-pass-action.php', {
            method: 'POST',
            body: JSON.stringify({
                email,
                newPassword
            })
        })
        .then(response => response.text())
        .then(data => {
            alert(data)
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    });
</script>
</body>
</html>
