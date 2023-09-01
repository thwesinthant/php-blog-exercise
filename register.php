<?php
require "./database/bloggin.php";
require "./partials/header.php";
$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['register'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $confirm_password = trim($_POST['confirm_password']);
        $confirm_password = password_hash($confirm_password, PASSWORD_BCRYPT);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $pname = $_FILES['photo']['name'];
        $tmpname = $_FILES['photo']['tmp_name'];
        move_uploaded_file($tmpname, "Register_Image/$pname");
        empty($name) ? $errors[] = "name required..." : "";
        empty($email) ? $errors[] = "email required..." : "";
        empty($password) ? $errors[] = "password required..." : "";
        empty($confirm_password) ? $errors[] = "confirm password required..." : "";
        empty($phone) ? $errors[] = "phone required..." : "";
        empty($address) ? $errors[] = "address required..." : "";
        empty($pname) ? $errors[] = "photo required..." : "";

        if (count($errors) === 0) {
            $email_check_qry = "SELECT * FROM users WHERE email=:email";
            $statement = $pdo->prepare($email_check_qry);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->execute();
            $res = $statement->fetch();
            if ($res) {
                $errors[] = "Email Already Exist";
            } else {
                $register_qry = "INSERT INTO users (name,email,password,phone,address,photo,created_date,updated_date) VALUES (:name,:email,:password,:phone,:address,:photo,:created_date,:updated_date)";
                $r = $pdo->prepare($register_qry);
                $r->bindParam(":name", $name, PDO::PARAM_STR);
                $r->bindParam(":email", $email, PDO::PARAM_STR);
                $r->bindParam(":password", $password, PDO::PARAM_STR);
                $r->bindParam(":phone", $phone, PDO::PARAM_STR);
                $r->bindParam(":address", $address, PDO::PARAM_STR);
                $r->bindParam(":photo", $pname, PDO::PARAM_STR);
                $r->bindParam(":created_date", $now, PDO::PARAM_STR);
                $r->bindParam(":updated_date", $now, PDO::PARAM_STR);

                if ($r->execute()) {
                    header("location:login.php");
                } else {
                    $errors[]  = "Oops! Something went wrong. db insert error!.";
                }
            }
        }
    }
}
?>

<body class=" bg-blue-100">
    <form class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-blue-100 " method="post" action="register.php" enctype="multipart/form-data">
        <!-- title -->
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">REGISTER NOW</h2>
        </div>
        <!-- form -->
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="login.php" method="POST">
                <!-- NAME -->
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">enter your name</label>
                <div class="mt-2">
                    <input name="name" type="text" required class="block   px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <!-- email -->
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">enter your email</label>
                <div class="mt-2">
                    <input name="email" type="email" autocomplete="email" required class="block   px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <!-- password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">enter your
                            password</label>
                    </div>
                    <div class="mt-2">
                        <input name="password" type="password" autocomplete="current-password" required class="block px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <!--comfirm password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="cpassword" class="block text-sm font-medium leading-6 text-gray-900">confirm your
                            password</label>

                    </div>
                    <div class="mt-2">
                        <input name="confirm_password" type="password" required class="block px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <!-- phone -->
                <label class="block text-sm font-medium leading-6 text-gray-900">enter your phonenumber</label>
                <div class="mt-2">
                    <input name="phone" type="text" required class="block   px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <!-- address -->
                <label class="block text-sm font-medium leading-6 text-gray-900">enter your address</label>
                <div class="mt-2">
                    <textarea name="address" class="w-full block px-3  rounded-md border-0 py-1.5 bg-white shadow-sm placeholder:text-gray-400 sm:text-sm sm:leading-6 mb-4"></textarea>

                </div>

                <!-- photo -->
                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-medium leading-6 text-gray-900">Your photo</label>
                    </div>
                    <div class="mt-2">
                        <input name="photo" type="file" required class="block px-3 w-full rounded-md border-0 py-1.5 bg-white shadow-sm placeholder:text-gray-400 sm:text-sm sm:leading-6 mb-4">
                    </div>
                </div>
                <!-- button -->
                <div>
                    <button name="register" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register
                        Now</button>
                </div>

                <p class="mt-10 text-center text-sm text-gray-500">
                    already have an account?
                    <a href="register.php" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">login
                        now</a>
                </p>
            </form>
        </div>
        <!-- submit -->
    </form>

    <?php
    require "./partials/footer.php";
    ?>