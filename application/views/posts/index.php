<?php $this->load->view('posts/header'); ?>

<h2>All Posts</h2>
<a href="<?php echo base_url('posts/create'); ?>">+ Create New Post</a>
<br><br>

<?php if (empty($posts)): ?>
    <p>bikin post baru. <a href="<?php echo base_url('posts/create'); ?>">Bikin post bRUUUUUU</a></p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Article</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($posts as $post): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td>
                    <?php if ($post->image_url): ?>
                        <img src="<?php echo $post->image_url; ?>" width="80" alt="img">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($post->title); ?></td>
                <td><?php echo htmlspecialchars($post->author); ?></td>
                <td><?php echo substr(htmlspecialchars($post->article), 0, 50); ?>...</td>
                <td><?php echo date('d M Y', strtotime($post->created_at)); ?></td>
                <td>
                    <a href="<?php echo base_url('posts/show/' . $post->id); ?>">View</a> |
                    <a href="<?php echo base_url('posts/edit/' . $post->id); ?>">Edit</a> |
                    <a href="<?php echo base_url('posts/delete/' . $post->id); ?>"
                       onclick="return confirm('Yakin hapus?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $this->load->view('posts/footer'); ?>