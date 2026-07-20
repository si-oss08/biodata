  document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initProjectFilters();
    initTouchEffects();
    initBackToTop();
  });

  /**
   * Fungsi untuk menangani efek sentuhan (touch) pada perangkat mobile
   */
  function initTouchEffects() {
    document.addEventListener('touchstart', function(e) {
      const card = e.target.closest('.info-item, .contact-button, .project-card, .github-card');
      if (card) {
        card.classList.add('is-touched');
      }
    }, {passive: true});
    
    document.addEventListener('touchend', function(e) {
      const card = e.target.closest('.info-item, .contact-button, .project-card, .github-card');
      if (card) {
        setTimeout(() => {
          card.classList.remove('is-touched');
        }, 150);
      }
    });
    
    document.addEventListener('touchcancel', function(e) {
      const card = e.target.closest('.info-item, .contact-button, .project-card, .github-card');
      if (card) {
        card.classList.remove('is-touched');
      }
    });
  }

  /**
   * Fungsi untuk memfilter dan mengelompokkan project dengan animasi halus
   */
  function initProjectFilters() {
    const container = document.getElementById('projectCardsContainer');
    const wrapper = document.getElementById('projectsWrapper');
    const filterContainer = document.getElementById('filterContainer');
    
    if (!container || !filterContainer || !wrapper) return;
    
    // Ambil copy semua card project dari DOM awal
    const allCards = Array.from(container.querySelectorAll('.project-card'));
    const uniqueMKs = [...new Set(allCards.map(card => card.getAttribute('data-mk')))];
    
    // Generate Tombol Filter HTML (A11y friendly)
    let filterHTML = `<button class="filter-btn active" data-filter="all" aria-pressed="true">Semua Project</button>`;
    uniqueMKs.forEach(mk => {
      filterHTML += `<button class="filter-btn" data-filter="${mk}" aria-pressed="false">${mk}</button>`;
    });
    filterContainer.innerHTML = filterHTML;
    
    const buttons = filterContainer.querySelectorAll('.filter-btn');
    buttons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        // Reset status active dan aria-pressed
        buttons.forEach(b => {
          b.classList.remove('active');
          b.setAttribute('aria-pressed', 'false');
        });
        
        // Set tombol terpilih menjadi aktif
        e.target.classList.add('active');
        e.target.setAttribute('aria-pressed', 'true');
        
        const selectedFilter = e.target.getAttribute('data-filter');
        
        // Terapkan animasi transisi saat memfilter
        animateFilterTransition(selectedFilter, allCards, container, wrapper, uniqueMKs);
      });
    });
    
    // Render awal (Tampilkan semua project & dividernya) tanpa animasi filter
    renderProjects('all', allCards, container, uniqueMKs);
  }

  /**
   * Menangani animasi Fade Out -> Render ulang -> Fade In untuk filtering
   */
  function animateFilterTransition(filter, allCards, container, wrapper, uniqueMKs) {
    // 1. Fade Out Container Keseluruhan
    wrapper.style.opacity = '0';
    
    // 2. Tunggu sebentar sampai transisi CSS (0.4s) hampir selesai, lalu render DOM baru
    setTimeout(() => {
      renderProjects(filter, allCards, container, uniqueMKs);
      
      // 3. Pancing render, lalu Fade In Container Keseluruhan kembali
      void wrapper.offsetWidth; 
      wrapper.style.opacity = '1';
    }, 300); // 300ms delay agar terasa natural
  }

  /**
   * Menggambar ulang card project ke layar beserta pemisahnya berdasarkan filter
   */
  function renderProjects(filter, allCards, container, uniqueMKs) {
    container.innerHTML = ''; // Kosongkan DOM
    
    const mksToRender = filter === 'all' ? uniqueMKs : [filter];
    
    mksToRender.forEach(mk => {
      const cardsForMK = allCards.filter(card => card.getAttribute('data-mk') === mk);
      
      if (cardsForMK.length > 0) {
        // Pembuatan Divider per MK
        const divider = document.createElement('div');
        divider.className = 'mk-divider reveal-item active'; // Langsung aktif karena sudah dibungkus Wrapper Fade
        divider.innerHTML = `<span>${mk}</span><div class="line"></div>`;
        container.appendChild(divider);
        
        // Sisipkan Card
        cardsForMK.forEach((card, index) => {
          card.classList.remove('active'); 
          container.appendChild(card);
          
          void card.offsetWidth; // Reflow
          
          // Efek gelombang (staggered delay) yang sangat halus
          setTimeout(() => {
            card.classList.add('active');
          }, 80 * index);
        });
      }
    });
  }

  /**
   * Fungsi untuk mengatur animasi saat elemen masuk ke dalam layar (Viewport)
   */
  function initScrollReveal() {
    const revealElements = document.querySelectorAll('.reveal-item');
    
    const observerOptions = {
      root: null,
      rootMargin: '0px',
      threshold: 0.15 
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    revealElements.forEach(element => {
      scrollObserver.observe(element);
    });
  }

  /**
   * Logika untuk memunculkan dan fungsi klik dari tombol Back to Top
   */
  function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTopBtn');
    
    if (!backToTopBtn) return;

    // Deteksi scroll untuk memunculkan tombol
    window.addEventListener('scroll', () => {
      if (window.scrollY > 400) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    });

    // Scroll ke atas saat tombol diklik
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }