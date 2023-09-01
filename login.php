<?php
session_start();
require "./database/bloggin.php";
require "./partials/header.php";

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //echo "yes";
    // isset
    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        empty($email) ? $errors[] = "email required..." : "";
        empty($password) ? $errors[] = "password required..." : "";
        // end of login
        if (count($errors) === 0) {
            // end of check errors
            $admin_login = "SELECT * FROM admins WHERE email=:email";
            $a = $pdo->prepare($admin_login);
            $a->bindParam(":email", $email, PDO::PARAM_STR);
            $a->execute();
            $admin_res = $a->fetch();

            if ($admin_res) {
                if ($email === $admin_res['email']  && password_verify($password, $admin_res['password'])) {
                    $_SESSION['admin'] = 'admin';
                    $_SESSION['admin_name'] = $admin_res['name'];
                    $_SESSION['admin_id'] = $admin_res['admin_id'];
                    header("location:admin-dashboard.php");
                } else {
                    $errors[] = "Admin Email does not exist";
                }
            }
            $check_qry = "SELECT * FROM users WHERE email=:email";
            $c = $pdo->prepare($check_qry);
            $c->bindParam(":email", $email, PDO::PARAM_STR);
            $c->execute();
            $res = $c->fetch();
            if ($res) {
                if (
                    $email ===  $res['email']  && password_verify($password, $res['password'])
                ) {
                    $_SESSION['user'] = 'user';
                    $_SESSION['user_name'] = $res['name'];
                    $_SESSION['user_id'] = $res['user_id'];
                    $_SESSION['photo'] = $res['photo'];
                    header("location:blogo.php");
                } else {
                    $errors[] = "Email does not exist";
                }
            }
        }
    }
}
?>


<body class=" bg-blue-100">
    <div class="flex  min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-blue-100 ">
        <!-- title -->
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="" alt="">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Log In Now</h2>
        </div>
        <!-- form -->
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="login.php" method="post">
                <?php require "./partials/errors.php" ?>
                <!-- email -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email </label>
                    </div>
                    <div class="mt-2">
                        <input name="email" type="email" autocomplete="email" required class="block   px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <!-- password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>

                    </div>
                    <div class="mt-2">
                        <input name="password" type="password" autocomplete="current-password" required class="block px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div>
                    <button type="submit" name="login" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Log
                        in</button>
                </div>

                <p class="mt-10 text-center text-sm text-gray-500">
                    Not a member?
                    <a href="register.php" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Register
                        Here</a>
                </p>
            </form>
        </div>
        <!-- submit -->
    </div>



    <?php
    require "./partials/footer.php";
    ?>