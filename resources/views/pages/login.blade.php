<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.title') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/thirdparty/dashmin') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ asset('assets/thirdparty/dashmin') }}/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
        rel="stylesheet" />
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/thirdparty/dashmin') }}/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/thirdparty/dashmin') }}/css/style.css" rel="stylesheet">
    
    
    {{-- FONT ASWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>{{ config('app.title') }}</h3>
                            </a>
                            <h3>Admin Sign-In</h3>
                            @if(session('invalid'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('invalid') }}
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('login_post') }}" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </form>
                        
                        {{-- <p class="text-center mb-0">Don't have an Account? <a href="">Sign Up</a></p> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/thirdparty/dashmin') }}/lib/chart/chart.min.js"></script>
    <script src="{{ asset('assets/thirdparty/dashmin') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('assets/thirdparty/dashmin') }}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{ asset('assets/thirdparty/dashmin') }}/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/thirdparty/dashmin') }}/lib/tempusdominus/js/moment.min.js"></script>
    <script src="{{ asset('assets/thirdparty/dashmin') }}/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="{{ asset('assets/thirdparty/dashmin') }}/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    
    <!-- Template Javascript -->
    <script src="{{ asset('assets/thirdparty/dashmin') }}/js/main.js"></script>
    
    {{-- ChartJS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"
        integrity="sha512-CQBWl4fJHWbryGE+Pc7UAxWMUMNMWzWxF4SQo9CgkJIN1kx6djDQZjh3Y8SZ1d+6I+1zze6Z7kHXO7q3UyZAWw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>