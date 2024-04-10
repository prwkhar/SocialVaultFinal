
<body>
    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form method="post" action="assets/php/actions.php?login">
                <div class="d-flex justify-content-center">

                    <img class="mb-4" src="assets/images/logo.jpg" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 fw-normal">Please sign in</h1>

                <div class="form-floating">
                    <input type="text" name="username" value="<?=showformdata('username')?>" class="form-control rounded-0" placeholder="username">
                    <label for="floatingInput">username</label>
                </div>
                <?=showerror('username')?>

                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="password">
                    <label for="floatingPassword">password</label>
                </div>
                
                <?=showerror('checkuser')?>
                <?=showerror('password')?>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary" type="submit">Sign in</button>
                    <a href="?signup" class="text-decoration-none">Create New Account</a>

                </div>
            </form>
        </div>
    </div>

