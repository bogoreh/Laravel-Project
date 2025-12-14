<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix Clone</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background-color: #141414;
            color: #fff;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 20px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to bottom, rgba(0,0,0,0.8), transparent);
            z-index: 1000;
        }

        .logo {
            color: #e50914;
            font-size: 32px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #b3b3b3;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)),
                        url('https://images.unsplash.com/photo-1489599809516-9827b6d1cf13?w=1600&h=900&fit=crop');
            background-size: cover;
            display: flex;
            align-items: center;
            padding: 0 60px;
        }

        .hero-content {
            max-width: 600px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            color: #b3b3b3;
        }

        .btn {
            padding: 12px 35px;
            background-color: #e50914;
            color: white;
            border: none;
            border-radius: 2px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #f40612;
        }

        .btn-secondary {
            background-color: rgba(109, 109, 110, 0.7);
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background-color: rgba(109, 109, 110, 0.9);
        }

        .container {
            padding: 60px;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .movie-row {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding-bottom: 20px;
        }

        .movie-row::-webkit-scrollbar {
            display: none;
        }

        .movie-card {
            min-width: 200px;
            height: 300px;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s;
            background-size: cover;
            background-position: center;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        .movie-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 20px;
        }

        .movie-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .movie-genre {
            font-size: 12px;
            color: #b3b3b3;
        }

        footer {
            padding: 40px 60px;
            border-top: 1px solid #333;
            text-align: center;
            color: #808080;
            font-size: 14px;
        }

        .player-container {
            height: 70vh;
            background: #000;
            position: relative;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .player-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 40px 60px;
        }

        .movie-details {
            margin-top: 40px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            margin-top: 20px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            color: #777;
            font-size: 14px;
        }

        .info-value {
            font-size: 16px;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>