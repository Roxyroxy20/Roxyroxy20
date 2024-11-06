index.php

<?php
session_start();
require_once('connection.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $connection = $newConnection->openConnection();
    $stmnt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmnt->execute([$username]);
    $user = $stmnt->fetch();

    if ($user) {
        if ($user->password === $password) {
            $_SESSION['user'] = $user->first_name;
            header('Location: main.php');
            exit;
        }
    }
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: pink;
            font-family: 'Montserrat', sans-serif;
        }

        .register-link {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #4CAF50;
            border-radius: 10px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .register-link:hover {
            background-color: #45a049;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .login-container {
            background-color: #FFFFFF;
            padding: 3rem 2rem;
            max-width: 420px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            margin-top: 10%;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .btn-login {
            background-color: green;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #45a049;
        }

        h2 {
            font-weight: 600;
            color: #333333;
        }

        .form-label {
            color: #555555;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <a href="register.php" class="register-link">Register</a>
    <div class="d-flex justify-content-center">
        <div class="login-container text-start">
            <h2 class="text-center mb-4">Login</h2>
            <form action="index.php" method="POST">
                <div class="form-group mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-login" name="login">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>

register.php

<?php
session_start();
require_once('connection.php');

if (isset($_POST['register'])) {
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $address = $_POST['address'];
    $bday = $_POST['bday'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = "Customer";
    $created = date('Y-m-d H:i:s');

    $connection = $newConnection->openConnection();

    $stmnt = $connection->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmnt->execute([$username, $password]);
    $user = $stmnt->fetch();

    if ($user) {
        echo "Username or password already exists. Please choose another one.";
        header('Location: register.php');
    } else {
        try {
            $query = "INSERT INTO users (first_name, last_name, address, birthdate, gender, username, password, role, date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmnt = $connection->prepare($query);
            $stmnt->execute([$firstname, $lastname, $address, $bday, $gender, $username, $password, $role, $created]);

            header('Location: index.php');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #2a2d3e;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            background-color: white;
            border-radius: 15px;
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            box-shadow: rgba(0, 0, 0, 0.15) 0px 8px 24px;
        }

        .container h2 {
            color: #333;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .btn-primary {
            background-color: #4b9fe1;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 700;
            width: 100%;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #3480c1;
        }

        .login-link {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            color: #fff;
            font-weight: 550;
        }

        .login-link:hover {
            color: #4b9fe1;
            text-decoration: underline;
        }

        /* Placeholder color */
        ::placeholder {
            color: #999;
            opacity: 1;
        }
    </style>
</head>

<body>
    <a href="index.php" class="login-link">Login</a>
    <div class="container">
        <h2 class="text-center mb-4">Create Account</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" placeholder="Enter your first name" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" placeholder="Enter your last name" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" placeholder="Enter your address" required>
            </div>
            <div class="mb-3">
                <label for="inputDate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="inputDate" name="bday" required>
            </div>
            <div class="mb-3">
                <label for="inputState" class="form-label">Gender</label>
                <select id="inputState" class="form-select" name="gender" required>
                    <option selected disabled>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Choose a username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter a password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>
