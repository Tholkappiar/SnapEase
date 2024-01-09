<?php

$login_page = false;
$result = false;

if (
    isset($_POST["login-email"]) && isset($_POST['login-password']) && (!empty($_POST['login-password'])) && (!empty($_POST['login-email']))
    && isset($_POST['login-fingerprint']) && (!empty($_POST['login-fingerprint']))
) {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];
    $fingerprint = $_POST['login-fingerprint'];

    $user = new UserSessions();
    $result = $user->authenticate($email, $password, $fingerprint);
    
    if($result) {
        $login_page = true;
    }
}
if ($result && $login_page) {
    if(Sessions::isset('_redirect')) {
        $redirect_url = Sessions::get('_redirect');
    } else {
        $redirect_url = '/';
    }
?>
    
    <main class="container">
        <div class="bg-light p-5 rounded mt-3">
            <h1>Login Success</h1>
            <p class="lead">You will be Redirected in 2 Seconds ...</p>
        </div>
    </main>
    <script>
        setTimeout(function () {
                var redirectUrl = "<?php echo $redirect_url; ?>";
                window.location.href = redirectUrl;
            }, 2000);
    </script>
<?
} else {
?>
    <section class="vh-100" style="background-color: #9A616D;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" /> -->
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="post" action="login.php">

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Logo</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                                        <div class="mb-3">
                                            <label for="exampleDropdownFormEmail2" class="form-label">Email address</label>
                                            <input name="login-email" type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleDropdownFormPassword2" class="form-label">Password</label>
                                            <input name="login-password" type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                                        </div>
                                        <input name="login-fingerprint" type="hidden" class="form-control" id="fingerprint">
                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        </div>

                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!" style="color: #393f81;">Register here</a></p>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet" />
    </section>

<?
}
?>
<script>

// TODO : Remove the api and generate the normal the fingerprint.

// Initialize the agent once at web application startup.
// Alternatively initialize as early on the page as possible.
var fPromise = import('https://openfpcdn.io/fingerprintjs/v3')
    .then(FingerprintJS => FingerprintJS.load())

// Analyze the visitor when necessary.
fPromise
    .then(fp => fp.get())
    .then(result => {
        const visitorId = result.visitorId;
        // console.log(visitorId);
        document.getElementById('fingerprint').value = visitorId;
    })

// console.log(result.requestId, "visitor : " + result.visitorId))
</script>
