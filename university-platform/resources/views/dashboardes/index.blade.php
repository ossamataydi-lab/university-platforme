<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Dashboard - Welcome to Our Educational Hub</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="https://tse3.mm.bing.net/th/id/OIP.8tZ9iwt1pCAJVUarYDZhTQHaHa?pid=Api&P=0&h=180">
    <style>
        /* Custom styles for better dashboard feel */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            animation: fadeIn 1.2s ease-in-out;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s forwards;
        }

        .card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            background: #f8f9fa;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: popIn 1s ease;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.98);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Slide-up animation for cards */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Pop-in animation for icons */
        @keyframes popIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            80% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        /* Fade-in for CTA and Footer */
        .bg-light,
        footer {
            animation: fadeIn 1.5s ease-in-out;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar (Optional - Customize or remove) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Edu Platform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link "
                            href="{{ route('dashboardes.index') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact.form') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section py-5 text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Welcome to Our University Dashboard</h1>
            <p class="lead mb-4">Explore the comprehensive features our website offers to enhance your educational
                experience at our university.</p>
            <a href="#features" class="btn btn-light btn-lg">Discover More</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">What Our Website Offers</h2>
            <div class="row g-4">
                @if (isset($features) && count($features) > 0)
                    @foreach ($features as $feature)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-body text-center p-4">
                                    <div class="feature-icon mb-3">
                                        <i class="fas {{ $feature['icon'] ?? 'fa-star' }} fa-2x text-primary"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-3">{{ $feature['title'] ?? 'Feature Title' }}</h5>
                                    <p class="card-text text-muted">{{ $feature['description'] ?? 'Description here.' }}
                                    </p>
                                    <a href="{{ $feature['link'] ?? '#' }}" class="btn btn-outline-primary">Learn
                                        More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback static features if no data passed -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Academic Programs</h5>
                                <p class="card-text text-muted">Explore our wide range of undergraduate and postgraduate
                                    courses in various disciplines.</p>
                                {{-- <a href="/academics" class="btn btn-outline-primary">Learn More</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-user-plus fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Admissions</h5>
                                <p class="card-text text-muted">Apply online for admissions, check eligibility, and
                                    track your application status.</p>
                                {{-- <a href="/admissions" class="btn btn-outline-primary">Learn More</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-calendar fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Events & News</h5>
                                <p class="card-text text-muted">Stay updated with university events, seminars,
                                    workshops, and latest news.</p>
                                {{-- <a href="/events" class="btn btn-outline-primary">Learn More</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-laptop fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Student Portal</h5>
                                <p class="card-text text-muted">Access your grades, timetable, library resources, and
                                    more with our secure portal.</p>
                                {{-- <a href="/student-portal" class="btn btn-outline-primary">Learn More</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Faculty & Research</h5>
                                <p class="card-text text-muted">Meet our esteemed faculty and explore ongoing research
                                    opportunities.</p>
                                {{-- <a href="/faculty" class="btn btn-outline-primary">Learn More</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-heart fa-2x text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Campus Life</h5>
                                <p class="card-text text-muted">Discover student clubs, facilities, hostels, and
                                    extracurricular activities.</p>
                                {{-- <a href="/campus-life" class="btn btn-outline-primary">Learn More</a> --}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Call to Action Section (Optional) -->
    <section class="bg-light dark:bg-gray-700 py-5">
        <div class="container text-center">
            <h3 class="mb-3 text-dark dark:text-gray-100">Ready to Get Started?</h3>
            <p class="mb-4 text-muted dark:text-gray-300">Join our vibrant community and unlock endless opportunities.</p>
            <a href="{{ route('register.form') }}" class="btn btn-primary dark:bg-blue-600 dark:hover:bg-blue-700 btn-lg">Apply Now</a>
        </div>
    </section>

    <!-- Footer (Optional) -->
    <footer class="bg-dark dark:bg-gray-900 text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Ibn Tofail. All rights reserved. | Built by Ossama TAydi</p>
        </div>
    </footer>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
