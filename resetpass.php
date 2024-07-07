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
        <input type="email" class="d-block form-control w-100 mb-3" placeholder="Email"/>
        <center>
            <a href="index.php" class="btn btn-secondary me-3">Go Back</a>
            <button class="btn btn-primary" onClick="sendEmail()">Reset Password</button>
        <center>
    </div>
    <script>
        const sendEmail = async () => {
            const email = document.querySelector('input').value?.trim()

            if(!email) return

            const api = await fetch('./sendemail.php?email='+email)
            const res = await api.text()

            console.log(res)
            alert(res)
            document.querySelector('input').value = ""
        }
    </script>
</body>
</html>
