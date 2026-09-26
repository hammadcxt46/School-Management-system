<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Fee Payment Management System</title>
            <link
            rel="shortcut icon"
            href="{{ asset('images/logo.png') }}"
            type="image/x-icon"
        />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            padding: 20px 0;
        }

        .hero {
            background: goldenrod;
            padding: 50px 20px;
            text-align: center;
            color: #fff;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
        }

        section {
            padding: 30px 20px;
        }

        footer {
            margin-top: auto;
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px 0;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        @media (min-width: 768px) {
            .hero {
                text-align: left;
            }

            .cta {
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <header class="container">
        <div class="row">
            <div class="col-6">
                <div class="logo">School Fee Management System</div>
            </div>
            <div class="col-6 text-right">
                <button onclick="window.location.href='{{ route('filament.admin.auth.login') }}'" class="btn btn-primary">Login</button>
            </div>
        </div>
    </header>

    <section class="hero container">
        <div class="row">
            <div class="col-md-10">
                <h1>Effortlessly Track and Manage School Fees</h1>
                <p>Streamline fee tracking and payment processes with our comprehensive School Management System.</p>
                <button onclick="window.location.href='{{ route('guest.request') }}'" class="btn btn-light">Get Started</button>
            </div>
        </div>
    </section>

    <section class="about container">
        <h2>About Our System</h2>
        <p>Our School Management System is designed to simplify the process of tracking and managing school fees. It provides an easy-to-use platform for administrators, teachers, and parents to stay on top of payments and ensure financial transparency.</p>
    </section>

    <section class="features container">
        <h2>Key Features</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="{{ asset('images/img.jpeg') }}" alt="Real-time Fee Tracking">
                <h3>Real-time Fee Tracking</h3>
                <p>Monitor fee payments in real-time and stay updated with instant notifications.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="{{ asset('images/Untitled.jpeg') }}" alt="Automated Dashboard">
                <h3>Automated Dashboard</h3>
                <p>Get a clear overview of fee payment performance with our intuitive dashboard.</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="{{ asset('images/images.jpeg') }}" alt="Automated Receipts">
                <h3>Automated Receipts</h3>
                <p>Fee payment receipts are automatically generated and printed for convenience.</p>
            </div>
        </div>
    </section>

    <footer>
        <div>
            <p>&copy; 2024 SCHOOL FEE MANAGEMENT SYSTEM</p>
            <p>Contact us: <a href="tel:+254798808796">+254798808796</a> | <a href="tel:+254706748162">+254706748162</a> | <a href="mailto:info@schoolfeemanagementsystem.com">info@schoolfeemanagementsystem.com</a></p>
            <p>All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
