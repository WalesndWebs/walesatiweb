<?php
// admin/portfolio.php - Wales & Webs Portfolio CMS
require_once __DIR__ . '/auth.php';
check_auth();
require_once __DIR__ . '/../includes/db.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$message = '';
$error = '';

// Handle Delete
if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: portfolio.php?msg=deleted");
    exit;
}

// Handle Form Submission (Create or Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = trim($_POST['client_name'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? 'assets/images/case-caroline.jpg');
    $project_link = trim($_POST['project_link'] ?? '#');
    $featured = !empty($_POST['featured']) ? 1 : 0;
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if (empty($client_name) || empty($tags) || empty($description)) {
        $error = "Client Name, Tags, and Description are required.";
    } else {
        if ($id > 0) {
            // Update
            $stmt = $pdo->prepare("UPDATE portfolio SET client_name = ?, tags = ?, description = ?, image_url = ?, project_link = ?, featured = ?, sort_order = ? WHERE id = ?");
            $stmt->execute([$client_name, $tags, $description, $image_url, $project_link, $featured, $sort_order, $id]);
            header("Location: portfolio.php?msg=updated");
            exit;
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO portfolio (client_name, tags, description, image_url, project_link, featured, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$client_name, $tags, $description, $image_url, $project_link, $featured, $sort_order]);
            header("Location: portfolio.php?msg=created");
            exit;
        }
    }
}

// If editing, load project
$editItem = null;
if ($action === 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE id = ?");
    $stmt->execute([$id]);
    $editItem = $stmt->fetch();
    if (!$editItem) {
        $error = "Project not found.";
        $action = 'list';
    }
}

if (!empty($_GET['msg'])) {
    if ($_GET['msg'] === 'created') $message = "Portfolio project created successfully!";
    if ($_GET['msg'] === 'updated') $message = "Portfolio project updated successfully!";
    if ($_GET['msg'] === 'deleted') $message = "Portfolio project deleted successfully!";
}

// Fetch all projects for listing
$projects = $pdo->query("SELECT * FROM portfolio ORDER BY sort_order ASC, id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Portfolio — Wales & Webs CMS</title>
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
    .btn-green { background: var(--accent-green); color: #050508; }
    .btn-green:hover { box-shadow: 0 0 20px rgba(0, 255, 102, 0.4); }
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
    /* Form Styles */
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
    .form-input, .form-textarea, .form-select {
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
      border-color: var(--accent-green);
      box-shadow: 0 0 15px rgba(0, 255, 102, 0.2);
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
      <a href="portfolio.php" class="nav-link active">💼 Portfolio Projects</a>
      <a href="blog.php" class="nav-link">✍️ Blog Posts</a>
      <a href="../index.php" target="_blank" class="nav-link">🌐 View Live Website &nearr;</a>
    </nav>
    <div style="padding: 16px; border-top: 1px solid var(--border);">
      <a href="logout.php" style="color: #f87171; text-decoration: none; font-size: 13px; font-weight: 600;">Log Out</a>
    </div>
  </aside>

  <main class="admin-main">
    <div class="admin-header">
      <div>
        <h1 class="admin-title">Portfolio Projects</h1>
        <p style="font-size: 14px; color: var(--text-muted); margin-top: 4px;">
          Manage case studies displayed on the homepage and portfolio page.
        </p>
      </div>
      <div>
        <?php if ($action === 'list'): ?>
          <a href="portfolio.php?action=create" class="btn btn-green">+ Add New Project</a>
        <?php else: ?>
          <a href="portfolio.php" class="btn btn-outline">&larr; Back to List</a>
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
      <!-- Create / Edit Form -->
      <div class="card">
        <h2 style="font-size: 18px; margin-bottom: 20px;">
          <?= $action === 'edit' ? 'Edit Portfolio Project: ' . htmlspecialchars($editItem['client_name']) : 'Create New Portfolio Project' ?>
        </h2>
        <form method="POST" action="portfolio.php<?= $action === 'edit' ? '?action=edit&id='.$id : '' ?>">
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label" for="client_name">Client / Project Name *</label>
              <input type="text" id="client_name" name="client_name" class="form-input" required placeholder="e.g. Caroline's Place" value="<?= htmlspecialchars($editItem['client_name'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label class="form-label" for="tags">Tags / Deliverables (separated by · or comma) *</label>
              <input type="text" id="tags" name="tags" class="form-input" required placeholder="e.g. Website · Booking System · POS" value="<?= htmlspecialchars($editItem['tags'] ?? '') ?>">
            </div>

            <div class="form-group full">
              <label class="form-label" for="description">Project Description *</label>
              <textarea id="description" name="description" class="form-textarea" rows="3" required placeholder="A brief overview of the results, website, or system built..."><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
              <label class="form-label" for="image_url">Image Path / Asset URL</label>
              <input type="text" id="image_url" name="image_url" class="form-input" placeholder="assets/images/case-caroline.jpg" value="<?= htmlspecialchars($editItem['image_url'] ?? 'assets/images/case-caroline.jpg') ?>">
              <small style="color: var(--text-muted); font-size: 11.5px; display: block; margin-top: 4px;">
                Presets: <code>assets/images/case-caroline.jpg</code>, <code>assets/images/case-prodigy.jpg</code>, <code>assets/images/case-taste.jpg</code>, <code>assets/images/case-print.jpg</code>
              </small>
            </div>

            <div class="form-group">
              <label class="form-label" for="project_link">Case Study Link / Live URL</label>
              <input type="text" id="project_link" name="project_link" class="form-input" placeholder="#" value="<?= htmlspecialchars($editItem['project_link'] ?? '#') ?>">
            </div>

            <div class="form-group">
              <label class="form-label" for="sort_order">Display Order (Lower numbers appear first)</label>
              <input type="number" id="sort_order" name="sort_order" class="form-input" value="<?= (int)($editItem['sort_order'] ?? 0) ?>">
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 10px; padding-top: 28px;">
              <input type="checkbox" id="featured" name="featured" value="1" <?= (!isset($editItem['featured']) || $editItem['featured'] == 1) ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: var(--accent-green);">
              <label for="featured" style="font-size: 13.5px; font-weight: 600; cursor: pointer;">Feature on Homepage Carousel / Grid</label>
            </div>
          </div>

          <div style="margin-top: 24px; display: flex; gap: 12px;">
            <button type="submit" class="btn btn-green">
              <?= $action === 'edit' ? 'Save Changes' : 'Publish Project' ?> &rarr;
            </button>
            <a href="portfolio.php" class="btn btn-outline">Cancel</a>
          </div>
        </form>
      </div>

    <?php else: ?>
      <!-- Project List Table -->
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Thumbnail</th>
              <th>Client Name</th>
              <th>Tags</th>
              <th>Description</th>
              <th>Featured</th>
              <th>Order</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($projects)): ?>
              <tr><td colspan="7" style="text-align: center; padding: 28px; color: var(--text-muted);">No projects yet. Click "+ Add New Project" above.</td></tr>
            <?php else: ?>
              <?php foreach ($projects as $p): ?>
                <tr>
                  <td>
                    <img src="../<?= htmlspecialchars($p['image_url']) ?>" alt="thumb" class="thumbnail" onerror="this.src='../assets/images/case-caroline.jpg'">
                  </td>
                  <td><strong style="color: #ffffff;"><?= htmlspecialchars($p['client_name']) ?></strong></td>
                  <td><span style="background: rgba(139, 92, 246, 0.15); color: #c4b5fd; padding: 3px 8px; border-radius: 4px; font-size: 11px;"><?= htmlspecialchars($p['tags']) ?></span></td>
                  <td style="max-width: 280px; font-size: 12.5px; color: var(--text-muted);"><?= htmlspecialchars(mb_strimwidth($p['description'], 0, 80, '...')) ?></td>
                  <td><?= $p['featured'] ? '<span style="color: var(--accent-green); font-weight: bold;">Yes</span>' : '<span style="color: var(--text-muted);">No</span>' ?></td>
                  <td><?= (int)$p['sort_order'] ?></td>
                  <td>
                    <a href="portfolio.php?action=edit&id=<?= $p['id'] ?>" class="action-btn">Edit</a>
                    <a href="portfolio.php?action=delete&id=<?= $p['id'] ?>" class="action-btn del" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
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
