

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<?php $this->load->view('posts/header'); ?>

<a href="<?php echo base_url('posts'); ?>">← Back</a>
<br><br>

<h2><?php echo htmlspecialchars($post->title); ?></h2>
<p>Author: <?php echo htmlspecialchars($post->author); ?></p>

<?php if (isset($post->created_at)): ?>
    <p>Created: <?php echo date('d M Y, H:i', strtotime($post->created_at)); ?></p>
<?php endif; ?>

<?php if ($post->image_url): ?>
    <br>
    <img src="<?php echo $post->image_url; ?>" width="400" alt="img">
<?php endif; ?>

<br><br>
<p><?php echo nl2br(htmlspecialchars($post->article)); ?></p>

<br>
<a href="<?php echo base_url('posts/edit/' . $post->id); ?>">Edit</a> |
<a href="<?php echo base_url('posts/delete/' . $post->id); ?>"
   onclick="return confirm('Yakin hapus?')">Delete</a>

<?php $this->load->view('posts/footer'); ?></div>
  
</body>
</html>