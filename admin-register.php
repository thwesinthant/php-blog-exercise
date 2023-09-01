<?php
session_start();
$admin = isset($_SESSION['admin']);
require "./database/bloggin.php";
require "./partials/header.php";
require "./partials/sidenav.php";
$date = new DateTime('now');
$now = $date->format("Y-m-d H:i:s");
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['register'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);

        empty($name) ? $errors[] = "name required..." : "";
        empty($email) ? $errors[] = "email required..." : "";
        empty($password) ? $errors[] = "password required..." : "";

        if (count($errors) === 0) {
            $email_check_qry = "SELECT * FROM admins WHERE email=:email";
            $statement = $pdo->prepare($email_check_qry);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->execute();
            $res = $statement->fetch();
            if ($res) {
                $errors[] = "Email Already Exist";
            } else {
                $admin_register_qry = "INSERT INTO admins (name,email,password,created_date,updated_date) VALUES (:name,:email,:password,:created_date,:updated_date)";
                $r = $pdo->prepare($admin_register_qry);
                $r->bindParam(":name", $name, PDO::PARAM_STR);
                $r->bindParam(":email", $email, PDO::PARAM_STR);
                $r->bindParam(":password", $password, PDO::PARAM_STR);
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
<div class="col-span-6 m-auto pe-10">
    <form class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8  " method="post" action="admin-register.php"
        enctype="multipart/form-data">
        <div class="w-96 p-3 border border-black shadow rounded bg-white">
            <!-- title -->
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class=" text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">REGISTER NEW
                </h2>
            </div>
            <!-- form -->
            <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="login.php" method="POST">
                    <!-- NAME -->
                    <div class="mt-2">
                        <input name="name" type="text" required placeholder="enter your username"
                            class="block   px-3 w-full rounded-md border border-black mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <!-- email -->
                    <div class="mt-2">
                        <input name="email" type="email" placeholder="enter your email" autocomplete="email" required
                            class="block   px-3 w-full rounded-md border border-black mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <!-- password -->
                    <div class="mt-2">
                        <input name="password" type="password" placeholder="enter your password"
                            autocomplete="current-password" required
                            class="block px-3 w-full rounded-md border border-black mb-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <!-- button -->
                    <div>
                        <button name="register"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register
                            Now</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- submit -->
    </form>
</div>
<?php
require "./partials/footer.php";
?>