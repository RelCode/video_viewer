<li class="nav-item <?= isset($_GET['page']) && $_GET['page'] == 'playlist' ? 'active' : ''; ?>">
    <a href="?page=playlist" class="nav-link">My Playlist</a>
</li>
<li class="nav-item <?= isset($_GET['subpage']) && $_GET['subpage'] == 'viewed' ? 'active' : ''; ?>">
    <a href="?page=preferences&subpage=viewed" class="nav-link">Viewed Videos</a>
</li>
<li class="nav-item <?= isset($_GET['subpage']) && $_GET['subpage'] == 'liked' ? 'active' : ''; ?>">
    <a href="?page=preferences&subpage=liked" class="nav-link">Liked Videos</a>
</li>
<li class="nav-item <?= isset($_GET['page']) && $_GET['page'] == 'studio' ? 'active' : ''; ?>">
    <a href="?page=studio" class="nav-link">My Studio</a>
</li>
<li class="nav-item">
    <a href="?page=logout" class="nav-link">Logout</a>
</li>