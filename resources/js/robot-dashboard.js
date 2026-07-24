// Pure Canvas particle + animated background (no Three.js dependency needed)
document.addEventListener('DOMContentLoaded', () => {
    const bgContainer = document.getElementById('dashboard-bg');
    if (!bgContainer) return;

    const canvas = document.createElement('canvas');
    bgContainer.appendChild(canvas);
    const ctx = canvas.getContext('2d');

    let width, height, particles = [], mouseX = 0, mouseY = 0;

    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    // Particle class
    class Particle {
        constructor() {
            this.reset();
        }
        reset() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.z = Math.random() * 2 + 0.5; // depth factor
            this.size = Math.random() * 1.5 + 0.3;
            this.speed = Math.random() * 0.3 + 0.05;
            this.vx = (Math.random() - 0.5) * 0.3;
            this.vy = (Math.random() - 0.5) * 0.3;
            this.opacity = Math.random() * 0.6 + 0.1;
            this.color = Math.random() > 0.5 ? '6, 182, 212' : '99, 102, 241'; // cyan or indigo
        }
        update() {
            this.x += this.vx;
            this.y += this.vy;
            // Mouse parallax effect
            const dx = (mouseX - width / 2) * 0.00015 * this.z;
            const dy = (mouseY - height / 2) * 0.00015 * this.z;
            this.x += dx;
            this.y += dy;
            if (this.x < -10) this.x = width + 10;
            if (this.x > width + 10) this.x = -10;
            if (this.y < -10) this.y = height + 10;
            if (this.y > height + 10) this.y = -10;
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size * this.z, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${this.color}, ${this.opacity})`;
            ctx.fill();
        }
    }

    // Init particles
    for (let i = 0; i < 200; i++) {
        particles.push(new Particle());
    }

    // Robot SVG-like drawing with canvas
    let robotAngle = 0;
    let robotX = width * 0.75;
    let robotY = height * 0.5;

    function drawRobot(time) {
        const floatY = Math.sin(time * 0.001) * 12;
        const rx = robotX;
        const ry = robotY + floatY;
        const scale = Math.min(width, height) * 0.12;

        // Body
        ctx.save();
        ctx.globalAlpha = 0.12;
        ctx.fillStyle = '#4f46e5';
        ctx.beginPath();
        ctx.roundRect(rx - scale * 0.45, ry - scale * 0.6, scale * 0.9, scale * 1.2, scale * 0.15);
        ctx.fill();

        // Head
        ctx.fillStyle = '#06b6d4';
        ctx.globalAlpha = 0.15;
        ctx.beginPath();
        ctx.arc(rx, ry - scale * 0.9, scale * 0.35, 0, Math.PI * 2);
        ctx.fill();

        // Eyes glow
        ctx.globalAlpha = 0.4;
        ctx.fillStyle = '#67e8f9';
        ctx.shadowBlur = 8;
        ctx.shadowColor = '#06b6d4';
        ctx.beginPath();
        ctx.arc(rx - scale * 0.12, ry - scale * 0.92, scale * 0.04, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(rx + scale * 0.12, ry - scale * 0.92, scale * 0.04, 0, Math.PI * 2);
        ctx.fill();

        // Arms
        ctx.globalAlpha = 0.1;
        ctx.strokeStyle = '#6366f1';
        ctx.lineWidth = scale * 0.08;
        ctx.lineCap = 'round';
        ctx.shadowBlur = 0;

        // Left arm
        ctx.beginPath();
        ctx.moveTo(rx - scale * 0.45, ry - scale * 0.3);
        ctx.lineTo(rx - scale * 0.75, ry + Math.sin(time * 0.002) * scale * 0.15);
        ctx.stroke();

        // Right arm
        ctx.beginPath();
        ctx.moveTo(rx + scale * 0.45, ry - scale * 0.3);
        ctx.lineTo(rx + scale * 0.75, ry - Math.sin(time * 0.002) * scale * 0.15);
        ctx.stroke();

        ctx.restore();
    }

    // Connection lines between nearby particles
    function drawConnections() {
        const maxDist = 120;
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < maxDist) {
                    const alpha = (1 - dist / maxDist) * 0.06;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(6, 182, 212, ${alpha})`;
                    ctx.lineWidth = 0.5;
                    ctx.stroke();
                }
            }
        }
    }

    // Track mouse
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    // Animation loop
    function animate(time) {
        ctx.clearRect(0, 0, width, height);

        // Dark gradient background
        const grad = ctx.createRadialGradient(width / 2, height / 2, 0, width / 2, height / 2, Math.max(width, height) * 0.7);
        grad.addColorStop(0, 'rgba(15, 23, 42, 0)');
        grad.addColorStop(1, 'rgba(3, 7, 18, 0.0)');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, width, height);

        // Draw connections first (behind particles)
        drawConnections();

        // Draw particles
        particles.forEach(p => {
            p.update();
            p.draw();
        });

        // Draw robot (decorative, in background)
        drawRobot(time);

        requestAnimationFrame(animate);
    }

    requestAnimationFrame(animate);

    // Expose window.robotMaterial for dock interaction (noop, kept for compatibility)
    window.robotMaterial = null;
});