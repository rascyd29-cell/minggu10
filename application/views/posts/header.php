<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : 'Posts'; ?></title>
</head>
<body>
<nav>
    <a href="<?php echo base_url('home'); ?>">Home</a> |
    <a href="<?php echo base_url('posts'); ?>">All Posts</a> |
    <a href="<?php echo base_url('posts/create'); ?>">Create Post</a>
</nav>
<hr>

<?php if ($this->session->flashdata('success')): ?>
    <p style="color:green;"><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>