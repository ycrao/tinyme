<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to TinyMe</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .page {
            text-align: center;
            padding: 32px 24px;
        }
        .logo {
            font-size: 40px;
            letter-spacing: 4px;
            margin-bottom: 8px;
        }
        .tagline {
            font-size: 16px;
            color: #666;
            margin-bottom: 24px;
        }
        .links {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            border: 1px solid #007acc;
            color: #007acc;
            text-decoration: none;
            font-size: 14px;
        }
        .btn.primary {
            background-color: #007acc;
            color: #fff;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .meta {
            margin-top: 24px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="logo">TinyMe</div>
        <div class="tagline">A tiny PHP framework based on FlightPHP and Medoo.</div>
        <div class="links">
            <a class="btn primary" href="/">Get started</a>
            <a class="btn" href="https://github.com/ycrao/tinyme">View on GitHub</a>
        </div>
        <div class="meta">
            PHP micro framework demo page
        </div>
    </div>
</body>
</html>
