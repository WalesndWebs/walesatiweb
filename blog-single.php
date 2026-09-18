<?php
// blog-single.php - Wales & Webs Dynamic Single Article View
require_once __DIR__ . '/includes/db.php';

$slug = trim($_GET['slug'] ?? '');
if (empty($slug)) {
    header("Location: blog.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: blog.php");
    exit;
}

// Fetch 2 other posts for related reading
$stmtRelated = $pdo->prepare("SELECT * FROM blog_posts WHERE id != ? ORDER BY published_date DESC LIMIT 2");
$stmtRelated->execute([$post['id']]);
$relatedPosts = $stmtRelated->fetchAll();

require_once __DIR__ . '/partials/header.php';
?>

<article style="padding: 120px 0 80px;">
  <div class="container" style="max-width: 820px;">
    
    <div style="margin-bottom: 24px;">
      <a href="blog.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
        &larr; Back to all resources &amp; articles
      </a>
    </div>

    <div class="section-eyebrow">ARTICLE & INSIGHTS</div>
    
    <h1 style="font-size: clamp(28px, 4.5vw, 44px); font-weight: 800; line-height: 1.25; color: #ffffff; margin-bottom: 20px;">
      <?= htmlspecialchars($post['title']) ?>
    </h1>

    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 13.5px; color: var(--text-secondary);">
      <span>By <strong style="color: #ffffff;"><?= htmlspecialchars($post['author']) ?></strong></span>
      <span>&bull;</span>
      <span>Published <?= date('F j, Y', strtotime($post['published_date'])) ?></span>
      <span>&bull;</span>
      <span style="color: var(--accent-green);">4 min read</span>
    </div>

    <!-- Featured Image -->
    <div style="width: 100%; border-radius: 16px; overflow: hidden; margin-bottom: 36px; border: 1px solid rgba(255, 255, 255, 0.08);">
      <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 100%; max-height: 440px; object-fit: cover; display: block;" onerror="this.src='assets/images/case-prodigy.jpg'">
    </div>

    <!-- Article Content Body -->
    <div style="font-size: 16px; line-height: 1.8; color: #cbd5e1; margin-bottom: 48px;" class="article-content-body">
      <?= $post['content'] ?>
    </div>

    <!-- Share & Author Box -->
    <div style="background: rgba(14, 18, 30, 0.9); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 60px;">
      <div>
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Written by</div>
        <div style="font-size: 15px; font-weight: 700; color: #ffffff;"><?= htmlspecialchars($post['author']) ?></div>
        <div style="font-size: 12.5px; color: var(--text-secondary);">Specialists in Digital Infrastructure &amp; Business Systems</div>
      </div>
      <div style="display: flex; gap: 10px;">
        <button type="button" class="btn btn-dark" onclick="navigator.clipboard.writeText(window.location.href); alert('Article link copied to clipboard!');" style="font-size: 12.5px; padding: 8px 16px;">
          Copy Link
        </button>
        <button type="button" class="btn btn-purple open-contact-modal" style="font-size: 12.5px; padding: 8px 16px;">
          Work With Us &rarr;
        </button>
      </div>
    </div>

    <!-- Related Articles -->
    <?php if (!empty($relatedPosts)): ?>
      <div style="margin-top: 60px; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 40px;">
        <h3 style="font-size: 20px; font-weight: 700; color: #ffffff; margin-bottom: 24px;">Related Resources</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
          <?php foreach ($relatedPosts as $r): ?>
            <div style="background: rgba(14, 18, 30, 0.7); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 20px;">
              <div style="font-size: 11.5px; color: var(--accent-green); margin-bottom: 6px;"><?= date('M d, Y', strtotime($r['published_date'])) ?></div>
              <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 10px;">
                <a href="blog-single.php?slug=<?= urlencode($r['slug']) ?>" style="color: #ffffff; text-decoration: none;">
                  <?= htmlspecialchars($r['title']) ?>
                </a>
              </h4>
              <a href="blog-single.php?slug=<?= urlencode($r['slug']) ?>" style="color: var(--accent-purple); font-size: 12.5px; text-decoration: none; font-weight: 600;">Read More &rarr;</a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</article>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
