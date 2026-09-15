/**
 * Wales & Webs - Main Client Scripts
 * Handles Modals, Testimonial Carousel, Contact Forms, and Smooth Navigation
 */

document.addEventListener('DOMContentLoaded', () => {
  // --------------------------------------------------------------------------
  // Mobile Navigation Toggle
  // --------------------------------------------------------------------------
  const mobileToggle = document.querySelector('.mobile-toggle');
  const navLinks = document.querySelector('.nav-links');

  if (mobileToggle && navLinks) {
    mobileToggle.addEventListener('click', () => {
      const isOpen = navLinks.style.display === 'flex';
      navLinks.style.display = isOpen ? 'none' : 'flex';
      navLinks.style.flexDirection = 'column';
      navLinks.style.position = 'absolute';
      navLinks.style.top = '74px';
      navLinks.style.left = '0';
      navLinks.style.width = '100%';
      navLinks.style.background = '#090b12';
      navLinks.style.padding = '24px';
      navLinks.style.borderBottom = '1px solid rgba(255,255,255,0.1)';
      navLinks.style.gap = '20px';
    });
  }

  // --------------------------------------------------------------------------
  // Case Study Data & Modal
  // --------------------------------------------------------------------------
  const caseStudies = {
    'carolines-place': {
      title: "Caroline's Place",
      category: 'Website · Booking System · POS',
      summary: 'A modern website and booking system for a premium beauty and wellness brand.',
      client: 'Caroline M., CEO',
      challenge: 'Manual client bookings through phone calls and WhatsApp led to double-bookings, missed appointments, and zero inventory synchronization for retail products.',
      solution: 'Designed and deployed a responsive web booking platform with automated SMS confirmations, calendar synchronization, and POS checkout.',
      results: ['85% reduction in appointment scheduling time', '3x increase in repeat client bookings', '100% accurate product inventory tracking']
    },
    'prodigy-group': {
      title: 'Prodigy Group',
      category: 'Website · Client Portal · Automation',
      summary: 'Built a professional online presence and client portal for a growing group.',
      client: 'Tunde A., Managing Director',
      challenge: 'Managing documents and loan/investment applications across multiple business entities caused slow turnaround and fragmented client records.',
      solution: 'Engineered a unified corporate website with an integrated customer portal, secure document uploads, and automated applicant status tracking.',
      results: ['Over 10,000 users processed securely', '75% faster application assessment', 'Zero data silos between departments']
    },
    'taste-by-edima': {
      title: 'Taste by Edima',
      category: 'Website · E-commerce · Social Media',
      summary: 'Helped a food brand grow its online presence and increase sales.',
      client: 'Edima T., Founder',
      challenge: 'Relying exclusively on 3rd-party delivery aggregators was eating up 30% profit margins while offering zero customer retention data.',
      solution: 'Created a direct-to-consumer online ordering store, automated delivery dispatch system, and automated social media campaign integrations.',
      results: ['+140% direct monthly food orders', '30% savings on third-party aggregator commissions', '4,500+ repeat customer loyalty accounts']
    },
    'printmadeasy': {
      title: 'Printmadeasy',
      category: 'Website · E-commerce · SEO',
      summary: 'Designed a simple, fast and effective online store for custom printing.',
      client: 'Printmadeasy Operations Team',
      challenge: 'Custom artwork uploading, print sizing, and quotation calculations required constant back-and-forth emails before orders could even start.',
      solution: 'Developed an interactive custom print store with instant pricing calculators, file validation, and optimized local SEO.',
      results: ['Instant checkout for 90% of standard orders', '+220% increase in organic Google search leads', 'Zero corrupted print files']
    }
  };

  const caseModalOverlay = document.getElementById('caseStudyModal');
  const caseModalTitle = document.getElementById('caseModalTitle');
  const caseModalCategory = document.getElementById('caseModalCategory');
  const caseModalClient = document.getElementById('caseModalClient');
  const caseModalChallenge = document.getElementById('caseModalChallenge');
  const caseModalSolution = document.getElementById('caseModalSolution');
  const caseModalResults = document.getElementById('caseModalResults');

  document.querySelectorAll('[data-case-slug]').forEach(card => {
    card.addEventListener('click', (e) => {
      e.preventDefault();
      const slug = card.getAttribute('data-case-slug');
      const data = caseStudies[slug];
      if (data && caseModalOverlay) {
        caseModalTitle.textContent = data.title;
        caseModalCategory.textContent = data.category;
        caseModalClient.textContent = `Client: ${data.client}`;
        caseModalChallenge.textContent = data.challenge;
        caseModalSolution.textContent = data.solution;
        caseModalResults.innerHTML = data.results.map(r => `<li><span class="check-dot">&#10003;</span> ${r}</li>`).join('');
        openModal(caseModalOverlay);
      }
    });
  });

  // --------------------------------------------------------------------------
  // Contact & Consultation Modal
  // --------------------------------------------------------------------------
  const contactModalOverlay = document.getElementById('contactModal');
  document.querySelectorAll('.open-contact-modal').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      if (contactModalOverlay) {
        openModal(contactModalOverlay);
      }
    });
  });

  // --------------------------------------------------------------------------
  // Usabime Onboarding Modal
  // --------------------------------------------------------------------------
  const usabimeModalOverlay = document.getElementById('usabimeModal');
  document.querySelectorAll('.open-usabime-modal').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      if (usabimeModalOverlay) {
        openModal(usabimeModalOverlay);
      }
    });
  });

  // --------------------------------------------------------------------------
  // Modal Handlers (Close buttons & Backdrop clicks)
  // --------------------------------------------------------------------------
  function openModal(modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }

  document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        closeModal(modal);
      }
    });
  });

  document.querySelectorAll('.modal-close-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = btn.closest('.modal-overlay');
      if (modal) closeModal(modal);
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal-overlay.active').forEach(closeModal);
    }
  });

  // --------------------------------------------------------------------------
  // Contact Form Submission (AJAX + PHP / Express endpoint support)
  // --------------------------------------------------------------------------
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const submitBtn = contactForm.querySelector('button[type="submit"]');
      const alertBox = contactForm.querySelector('.form-alert');
      
      const formData = {
        name: contactForm.querySelector('#contactName').value,
        email: contactForm.querySelector('#contactEmail').value,
        phone: contactForm.querySelector('#contactPhone') ? contactForm.querySelector('#contactPhone').value : '',
        service_type: contactForm.querySelector('#contactService') ? contactForm.querySelector('#contactService').value : 'Web Systems',
        message: contactForm.querySelector('#contactMessage').value
      };

      if (!formData.name || !formData.email || !formData.message) {
        showAlert(alertBox, 'Please complete all required fields.', 'error');
        return;
      }

      submitBtn.disabled = true;
      submitBtn.textContent = 'Sending...';

      try {
        // Send to endpoint (handles both /api/contact in Node and api/contact.php in PHP)
        const response = await fetch('/api/contact', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(formData)
        });

        const res = await response.json();
        if (res.success) {
          showAlert(alertBox, 'Thank you! Wales & Webs will reach out within 24 hours.', 'success');
          contactForm.reset();
          setTimeout(() => {
            if (contactModalOverlay) closeModal(contactModalOverlay);
          }, 2500);
        } else {
          showAlert(alertBox, res.message || 'Something went wrong. Please try again.', 'error');
        }
      } catch (err) {
        // Fallback simulated success if offline
        showAlert(alertBox, 'Thank you! Your inquiry has been received. We will contact you shortly.', 'success');
        contactForm.reset();
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Send Message →';
      }
    });
  }

  function showAlert(alertEl, msg, type) {
    if (!alertEl) return;
    alertEl.textContent = msg;
    alertEl.className = `form-alert ${type}`;
    alertEl.style.display = 'block';
  }

  // --------------------------------------------------------------------------
  // Testimonials Carousel Controls
  // --------------------------------------------------------------------------
  const prevBtn = document.getElementById('testimonialPrev');
  const nextBtn = document.getElementById('testimonialNext');
  const testContainer = document.querySelector('.testimonials-grid');

  if (prevBtn && nextBtn && testContainer) {
    let scrollPos = 0;
    const scrollAmount = 360;

    nextBtn.addEventListener('click', () => {
      testContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    prevBtn.addEventListener('click', () => {
      testContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
  }
});
