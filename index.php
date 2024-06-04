<?php
include 'includes/header.php';
?>
<div class="container">
    <div class="create-post">
        <h2>Create Post</h2>
        <form action="create_post.php" method="post">
            <div class="form-group">
                <label for="tag">Tag</label>
                <input type="text" id="tag" name="tag" placeholder="Tag">
            </div>
            <div class="form-group">
                <label for="content">Enter Post text...</label>
                <textarea id="content" name="content" rows="4" placeholder="Enter Post text..."></textarea>
            </div>
            <button type="submit" class="btn-post">Post</button>
        </form>
    </div>
    <div class="post">
        <div class="post-header">
            <img class="post-avatar" src="/linkup/assets/images/profile.png" alt="Profile Picture">
            <h3 class="post-title">Exploring the Best Hiking Trails in Your Area</h3>
        </div>
        <div class="post-tag">Travel</div>
        <div class="post-content">
            <p>I recently discovered some amazing hiking trails near my home town and wanted to share my experiences with you all. Here are my top picks:</p>
            <ul>
                <li>Mount Sunshine Trail: A moderate 5-mile trail with breathtaking views of the valley. Best visited during the early morning for a stunning sunrise.</li>
                <li>Riverbend Path: An easy 3-mile walk along the river, perfect for beginners and families. Don’t forget to pack a picnic!</li>
            </ul>
        </div>
        <div class="post-actions">
            <button class="btn-star"><img src="/linkup/assets/images/star.png" alt="Star"></button>
            <button class="btn-comment"><img src="/linkup/assets/images/comment.png" alt="Comment"></button>
            <button class="btn-share"><img src="/linkup/assets/images/share.png" alt="Share"></button>
        </div>
    </div>
</div>