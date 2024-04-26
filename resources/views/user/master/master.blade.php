<!doctype html>
<html lang="en">
<head>
    <title>Sidebar 01</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('../assets/user/css/style.css') }}">
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url({{ asset('../assets/user/images/logo.jpg') }});"></a>
                <ul class="list-unstyled components mb-5">
                    <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Dashboard</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Dashboard 1</a></li>
                            <li><a href="#">Dashboard 2</a></li>
                            <li><a href="#">Dashboard 3</a></li>
                        </ul>
                    </li>
                    <li><a href="#">About</a></li>
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li><a href="#">Page 1</a></li>
                            <li><a href="#">Page 2</a></li>
                            <li><a href="#">Page 3</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Portfolio</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5">
        <iframe title="Final_Viet" width="100%" height="100%" src="https://app.powerbi.com/view?r=eyJrIjoiMzExMTRmMTktOWI3Ny00MmNiLWEyOTAtNjkzNzRiYjg3NTk4IiwidCI6ImI5MzcwZTAxLTc3MmEtNDkyNy1hZGUwLTdkYThiMTg3ZGU0MSIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>
        </div>
    </div>

    <script src="{{ asset('../assets/user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('../assets/user/js/popper.js') }}"></script>
    <script src="{{ asset('../assets/user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('../assets/user/js/main.js') }}"></script>
</body>
</html>
