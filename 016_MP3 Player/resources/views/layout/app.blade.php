<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel MP3 Player</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            color: #e2e8f0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
        }

        .header h1 {
            color: #ffffff;
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            background: linear-gradient(90deg, #60a5fa, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            color: #94a3b8;
            font-size: 1.1rem;
        }

        .player-container {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .upload-btn {
            display: inline-block;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
        }

        .upload-btn i {
            margin-right: 8px;
        }

        .btn-danger {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.5);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #475569, #64748b);
            box-shadow: 0 4px 20px rgba(71, 85, 105, 0.3);
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 25px rgba(71, 85, 105, 0.5);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎵 Laravel MP3 Player</h1>
            <p>Professional dark theme music player</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: linear-gradient(45deg, #10b981, #059669); color: white; padding: 16px; border-radius: 12px; margin-bottom: 20px; text-align: center; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>