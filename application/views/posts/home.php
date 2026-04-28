<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .container {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Selamat datang di homePage kawandd</h1>
    <p>Ayok click tombol di bawah buat mulai buat postingan baru </p>
    <a href="<?php echo base_url('posts'); ?>">View All Posts</a>
</div>
</body>
</html>