<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Student Study Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .display-4 {
            font-weight: 300;
            color: #007bff;
        }

        .lead {
            font-size: 1.25rem;
            color: #6c757d;
        }

        .img-fluid {
            transition: transform 0.3s ease;
        }

        .img-fluid:hover {
            transform: scale(1.05);
        }

        .shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Edu Platform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active"
                            href="{{ route('dashboardes.index') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact.form') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 text-primary mb-4">Welcome to Our Student Study Platform</h1>
                <p class="lead mb-5">
                    As someone deeply committed to the success of every student, I created this website to provide a
                    dedicated space for learning and growth. Here, students can access resources, study materials, and
                    tools to excel in their education. Your progress matters to me—let's study together!
                </p>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <img src="https://tse3.mm.bing.net/th/id/OIP.RZEtqJKaylJFx2Gf6M5GJAHaE8?pid=Api&P=0&h=180"
                            alt="Developer Profile" class="img-fluid rounded shadow" style="max-height: 200px;">
                        <p class="mt-2">Hard Work</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <img src="https://tse1.mm.bing.net/th/id/OIP.s2j0f-YvYc394p6m8Oc00wHaE7?pid=Api&P=0&h=180"
                            alt="Books and knowledge" class="img-fluid rounded shadow" style="max-height: 200px;">
                        <p class="mt-2">Empowering Learning Journeys</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <img src="https://tse4.mm.bing.net/th/id/OIP.VN_BDTFDbOWzSV6A-imtAwHaEK?pid=Api&P=0&h=180"
                            alt="Global education" class="img-fluid rounded shadow" style="max-height: 200px;">
                        <p class="mt-2">Supporting Students Worldwide</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
