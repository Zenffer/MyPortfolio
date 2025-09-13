<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My Portfolio">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="cursor-circle" id="cursor-circle"></div>
    <!-- Hero Section with Animated Background -->
    <section class="intro">
      <!-- Particle Animation Canvas -->
      <canvas id="intro-particles"></canvas>
      
      <!-- Main Name Display -->
      <h1 class="name">Hi, I'm Jerome.</h1>
      
      <!-- Professional Title -->
      <h2 class="title">Developer, Photographer & Cosplayer.</h2>
      
      <!-- Scroll Down Indicator -->
      <div class="scroll-indicator">
        <svg width="96" height="64" viewBox="0 0 60 40" fill="none">
          <polyline points="20,18 30,32 40,18" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </section>

    <!-- Main Content Area -->
    <main>
        <!-- Navigation Menu -->
        <nav class="main-nav">
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>

        <!-- About Section -->
        <section id="about">
            <h1>About Me</h1>
            <p>Welcome to my portfolio! Here you can learn more about me and my work.</p>
        </section>

        <!-- Projects Section -->
        <section id="projects">
            <h2>Projects</h2>
            <p>Check out some of my recent projects below.</p>
        </section>

        <!-- Contact Section -->
        <section id="contact">
            <h2>Contact</h2>
            <p>Feel free to reach out to me for any inquiries or collaborations.</p>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
    </footer>

    <!-- Scroll Animation Script -->
    <script>
    $(window).on('scroll', function() {
      var intro = $('.intro');
      var introHeight = intro.outerHeight();
      var scrollY = $(window).scrollTop();
      var main = $('main');
      var indicator = $('.scroll-indicator');
      if (scrollY > 0) {
        main.addClass('visible');
        indicator.addClass('hidden');
      } else {
        main.removeClass('visible');
        indicator.removeClass('hidden');
      }
      if (scrollY > introHeight * 0.5) {
        intro.addClass('hidden');
      } else {
        intro.removeClass('hidden');
      }
    });
    </script>
    
    <!-- Particle Animation Script -->
    <script>
const canvas = document.getElementById('intro-particles');
const ctx = canvas.getContext('2d');
let particles = [];
const PARTICLE_COUNT = 1000;
const PARTICLE_COLOR = 'rgba(95, 159, 255, 0.29)';
const PARTICLE_RADIUS = 2;
// Attraction physics towards the cursor circle
const ATTRACTOR_STRENGTH = 0.1; // pull strength
const FRICTION = 0.92;            // velocity damping
const MAX_SPEED = 5;            // cap speed
const CLUSTER_RADIUS = 48;        // radius to condense around
const INFLUENCE_RADIUS = 220;     // no attraction beyond this distance

function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

function randomBetween(a, b) {
  return a + Math.random() * (b - a);
}

function createParticle(x, y) {
  const shapeRand = Math.random();
  const shape = shapeRand < 0.4 ? 'circle' : shapeRand < 0.7 ? 'square' : shapeRand < 0.9 ? 'triangle' : 'diamond';
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
  for (let i = 0; i < PARTICLE_COUNT; i++) {
    particles.push(createParticle(
      randomBetween(0, canvas.width),
      randomBetween(0, canvas.height)
    ));
  }
}
initParticles();

function drawParticle(p) {
  ctx.save();
  ctx.translate(p.x, p.y);
  if (p.shape && p.shape !== 'circle') {
    ctx.rotate(p.rotation || 0);
  }
  ctx.beginPath();
  switch (p.shape) {
    case 'square':
      ctx.rect(-p.radius, -p.radius, 2 * p.radius, 2 * p.radius);
      break;
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
  ctx.fill();
  ctx.restore();
}

function drawParticles() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  particles.forEach(p => {
    const baseAlpha = (typeof p.alpha === 'number' ? p.alpha : 1);
    const opacity = (typeof p.opacity === 'number' ? p.opacity : 1);
    ctx.globalAlpha = Math.max(0, Math.min(1, baseAlpha * opacity));
    drawParticle(p);
    ctx.globalAlpha = 1;
  });
}

function updateParticles() {
  const targetX = window.__cursorCircleX;
  const targetY = window.__cursorCircleY;
  const hasTarget = Number.isFinite(targetX) && Number.isFinite(targetY);
  particles.forEach(p => {
    let influenced = false;

    if (hasTarget) {
      const dx = targetX - p.x;
      const dy = targetY - p.y;
      const dist = Math.hypot(dx, dy) + 0.0001;

      if (dist <= INFLUENCE_RADIUS) {
        influenced = true;
        // Apply friction only when within influence radius
        p.vx *= FRICTION;
        p.vy *= FRICTION;

        // Stronger pull outside the cluster radius, gentler inside
        const outside = Math.max(dist - CLUSTER_RADIUS, 0);
        const proximity = 1 - Math.min(dist / INFLUENCE_RADIUS, 1); // soft falloff to the boundary
        const f = ATTRACTOR_STRENGTH * (outside / (CLUSTER_RADIUS + outside)) * proximity;

        p.vx += (dx / dist) * f;
        p.vy += (dy / dist) * f;
      }
    }

    // Outside influence radius or if no target: small random walk to keep particles alive
    if (!influenced) {
      p.vx += (Math.random() - 0.5) * 0.03;
      p.vy += (Math.random() - 0.5) * 0.03;
    }

    // Clamp speed
    const speed = Math.hypot(p.vx, p.vy);
    if (speed > MAX_SPEED) {
      p.vx = (p.vx / speed) * MAX_SPEED;
      p.vy = (p.vy / speed) * MAX_SPEED;
    }

    // Integrate position
    p.x += p.vx;
    p.y += p.vy;

    // Bounce off edges
    if (p.x < 0) { p.x = 0; p.vx *= -1; }
    if (p.x > canvas.width) { p.x = canvas.width; p.vx *= -1; }
    if (p.y < 0) { p.y = 0; p.vy *= -1; }
    if (p.y > canvas.height) { p.y = canvas.height; p.vy *= -1; }

    // Fade out if alpha < 1
    if (p.alpha < 1) p.alpha -= 0.01;
    if (p.alpha < 0.1) p.alpha = 0;
  });
}

function animate() {
  updateParticles();
  drawParticles();
  requestAnimationFrame(animate);
}
animate();

canvas.addEventListener('mousemove', function(e) {
  const rect = canvas.getBoundingClientRect();
  const mx = e.clientX - rect.left;
  const my = e.clientY - rect.top;
  // Add a burst of particles at cursor
  for (let i = 0; i < 15; i++) {
    let p = createParticle(mx, my);
    p.alpha = 1;
    particles.push(p);
    if (particles.length > PARTICLE_COUNT * 2) particles.shift();
  }
});
</script>

<!-- Custom Cursor Animation Script -->
<script>
(function() {
  const circle = document.getElementById('cursor-circle');
  if (!circle) return;
  let cx = -100, cy = -100; // current position
  let tx = -100, ty = -100; // target position
  let visible = false;
  // expose smoothed cursor position to particles
  window.__cursorCircleX = cx;
  window.__cursorCircleY = cy;

  function onMove(e) {
    tx = e.clientX;
    ty = e.clientY;
    if (!visible) {
      circle.style.opacity = '1';
      visible = true;
    }
  }

  function onLeave() {
    visible = false;
    circle.style.opacity = '0';
    window.__cursorCircleX = -100;
    window.__cursorCircleY = -100;
  }

  function raf() {
    // Smooth follow using linear interpolation
    cx += (tx - cx) * 0.2;
    cy += (ty - cy) * 0.2;
    circle.style.left = cx + 'px';
    circle.style.top = cy + 'px';
    window.__cursorCircleX = cx;
    window.__cursorCircleY = cy;
    requestAnimationFrame(raf);
  }

  document.addEventListener('mousemove', onMove, { passive: true });
  document.addEventListener('mouseleave', onLeave);
  raf();
})();
</script>
</body>
</html>