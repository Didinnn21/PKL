<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Kestore.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .container {
            text-align: center;
            padding: 2rem;
        }

        .brand-logo {
            font-size: 3.5rem;
            font-weight: 700;
            color: #d4af37;
            /* Warna aksen emas */
            margin-bottom: 1rem;
        }

        .btn-custom-login {
            border: 2px solid #d4af37;
            color: #d4af37;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-custom-login:hover {
            background-color: #d4af37;
            color: #1a1a1a;
        }

        .btn-custom-register {
            background-color: #f0f0f0;
            color: #1a1a1a;
            border: 2px solid #f0f0f0;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-custom-register:hover {
            background-color: transparent;
            color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="brand-logo">Kestore.id</h1>
        <p class="lead mb-4">Solusi E-Commerce Modern untuk Bisnis Anda.</p>
        <div>
            <a href="{{ route('login') }}" class="btn btn-custom-login me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-custom-register">Register</a>
        </div>
    </div>
</body>

</html>
