// Shared site scripts: scroll reveal, particles (home only), and custom cursor

(function() {
  // Scroll reveal for main/intro
  function setupScrollReveal() {
    var intro = document.querySelector('.intro');
    var mainEl = document.querySelector('main');
    var indicator = document.querySelector('.scroll-indicator');
    if (!mainEl) return;
    
    // If no intro section, make main visible immediately
    if (!intro) {
      mainEl.classList.add('visible');
      return;
    }

    function onScroll() {
      var introRect = intro.getBoundingClientRect();
      var introHeight = introRect.height || window.innerHeight;
      var scrollY = window.scrollY || window.pageYOffset;

      if (scrollY > 0) {
        mainEl.classList.add('visible');
        if (indicator) indicator.classList.add('hidden');
      } else {
        mainEl.classList.remove('visible');
        if (indicator) indicator.classList.remove('hidden');
      }
      if (scrollY > introHeight * 0.5) {
        intro.classList.add('hidden');
      } else {
        intro.classList.remove('hidden');
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    // Initial state
    onScroll();
  }

  // Particle background (only if canvas exists on page)
  function setupParticles() {
    var canvas = document.getElementById('intro-particles');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var particles = [];
    var PARTICLE_COUNT = 1000;
    var PARTICLE_COLOR = 'rgba(173, 171, 255, 0.29)';
    var PARTICLE_RADIUS = 2;
    var ATTRACTOR_STRENGTH = 0.1;
    var FRICTION = 0.92;
    var MAX_SPEED = 5;
    var CLUSTER_RADIUS = 48;
    var INFLUENCE_RADIUS = 220;

    function resizeCanvas() {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    function randomBetween(a, b) { return a + Math.random() * (b - a); }

    function createParticle(x, y) {
      var shapeRand = Math.random();
      var shape = shapeRand < 0.4 ? 'circle' : shapeRand < 0.7 ? 'square' : shapeRand < 0.9 ? 'triangle' : 'diamond';
      return {
        x: x,
        y: y,
        vx: randomBetween(-1, 1),
        vy: randomBetween(-1, 1),
        radius: PARTICLE_RADIUS * randomBetween(0.7, 1.4),
        alpha: 1,
        opacity: randomBetween(0.6, 1),
        shape: shape,
        rotation: randomBetween(0, Math.PI * 2)
      };
    }

    function initParticles() {
      particles = [];
      for (var i = 0; i < PARTICLE_COUNT; i++) {
        particles.push(createParticle(randomBetween(0, canvas.width), randomBetween(0, canvas.height)));
      }
    }
    initParticles();

    function drawParticle(p) {
      ctx.save();
      ctx.translate(p.x, p.y);
      if (p.shape && p.shape !== 'circle') ctx.rotate(p.rotation || 0);
      ctx.beginPath();
      switch (p.shape) {
        case 'square':
          ctx.rect(-p.radius, -p.radius, 2 * p.radius, 2 * p.radius); break;
        case 'diamond':
          ctx.moveTo(0, -p.radius);
          ctx.lineTo(p.radius, 0);
          ctx.lineTo(0, p.radius);
          ctx.lineTo(-p.radius, 0);
          ctx.closePath();
          break;
        case 'triangle':
          ctx.moveTo(0, -p.radius);
          ctx.lineTo(p.radius, p.radius);
          ctx.lineTo(-p.radius, p.radius);
          ctx.closePath();
          break;
        default:
          ctx.arc(0, 0, p.radius, 0, Math.PI * 2);
      }
      ctx.fillStyle = PARTICLE_COLOR;
      ctx.globalAlpha = Math.max(0, Math.min(1, (typeof p.alpha === 'number' ? p.alpha : 1) * (typeof p.opacity === 'number' ? p.opacity : 1)));
      ctx.fill();
      ctx.globalAlpha = 1;
      ctx.restore();
    }

    function drawParticles() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particles.forEach(drawParticle);
    }

    function updateParticles() {
      var targetX = window.__cursorCircleX;
      var targetY = window.__cursorCircleY;
      var hasTarget = Number.isFinite(targetX) && Number.isFinite(targetY);
      particles.forEach(function(p) {
        var influenced = false;
        if (hasTarget) {
          var dx = targetX - p.x;
          var dy = targetY - p.y;
          var dist = Math.hypot(dx, dy) + 0.0001;
          if (dist <= INFLUENCE_RADIUS) {
            influenced = true;
            p.vx *= FRICTION; p.vy *= FRICTION;
            var outside = Math.max(dist - CLUSTER_RADIUS, 0);
            var proximity = 1 - Math.min(dist / INFLUENCE_RADIUS, 1);
            var f = ATTRACTOR_STRENGTH * (outside / (CLUSTER_RADIUS + outside)) * proximity;
            p.vx += (dx / dist) * f; p.vy += (dy / dist) * f;
          }
        }
        if (!influenced) {
          p.vx += (Math.random() - 0.5) * 0.03;
          p.vy += (Math.random() - 0.5) * 0.03;
        }
        var speed = Math.hypot(p.vx, p.vy);
        if (speed > MAX_SPEED) { p.vx = (p.vx / speed) * MAX_SPEED; p.vy = (p.vy / speed) * MAX_SPEED; }
        p.x += p.vx; p.y += p.vy;
        if (p.x < 0) { p.x = 0; p.vx *= -1; }
        if (p.x > canvas.width) { p.x = canvas.width; p.vx *= -1; }
        if (p.y < 0) { p.y = 0; p.vy *= -1; }
        if (p.y > canvas.height) { p.y = canvas.height; p.vy *= -1; }
        if (p.alpha < 1) p.alpha -= 0.01; if (p.alpha < 0.1) p.alpha = 0;
      });
    }

    canvas.addEventListener('mousemove', function(e) {
      var rect = canvas.getBoundingClientRect();
      var mx = e.clientX - rect.left; var my = e.clientY - rect.top;
      for (var i = 0; i < 15; i++) {
        var p = createParticle(mx, my); p.alpha = 1; particles.push(p);
        if (particles.length > PARTICLE_COUNT * 2) particles.shift();
      }
    });

    (function animate() {
      updateParticles();
      drawParticles();
      requestAnimationFrame(animate);
    })();
  }

  // Custom cursor
  function setupCursor() {
    var circle = document.getElementById('cursor-circle');
    if (!circle) return;
    var cx = -100, cy = -100, tx = -100, ty = -100, visible = false;
    var cursorEnabled = true;
    window.__cursorCircleX = cx; window.__cursorCircleY = cy;
    
    function onMove(e) {
      if (!cursorEnabled) return;
      tx = e.clientX; ty = e.clientY;
      if (!visible) { circle.style.opacity = '1'; visible = true; }
    }
    
    function onLeave() {
      visible = false; circle.style.opacity = '0';
      window.__cursorCircleX = -100; window.__cursorCircleY = -100;
    }
    
    function raf() {
      if (!cursorEnabled) {
        requestAnimationFrame(raf);
        return;
      }
      cx += (tx - cx) * 0.2; cy += (ty - cy) * 0.2;
      circle.style.left = cx + 'px'; circle.style.top = cy + 'px';
      window.__cursorCircleX = cx; window.__cursorCircleY = cy;
      requestAnimationFrame(raf);
    }
    
    // Disable cursor when main section is visible
    function checkMainVisibility() {
      var mainEl = document.querySelector('main');
      if (mainEl && mainEl.classList.contains('visible')) {
        cursorEnabled = false;
        circle.style.opacity = '0';
        window.__cursorCircleX = -100; window.__cursorCircleY = -100;
      } else {
        cursorEnabled = true;
      }
    }
    
    // Check for touch devices and disable cursor
    function checkTouchDevice() {
      if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
        cursorEnabled = false;
        circle.style.display = 'none';
        return;
      }
    }
    
    document.addEventListener('mousemove', onMove, { passive: true });
    document.addEventListener('mouseleave', onLeave);
    window.addEventListener('scroll', checkMainVisibility, { passive: true });
    
    // Initial checks
    checkTouchDevice();
    checkMainVisibility();
    raf();
  }

  // Init all features
  document.addEventListener('DOMContentLoaded', function() {
    setupScrollReveal();
    setupCursor();
    setupParticles();
    // Contact form handling
    (function setupContactForm(){
      var form = document.getElementById('contact-form');
      if (!form) return;
      var statusEl = form.querySelector('.form-status');
      function setStatus(msg, type){
        if (!statusEl) return;
        statusEl.textContent = msg || '';
        statusEl.style.color = type === 'error' ? '#b00020' : '#0a7e07';
      }
      form.addEventListener('submit', function(e){
        e.preventDefault();
        setStatus('Sending...', 'info');
        var payload = {
          name: form.name.value.trim(),
          email: form.email.value.trim(),
          subject: form.subject.value.trim(),
          message: form.message.value.trim(),
          website: form.website ? form.website.value.trim() : ''
        };
        fetch(form.getAttribute('action') || 'api/contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        }).then(function(res){
          return res.json().catch(function(){ return { ok:false, error:'Unexpected response' }; });
        }).then(function(json){
          if (json && json.ok) {
            setStatus(json.message || 'Thanks! Your message has been sent.', 'success');
            form.reset();
          } else {
            setStatus((json && json.error) || 'Failed to send. Please try again.', 'error');
          }
        }).catch(function(){
          setStatus('Network error. Please try again.', 'error');
        });
      });
    })();
    // Click-to-scroll from hero indicator to main content
    var indicator = document.querySelector('.scroll-indicator');
    var mainEl = document.querySelector('main');
    if (indicator && mainEl) {
      indicator.addEventListener('click', function(e) {
        e.preventDefault();
        mainEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }
  });
})();


