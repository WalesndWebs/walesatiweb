<?php
// admin/index.php - Wales & Webs Admin Overview
require_once __DIR__ . '/auth.php';
check_auth();
require_once __DIR__ . '/../includes/db.php';

// Fetch summary metrics
$totalProjects = $pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn();
$totalBlogs = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();

// Fetch latest projects
$recentProjects = $pdo->query("SELECT * FROM portfolio ORDER BY id DESC LIMIT 5")->fetchAll();

// Fetch latest blog posts
$recentBlogs = $pdo->query("SELECT * FROM blog_posts ORDER BY id DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — Wales & Webs</title>
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
    /* Sidebar */
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
    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid var(--border);
    }
    .btn-logout {
      display: block;
      width: 100%;
      text-align: center;
      padding: 10px;
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #f87171;
      border-radius: 8px;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      transition: all 0.2s;
    }
    .btn-logout:hover {
      background: #ef4444;
      color: #ffffff;
    }
    /* Main Content */
    .admin-main {
      flex: 1;
      overflow-y: auto;
      padding: 32px 40px;
    }
    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
    }
    .admin-title { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
    .admin-subtitle { font-size: 14px; color: var(--text-muted); margin-top: 4px; }
    .header-actions {
      display: flex;
      gap: 12px;
    }
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
      transition: all 0.2s;
      border: none;
    }
    .btn-green {
      background: var(--accent-green);
      color: #050508;
    }
    .btn-green:hover {
      box-shadow: 0 0 20px rgba(0, 255, 102, 0.4);
      transform: translateY(-1px);
    }
    .btn-purple {
      background: var(--accent-purple);
      color: #ffffff;
    }
    .btn-outline {
      background: transparent;
      border: 1px solid var(--border);
      color: var(--text);
    }
    .btn-outline:hover {
      border-color: rgba(255, 255, 255, 0.3);
      background: rgba(255, 255, 255, 0.05);
    }
    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-bottom: 36px;
    }
    .stat-card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px;
      position: relative;
      overflow: hidden;
    }
    .stat-card::after {
      content: '';
      position: absolute;
      top: 0; right: 0; width: 80px; height: 80px;
      background: radial-gradient(circle, rgba(0, 255, 102, 0.15) 0%, transparent 70%);
      pointer-events: none;
    }
    .stat-label { font-size: 13px; color: var(--text-muted); font-weight: 600; }
    .stat-value { font-size: 32px; font-weight: 800; color: #ffffff; margin-top: 8px; }
    .stat-badge {
      display: inline-block;
      margin-top: 10px;
      font-size: 11.5px;
      padding: 3px 8px;
      border-radius: 6px;
      background: rgba(0, 255, 102, 0.1);
      color: var(--accent-green);
      border: 1px solid rgba(0, 255, 102, 0.25);
    }
    /* Tables */
    .content-section {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 28px;
      margin-bottom: 32px;
    }
    .section-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .section-head h3 { font-size: 18px; font-weight: 700; }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }
    th {
      text-align: left;
      padding: 12px 16px;
      color: var(--text-muted);
      font-weight: 600;
      border-bottom: 1px solid var(--border);
    }
    td {
      padding: 14px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
      color: #cbd5e1;
    }
    tr:hover td {
      background: rgba(255, 255, 255, 0.02);
    }
    .badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 11px;
      font-weight: 600;
      background: rgba(139, 92, 246, 0.15);
      color: #c4b5fd;
      border: 1px solid rgba(139, 92, 246, 0.3);
    }
    .action-links a {
      color: var(--accent-green);
      text-decoration: none;
      font-weight: 600;
      margin-right: 12px;
      font-size: 12.5px;
    }
    .action-links a:hover { text-decoration: underline; }
    .thumbnail {
      width: 44px;
      height: 32px;
      border-radius: 6px;
      object-fit: cover;
      vertical-align: middle;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="admin-sidebar">
    <div class="admin-brand">
      <div class="brand-icon">W</div>
      <div class="brand-text">
        <h2>Wales & Webs</h2>
        <span>CMS Dashboard</span>
      </div>
    </div>

    <nav class="admin-nav">
      <a href="index.php" class="nav-link active">📊 Overview</a>
      <a href="portfolio.php" class="nav-link">💼 Portfolio Projects</a>
      <a href="blog.php" class="nav-link">✍️ Blog Posts</a>
      <a href="../index.php" target="_blank" class="nav-link">🌐 View Live Website &nearr;</a>
    </nav>

    <div class="sidebar-footer">
      <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">
        Logged in as: <strong style="color: #ffffff;"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin') ?></strong>
      </div>
      <a href="logout.php" class="btn-logout">Log Out</a>
    </div>
  </aside>

  <!-- Main View -->
  <main class="admin-main">
    <header class="admin-header">
      <div>
        <h1 class="admin-title">Dashboard Overview</h1>
        <p class="admin-subtitle">Welcome back! Manage your dynamic portfolio case studies and blog insights.</p>
      </div>
      <div class="header-actions">
        <a href="portfolio.php?action=create" class="btn btn-green">+ New Project</a>
        <a href="blog.php?action=create" class="btn btn-purple">+ Write Post</a>
        <a href="../index.php" target="_blank" class="btn btn-outline">Live Site &rarr;</a>
      </div>
    </header>

    <!-- Stats -->
    <section class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Total Portfolio Projects</div>
        <div class="stat-value"><?= (int)$totalProjects ?></div>
        <span class="stat-badge">Dynamic Frontend Sync</span>
      </div>
      <div class="stat-card">
        <div class="stat-label">Published Blog Posts</div>
        <div class="stat-value"><?= (int)$totalBlogs ?></div>
        <span class="stat-badge">SEO & Resources</span>
      </div>
      <div class="stat-card">
        <div class="stat-label">Database Engine</div>
        <div class="stat-value" style="font-size: 20px; margin-top: 14px; color: var(--accent-green);">
          <?= htmlspecialchars(strtoupper($pdo->getAttribute(PDO::ATTR_DRIVER_NAME))) ?>
        </div>
        <span class="stat-badge">PDO MySQL / SQLite Unified</span>
      </div>
    </section>

    <!-- Recent Portfolio Projects -->
    <section class="content-section">
      <div class="section-head">
        <h3>Recent Portfolio Projects</h3>
        <a href="portfolio.php" style="color: var(--accent-green); text-decoration: none; font-size: 13px; font-weight: 600;">View All &rarr;</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Thumbnail</th>
            <th>Client Name</th>
            <th>Services / Tags</th>
            <th>Featured</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentProjects)): ?>
            <tr><td colspan="5" style="text-align: center; padding: 24px; color: var(--text-muted);">No projects found. Create your first project above!</td></tr>
          <?php else: ?>
            <?php foreach ($recentProjects as $p): ?>
              <tr>
                <td>
                  <img src="../<?= htmlspecialchars($p['image_url']) ?>" alt="thumb" class="thumbnail" onerror="this.src='../assets/images/case-caroline.jpg'">
                </td>
                <td><strong style="color: #ffffff;"><?= htmlspecialchars($p['client_name']) ?></strong></td>
                <td><span class="badge"><?= htmlspecialchars($p['tags']) ?></span></td>
                <td>
                  <?= $p['featured'] ? '<span style="color: var(--accent-green);">★ Featured</span>' : '<span style="color: var(--text-muted);">Standard</span>' ?>
                </td>
                <td class="action-links">
                  <a href="portfolio.php?action=edit&id=<?= $p['id'] ?>">Edit</a>
                  <a href="portfolio.php?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?');" style="color: #f87171;">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </section>

    <!-- Recent Blog Posts -->
    <section class="content-section">
      <div class="section-head">
        <h3>Recent Blog Posts & Insights</h3>
        <a href="blog.php" style="color: var(--accent-green); text-decoration: none; font-size: 13px; font-weight: 600;">View All &rarr;</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Published Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentBlogs)): ?>
            <tr><td colspan="4" style="text-align: center; padding: 24px; color: var(--text-muted);">No blog posts found. Write your first post!</td></tr>
          <?php else: ?>
            <?php foreach ($recentBlogs as $b): ?>
              <tr>
                <td><strong style="color: #ffffff;"><?= htmlspecialchars($b['title']) ?></strong></td>
                <td><?= htmlspecialchars($b['author']) ?></td>
                <td><?= htmlspecialchars($b['published_date']) ?></td>
                <td class="action-links">
                  <a href="blog.php?action=edit&id=<?= $b['id'] ?>">Edit</a>
                  <a href="../blog-single.php?slug=<?= urlencode($b['slug']) ?>" target="_blank" style="color: #38bdf8;">View</a>
                  <a href="blog.php?action=delete&id=<?= $b['id'] ?>" onclick="return confirm('Are you sure you want to delete this post?');" style="color: #f87171;">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>

</body>
</html>
