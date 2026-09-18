<?php
// admin/blog.php - Wales & Webs Blog CMS
require_once __DIR__ . '/auth.php';
check_auth();
require_once __DIR__ . '/../includes/db.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$message = '';
$error = '';

// Helper to create a clean slug
function make_slug($string) {
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

// Handle Delete
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: blog.php?msg=deleted");
    exit;
}

// Handle Form Submission (Create or Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image_url = trim($_POST['image_url'] ?? 'assets/images/case-prodigy.jpg');
    $author = trim($_POST['author'] ?? 'Wales & Webs Team');
    $published_date = trim($_POST['published_date'] ?? date('Y-m-d'));

    if (empty($slug)) {
        $slug = make_slug($title);
    } else {
        $slug = make_slug($slug);
    }

    if (empty($title) || empty($content)) {
        $error = "Title and Content are required.";
    } else {
        if ($id > 0) {
            // Update
            $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, excerpt = ?, content = ?, image_url = ?, author = ?, published_date = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $excerpt, $content, $image_url, $author, $published_date, $id]);
            header("Location: blog.php?msg=updated");
            exit;
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, excerpt, content, image_url, author, published_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $excerpt, $content, $image_url, $author, $published_date]);
            header("Location: blog.php?msg=created");
            exit;
        }
    }
}

// If editing, load post
$editPost = null;
if ($action === 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    $editPost = $stmt->fetch();
    if (!$editPost) {
        $error = "Post not found.";
        $action = 'list';
    }
}

if (!empty($_GET['msg'])) {
    if ($_GET['msg'] === 'created') $message = "Blog post published successfully!";
    if ($_GET['msg'] === 'updated') $message = "Blog post updated successfully!";
    if ($_GET['msg'] === 'deleted') $message = "Blog post deleted successfully!";
}

// Fetch all posts for listing
$posts = $pdo->query("SELECT * FROM blog_posts ORDER BY published_date DESC, id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Blog Posts — Wales & Webs CMS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #050508;
      --card-bg: rgba(14, 18, 30, 0.95);
      --border: rgba(255, 255, 255, 0.08);
      --accent-green: #00FF66;
      --accent-purple: #8b5cf6;
      --text: #f8fafc;
      --text-muted: #94a3b8;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
    }
    .admin-sidebar {
      width: 260px;
      background: #090c15;
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
    }
    .admin-brand {
      padding: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid var(--border);
    }
    .brand-icon {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      background: linear-gradient(135deg, var(--accent-purple), var(--accent-green));
      color: #050508;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }
    .brand-text h2 { font-size: 16px; font-weight: 700; }
    .brand-text span { font-size: 11px; color: var(--text-muted); }
    .admin-nav {
      padding: 20px 16px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      flex: 1;
    }
    .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 14px;
      color: var(--text-muted);
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.2s;
    }
    .nav-link:hover, .nav-link.active {
      background: rgba(139, 92, 246, 0.15);
      color: #ffffff;
      border: 1px solid rgba(139, 92, 246, 0.3);
    }
    .nav-link.active {
      border-color: var(--accent-green);
      color: var(--accent-green);
    }
    .admin-main {
      flex: 1;
      overflow-y: auto;
      padding: 32px 40px;
    }
    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 28px;
    }
    .admin-title { font-size: 26px; font-weight: 800; }
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      border-radius: 9999px;
      font-size: 13.5px;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: all 0.2s;
    }
    .btn-purple { background: var(--accent-purple); color: #ffffff; }
    .btn-purple:hover { box-shadow: 0 0 20px rgba(139, 92, 246, 0.4); }
    .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
    .alert-success {
      background: rgba(0, 255, 102, 0.15);
      border: 1px solid rgba(0, 255, 102, 0.3);
      color: var(--accent-green);
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 24px;
    }
    .alert-error {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #f87171;
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 24px;
    }
    .card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 28px;
      margin-bottom: 32px;
    }
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .form-group { margin-bottom: 18px; }
    .form-group.full { grid-column: span 2; }
    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 8px;
    }
    .form-input, .form-textarea {
      width: 100%;
      background: rgba(5, 7, 13, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 10px;
      padding: 12px 14px;
      color: #ffffff;
      font-size: 14px;
      font-family: inherit;
    }
    .form-input:focus, .form-textarea:focus {
      outline: none;
      border-color: var(--accent-purple);
      box-shadow: 0 0 15px rgba(139, 92, 246, 0.25);
    }
    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    th { text-align: left; padding: 12px 16px; color: var(--text-muted); border-bottom: 1px solid var(--border); }
    td { padding: 14px 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.04); color: #cbd5e1; }
    tr:hover td { background: rgba(255, 255, 255, 0.02); }
    .thumbnail { width: 48px; height: 34px; border-radius: 6px; object-fit: cover; }
    .action-btn { color: var(--accent-green); text-decoration: none; font-weight: 600; margin-right: 12px; font-size: 13px; }
    .action-btn.del { color: #f87171; }
  </style>
</head>
<body>

  <aside class="admin-sidebar">
    <div class="admin-brand">
      <div class="brand-icon">W</div>
      <div class="brand-text">
        <h2>Wales & Webs</h2>
        <span>CMS Dashboard</span>
      </div>
    </div>
    <nav class="admin-nav">
      <a href="index.php" class="nav-link">📊 Overview</a>
      <a href="portfolio.php" class="nav-link">💼 Portfolio Projects</a>
      <a href="blog.php" class="nav-link active">✍️ Blog Posts</a>
      <a href="../index.php" target="_blank" class="nav-link">🌐 View Live Website &nearr;</a>
    </nav>
    <div style="padding: 16px; border-top: 1px solid var(--border);">
      <a href="logout.php" style="color: #f87171; text-decoration: none; font-size: 13px; font-weight: 600;">Log Out</a>
    </div>
  </aside>

  <main class="admin-main">
    <div class="admin-header">
      <div>
        <h1 class="admin-title">Blog Posts & Insights</h1>
        <p style="font-size: 14px; color: var(--text-muted); margin-top: 4px;">
          Create and manage articles, business insights, and guides.
        </p>
      </div>
      <div>
        <?php if ($action === 'list'): ?>
          <a href="blog.php?action=create" class="btn btn-purple">+ Write New Post</a>
        <?php else: ?>
          <a href="blog.php" class="btn btn-outline">&larr; Back to Posts</a>
        <?php endif; ?>
      </div>
    </div>

    <?php if (!empty($message)): ?>
      <div class="alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($action === 'create' || $action === 'edit'): ?>
      <div class="card">
        <h2 style="font-size: 18px; margin-bottom: 20px;">
          <?= $action === 'edit' ? 'Edit Article: ' . htmlspecialchars($editPost['title']) : 'Write New Article' ?>
        </h2>
        <form method="POST" action="blog.php<?= $action === 'edit' ? '?action=edit&id='.$id : '' ?>">
          <div class="form-grid">
            <div class="form-group full">
              <label class="form-label" for="title">Article Title *</label>
              <input type="text" id="title" name="title" class="form-input" required placeholder="e.g. Why Your Business Needs Automated Systems in 2026" value="<?= htmlspecialchars($editPost['title'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label class="form-label" for="slug">URL Slug (leave blank to auto-generate)</label>
              <input type="text" id="slug" name="slug" class="form-input" placeholder="why-your-business-needs-automated-systems" value="<?= htmlspecialchars($editPost['slug'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label class="form-label" for="author">Author Name</label>
              <input type="text" id="author" name="author" class="form-input" value="<?= htmlspecialchars($editPost['author'] ?? 'Wales & Webs Team') ?>">
            </div>

            <div class="form-group">
              <label class="form-label" for="published_date">Published Date</label>
              <input type="date" id="published_date" name="published_date" class="form-input" value="<?= htmlspecialchars($editPost['published_date'] ?? date('Y-m-d')) ?>">
            </div>

            <div class="form-group">
              <label class="form-label" for="image_url">Featured Image URL / Asset</label>
              <input type="text" id="image_url" name="image_url" class="form-input" value="<?= htmlspecialchars($editPost['image_url'] ?? 'assets/images/case-prodigy.jpg') ?>">
            </div>

            <div class="form-group full">
              <label class="form-label" for="excerpt">Short Excerpt / Summary</label>
              <textarea id="excerpt" name="excerpt" class="form-textarea" rows="2" placeholder="Brief 1-2 sentence preview for cards and search engines..."><?= htmlspecialchars($editPost['excerpt'] ?? '') ?></textarea>
            </div>

            <div class="form-group full">
              <label class="form-label" for="content">Full Article Content (HTML allowed) *</label>
              <textarea id="content" name="content" class="form-textarea" rows="10" required placeholder="<p>Write your detailed article paragraphs here...</p>"><?= htmlspecialchars($editPost['content'] ?? '') ?></textarea>
            </div>
          </div>

          <div style="margin-top: 24px; display: flex; gap: 12px;">
            <button type="submit" class="btn btn-purple">
              <?= $action === 'edit' ? 'Save Changes' : 'Publish Article' ?> &rarr;
            </button>
            <a href="blog.php" class="btn btn-outline">Cancel</a>
          </div>
        </form>
      </div>

    <?php else: ?>
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Thumbnail</th>
              <th>Article Title</th>
              <th>Author</th>
              <th>Date</th>
              <th>Slug</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($posts)): ?>
              <tr><td colspan="6" style="text-align: center; padding: 28px; color: var(--text-muted);">No blog posts yet. Click "+ Write New Post" above.</td></tr>
            <?php else: ?>
              <?php foreach ($posts as $p): ?>
                <tr>
                  <td>
                    <img src="../<?= htmlspecialchars($p['image_url']) ?>" alt="thumb" class="thumbnail" onerror="this.src='../assets/images/case-prodigy.jpg'">
                  </td>
                  <td><strong style="color: #ffffff;"><?= htmlspecialchars($p['title']) ?></strong></td>
                  <td><?= htmlspecialchars($p['author']) ?></td>
                  <td><?= htmlspecialchars($p['published_date']) ?></td>
                  <td style="font-family: monospace; font-size: 11px; color: #94a3b8;"><?= htmlspecialchars($p['slug']) ?></td>
                  <td>
                    <a href="blog.php?action=edit&id=<?= $p['id'] ?>" class="action-btn">Edit</a>
                    <a href="../blog-single.php?slug=<?= urlencode($p['slug']) ?>" target="_blank" class="action-btn" style="color: #38bdf8;">View</a>
                    <a href="blog.php?action=delete&id=<?= $p['id'] ?>" class="action-btn del" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>

</body>
</html>
