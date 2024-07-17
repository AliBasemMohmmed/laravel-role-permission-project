<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pharmacy</title>
    <style>
        /* styles.css */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        nav {
            background-color: #4CAF50;
            display: flex;
            justify-content: center;
            padding: 1em;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        nav a {
            color: white;
            margin: 0 1em;
            text-decoration: none;
            font-size: 1.2em;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .section {
            padding: 100px 0;
            text-align: center;
            margin-top: 70px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .container img:hover {
            transform: scale(1.1);
        }

        h1,
        h2 {
            margin-bottom: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .section {
            animation: fadeIn 2s ease-in;
        }
    </style>
</head>

<body>
    <nav>
        <a href="#home">Home</a>
        <a href="#about">About Us</a>
        <a href="#treatments">Treatments</a>
        <a href="#contact">Contact</a>
    </nav>

    <section id="home" class="section">
        <div class="container">
            <h1>Welcome to My Pharmacy</h1>
            <p>Your health, our priority.</p>
            <img src="icon/ertyu.ico" alt="Pharmacy">

        </div>
        <a class="btn btn-secondary" href="{{ route('patients.show', Auth::user()->id) }}">
            <i class="bi bi-bag"></i> View My Pharmacy</a>

    </section>

    <section id="about" class="section">
        <div class="container">
            <h2>About Us</h2>
            <p>Learn more about our mission and values.</p>
            <img src="icon/ertyu.ico" alt="About Us">
        </div>
    </section>

    <section id="treatments" class="section">
        <div class="container">
            <h2>Our Treatments</h2>
            <p>Explore the treatments we offer.</p>
            <img src="icon/ertyu.ico" alt="Treatments">
        </div>
    </section>

    <section id="contact" class="section">
        <div class="container">
            <h2>Contact Us</h2>
            <p>Get in touch with us for any inquiries.</p>
            <img src="icon/ertyu.ico" alt="Contact">
        </div>
    </section>

    <script src="app.js"></script>
</body>

</html>
