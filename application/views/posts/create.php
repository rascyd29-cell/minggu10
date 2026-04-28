<?php $this->load->view('posts/header'); ?>

<h2>Create New Post</h2>
<a href="<?php echo base_url('posts'); ?>">← Back</a>
<br><br>

<?php echo form_open_multipart('posts/store'); ?>

    <p>
        <label>Title *</label><br>
        <input type="text" name="title" value="<?php echo set_value('title'); ?>">
    </p>

    <p>
        <label>Author *</label><br>
        <input type="text" name="author" value="<?php echo set_value('author'); ?>">
    </p>

    <p>
        <label>Article *</label><br>
        <textarea name="article" rows="6" cols="50"><?php echo set_value('article'); ?></textarea>
    </p>

    <p>
        <label>Image</label><br>
        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg">
        <br><small>JPG, PNG. Maks 2MB</small>
    </p>

    <p>
        <button type="submit">Simpan</button>
        <a href="<?php echo base_url('posts'); ?>">Cancel</a>
    </p>

<?php echo form_close(); ?>

<?php $this->load->view('posts/footer'); ?>