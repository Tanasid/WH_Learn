<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/login.css">
    <title>Login</title>

</head>

<body>

    <!-- <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg text-light" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <?php if (session()->getFlashdata('msg')) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('msg'); ?></div>
                            <?php endif; ?>
                            <form action="/login/auth" method="post">
                                <h3 class="mb-5 fs-1">Sign in</h3>
                                <div class="form-outline mb-4">
                                    <input type="text" id="su_emp_code" name="emp_code" class="form-control form-control-lg" required />
                                    <label class="form-label fs-5 mt-1" for="emp_code">Employee Code</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="emp_password" name="emp_password" class="form-control form-control-lg" required />
                                    <label class="form-label fs-5 mt-1"" for=" emp_password">Password</label>
                                </div>

                                <button class="btn btn-lg btn-block btn-primary mb-2 px-5 btn-pop" style="background-color: #3b5998;" type="submit" id="login">LOGIN</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <div class="login-box">
        <div class="box-test">
            <h1>Login</h1>
            <?php if (session()->getFlashdata('msg')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('msg'); ?></div>
            <?php endif; ?>
            <form action="/login/auth" method="post">
                <div class="user-box">
                    <input type="text" id="su_emp_code" name="emp_code" required>
                    <label>Username</label>
                </div>
                <div class="user-box">
                    <input type="password" id="emp_password" name="emp_password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn btn-none">
                    <a class="">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Login
                    </a>
                </button>
            </form>
        </div>
    </div>

    <!-- <div class="login mx-auto">
        <div class="form">
            <h2>Welcome</h2>
            <input type="text" placeholder="Username">
            <input type="password" placeholder="Password">
            <input type="submit" value="Sign In" class="submit">
        </div>
    </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="/assets/js/login.js"></script>

</body>

</html>