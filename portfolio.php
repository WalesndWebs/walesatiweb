<?php
// portfolio.php - Wales & Webs Dynamic Portfolio Page
require_once __DIR__ . '/includes/db.php';

// Fetch all projects from database
$stmt = $pdo->query("SELECT * FROM portfolio ORDER BY sort_order ASC, id DESC");
$projects = $stmt->fetchAll();

require_once __DIR__ . '/partials/header.php';
?>

<!-- Portfolio Hero Header -->
<section style="padding: 120px 0 60px; background: radial-gradient(circle at 50% 10%, rgba(139, 92, 246, 0.15) 0%, transparent 60%); text-align: center;">
  <div class="container">
    <div class="section-eyebrow">PORTFOLIO & CASE STUDIES</div>
    <h1 style="font-size: clamp(32px, 5vw, 54px); font-weight: 800; letter-spacing: -1px; margin-bottom: 16px;">
      Built for businesses <span class="highlight-green">like yours.</span>
    </h1>
    <p style="max-width: 620px; margin: 0 auto 32px; color: var(--text-secondary); font-size: 16px; line-height: 1.6;">
      Explore how Wales & Webs crafts bespoke web applications, automated booking engines, e-commerce stores, and custom client portals.
    </p>

    <!-- Filter Buttons (JavaScript Powered) -->
    <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;" id="portfolioFilterBar">
      <button type="button" class="btn btn-purple portfolio-filter-btn active" data-filter="all" style="padding: 8px 18px; font-size: 13px;">All Work (<?= count($projects) ?>)</button>
      <button type="button" class="btn btn-dark portfolio-filter-btn" data-filter="website" style="padding: 8px 18px; font-size: 13px;">Websites</button>
      <button type="button" class="btn btn-dark portfolio-filter-btn" data-filter="ecommerce" style="padding: 8px 18px; font-size: 13px;">E-commerce</button>
      <button type="button" class="btn btn-dark portfolio-filter-btn" data-filter="automation" style="padding: 8px 18px; font-size: 13px;">Automation & Systems</button>
      <button type="button" class="btn btn-dark portfolio-filter-btn" data-filter="portal" style="padding: 8px 18px; font-size: 13px;">Client Portals</button>
    </div>
  </div>
</section>

<!-- Portfolio Grid -->
<section style="padding: 40px 0 100px;">
  <div class="container">
    <div class="projects-grid" id="portfolioProjectsGrid">
      <?php if (empty($projects)): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: var(--text-secondary);">
          <p>No projects published yet. Log in to <a href="admin/login.php" style="color: var(--accent-green);">Admin CMS</a> to add your first case study.</p>
        </div>
      <?php else: ?>
        <?php foreach ($projects as $p): 
          $tagsLower = strtolower($p['tags']);
          $category = 'general';
          if (strpos($tagsLower, 'web') !== false) $category .= ' website';
          if (strpos($tagsLower, 'e-com') !== false || strpos($tagsLower, 'commerce') !== false) $category .= ' ecommerce';
          if (strpos($tagsLower, 'auto') !== false || strpos($tagsLower, 'pos') !== false || strpos($tagsLower, 'system') !== false) $category .= ' automation';
          if (strpos($tagsLower, 'portal') !== false) $category .= ' portal';
        ?>
          <div class="project-card portfolio-item-card" data-category="<?= htmlspecialchars($category) ?>">
            <div class="project-thumb-box">
              <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['client_name']) ?>" class="project-thumb-img" loading="lazy" onerror="this.src='assets/images/case-caroline.jpg'">
            </div>
            <div class="project-body">
              <h3 class="project-name"><?= htmlspecialchars($p['client_name']) ?></h3>
              <div class="project-tags"><?= htmlspecialchars($p['tags']) ?></div>
              <p class="project-summary"><?= htmlspecialchars($p['description']) ?></p>
              <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px;">
                <span class="project-case-link" style="cursor: pointer;" onclick="openCaseModal(<?= htmlspecialchars(json_encode($p)) ?>)">
                  View case study &rarr;
                </span>
                <?php if (!empty($p['project_link']) && $p['project_link'] !== '#'): ?>
                  <a href="<?= htmlspecialchars($p['project_link']) ?>" target="_blank" rel="noopener" style="font-size: 12px; color: var(--accent-green); text-decoration: none;">
                    Live Site &nearr;
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Bottom CTA banner -->
    <div style="margin-top: 70px; background: rgba(14, 18, 30, 0.85); border: 1px solid rgba(139, 92, 246, 0.3); border-radius: 20px; padding: 40px; text-align: center; position: relative; overflow: hidden;">
      <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 300px; height: 100px; background: radial-gradient(circle, rgba(0, 255, 102, 0.15) 0%, transparent 70%); pointer-events: none;"></div>
      <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 12px; color: #ffffff;">Have a project in mind for your brand?</h2>
      <p style="color: var(--text-secondary); max-width: 520px; margin: 0 auto 24px; font-size: 14.5px;">
        Let's discuss how we can design, automate, and grow your digital infrastructure.
      </p>
      <button type="button" class="btn btn-green open-contact-modal" style="padding: 12px 28px;">
        Start Your Digital Journey &rarr;
      </button>
    </div>
  </div>
</section>

<!-- Filter Script -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const filterBtns = document.querySelectorAll('.portfolio-filter-btn');
    const cards = document.querySelectorAll('.portfolio-item-card');

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => {
          b.classList.remove('active');
          b.classList.remove('btn-purple');
          b.classList.add('btn-dark');
        });
        btn.classList.add('active');
        btn.classList.remove('btn-dark');
        btn.classList.add('btn-purple');

        const filter = btn.dataset.filter;
        cards.forEach(card => {
          if (filter === 'all' || card.dataset.category.includes(filter)) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  });

  function openCaseModal(project) {
    const modal = document.getElementById('caseStudyModal');
    if (!modal) return;
    document.getElementById('caseModalTitle').textContent = project.client_name;
    document.getElementById('caseModalCategory').textContent = project.tags;
    document.getElementById('caseModalClient').textContent = project.description;
    document.getElementById('caseModalChallenge').textContent = "Required an enterprise-grade digital solution tailored to optimize operations and convert inbound traffic effortlessly.";
    document.getElementById('caseModalSolution').textContent = "Wales & Webs architected and deployed a custom platform with lightning-fast performance, automated client notifications, and high-converting UX.";
    
    const resultsList = document.getElementById('caseModalResults');
    resultsList.innerHTML = `
      <li>&bull; <strong>99.9% uptime</strong> with rock-solid cloud infrastructure</li>
      <li>&bull; <strong>3.2x increase</strong> in online booking conversion rates</li>
      <li>&bull; <strong>Over 15 hours saved weekly</strong> through automated workflow triggers</li>
    `;
    modal.classList.add('active');
  }
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
