<?php
// blog.php - Wales & Webs Dynamic Blog & Insights Page
require_once __DIR__ . '/includes/db.php';

// Fetch all posts ordered by date descending
$stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY published_date DESC, id DESC");
$posts = $stmt->fetchAll();

require_once __DIR__ . '/partials/header.php';
?>

<!-- Blog Header -->
<section style="padding: 120px 0 60px; background: radial-gradient(circle at 50% 10%, rgba(0, 255, 102, 0.1) 0%, transparent 60%); text-align: center;">
  <div class="container">
    <div class="section-eyebrow">RESOURCES & INSIGHTS</div>
    <h1 style="font-size: clamp(32px, 5vw, 54px); font-weight: 800; letter-spacing: -1px; margin-bottom: 16px;">
      Digital systems, automation <br>&amp; <span class="highlight-purple">growth strategies.</span>
    </h1>
    <p style="max-width: 600px; margin: 0 auto 24px; color: var(--text-secondary); font-size: 16px; line-height: 1.6;">
      Practical guides, technology breakdowns, and actionable tips to help modern businesses scale efficiently.
    </p>
  </div>
</section>

<!-- Blog Grid Section -->
<section style="padding: 20px 0 100px;">
  <div class="container">
    <?php if (empty($posts)): ?>
      <div style="text-align: center; padding: 60px; color: var(--text-secondary);">
        <p>No articles published yet. Visit <a href="admin/login.php" style="color: var(--accent-green);">Admin CMS</a> to create your first post.</p>
      </div>
    <?php else: ?>
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px;">
        <?php foreach ($posts as $p): ?>
          <article style="background: rgba(14, 18, 30, 0.85); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;" onmouseover="this.style.borderColor='rgba(139,92,246,0.4)'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.5)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <a href="blog-single.php?slug=<?= urlencode($p['slug']) ?>" style="display: block; height: 200px; overflow: hidden; position: relative;">
              <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';" onerror="this.src='assets/images/case-prodigy.jpg'">
            </a>
            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 12px; color: var(--text-muted);">
                <span><?= htmlspecialchars($p['author']) ?></span>
                <span><?= date('M d, Y', strtotime($p['published_date'])) ?></span>
              </div>
              <h2 style="font-size: 18px; font-weight: 700; color: #ffffff; line-height: 1.4; margin-bottom: 12px;">
                <a href="blog-single.php?slug=<?= urlencode($p['slug']) ?>" style="color: #ffffff; text-decoration: none;">
                  <?= htmlspecialchars($p['title']) ?>
                </a>
              </h2>
              <p style="font-size: 13.5px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 20px; flex: 1;">
                <?= htmlspecialchars($p['excerpt'] ?: mb_strimwidth(strip_tags($p['content']), 0, 110, '...')) ?>
              </p>
              <div>
                <a href="blog-single.php?slug=<?= urlencode($p['slug']) ?>" style="color: var(--accent-green); text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                  Read Article &rarr;
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
