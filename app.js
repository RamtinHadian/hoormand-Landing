/* هورمند — صفحهٔ معرفی. بدون وابستگی؛ فقط transform و opacity انیمیت می‌شوند. */

// راه‌های تماس؛ هر کدام که خالی باشد در صفحه نشان داده نمی‌شود.
const CONTACT = window.HOORMAND_CONTACT || {   // on the server these come from config.php
  demoUrl: 'https://demo.ramtinai.com', phone: '03133920', phoneExt: '500', telegram: '',
};

const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
const faDigits = (s) => String(s).replace(/[0-9]/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[d]);

/* ---------- reveal on scroll ---------- */
const io = new IntersectionObserver((entries) => {
  entries.forEach((e) => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
}, { threshold: 0.12, rootMargin: '0px 0px -5% 0px' });
document.querySelectorAll('.rv').forEach((el) => io.observe(el));
requestAnimationFrame(() => document.body.classList.add('ready'));

/* ---------- the navigation pill leaves when you read down and comes back when you scroll up ---------- */
const nav = document.getElementById('nav');
let lastY = scrollY;
addEventListener('scroll', () => {
  const y = scrollY;
  if (!reduce) nav.classList.toggle('hide', y > lastY && y > 500);
  lastY = y;
}, { passive: true });

/* ---------- product frame: rises and settles as it crosses the screen ---------- */
const dev = document.getElementById('stageDev');
let dRun = false;
const dFrame = () => {
  dRun = false;
  const r = dev.getBoundingClientRect();
  const p = Math.min(1, Math.max(0, (innerHeight - r.top) / (innerHeight * 0.9)));   // 0 → 1 as it enters
  const e = 1 - Math.pow(1 - p, 3);
  dev.style.transform = `translate3d(0, ${((1 - e) * 60).toFixed(1)}px, 0) scale(${(0.94 + 0.06 * e).toFixed(3)})`;
};
if (!reduce) { addEventListener('scroll', () => { if (!dRun) { dRun = true; requestAnimationFrame(dFrame); } }, { passive: true }); dFrame(); }

/* ---------- waves under the flow section: 38 thin gradient lines that flow like silk.
   The phase drifts with time and with the scroll; redrawn only while the section is on screen. ---------- */
const waves = document.getElementById('waves');
if (waves) {
  const NS = 'http://www.w3.org/2000/svg';
  waves.innerHTML = '<defs><linearGradient id="wg" x1="0" x2="1" y1="0" y2="0"><stop offset="0" stop-color="#3b82f6"/><stop offset=".32" stop-color="#a855f7"/><stop offset=".62" stop-color="#f59e0b"/><stop offset="1" stop-color="#f97316"/></linearGradient></defs>';
  const N = 38;
  const paths = [];
  for (let k = 0; k < N; k++) {
    const p = document.createElementNS(NS, 'path');
    p.setAttribute('fill', 'none'); p.setAttribute('stroke', 'url(#wg)'); p.setAttribute('stroke-width', '0.9');
    p.setAttribute('opacity', (0.12 + 0.5 * (1 - Math.abs(k - N / 2) / (N / 2))).toFixed(2));
    waves.appendChild(p); paths.push(p);
  }
  const drawWaves = (time) => {
    const t = time / 1000;
    const sc = scrollY * 0.0016;
    paths.forEach((p, k) => {
      let d = '';
      for (let x = 0; x <= 1440; x += 20) {
        const u = x / 1440;
        const amp = (70 + 60 * Math.sin(u * Math.PI * 1.1)) * (1 + 0.12 * Math.sin(t * 0.5 + u * 3));   // the swell breathes
        const y = 215 - u * 70 + amp * Math.sin(u * 8.4 - 1.2 - t * 0.55 - sc + k * 0.045) * 0.6 + k * 0.7;
        d += (x ? 'L' : 'M') + x + ' ' + y.toFixed(1) + ' ';
      }
      p.setAttribute('d', d);
    });
  };
  drawWaves(0);
  if (!reduce) {
    let on = false;
    const loop = (now) => { if (!on) return; drawWaves(now); requestAnimationFrame(loop); };
    new IntersectionObserver(([e]) => { on = e.isIntersecting; if (on) requestAnimationFrame(loop); }).observe(waves);
  }
}

/* ---------- phones: each moves at its own speed while the section scrolls ---------- */
const phonesEl = document.getElementById('phones');
const phones = [...document.querySelectorAll('#phones .phone')];
let pRun = false;
const pFrame = () => {
  pRun = false;
  const r = phonesEl.getBoundingClientRect();
  const p = (innerHeight - r.top) / (innerHeight + r.height);
  if (p < -0.1 || p > 1.1) return;
  phones.forEach((el) => {
    const speed = parseFloat(el.dataset.speed) || 0.1;
    el.style.transform = `translate3d(0, ${((0.5 - p) * speed * 700).toFixed(1)}px, 0)`;
  });
};
if (!reduce) addEventListener('scroll', () => { if (!pRun) { pRun = true; requestAnimationFrame(pFrame); } }, { passive: true });

/* ---------- showcase tabs: a crossfade that can be interrupted at any moment ---------- */
const tabs = [...document.querySelectorAll('.tabs [role=tab]')];
const imgs = [...document.querySelectorAll('#stageImgs img')];
const titleEl = document.getElementById('stageTitle');
const textEl = document.getElementById('stageText');
let auto = true, idx = 0, timer = 0;
const select = (i, manual) => {
  if (manual) { auto = false; clearInterval(timer); }
  idx = i;
  tabs.forEach((t, k) => t.setAttribute('aria-selected', String(k === i)));
  imgs.forEach((im) => im.classList.toggle('on', im.dataset.k === tabs[i].dataset.img));
  titleEl.textContent = tabs[i].dataset.title;
  textEl.style.opacity = '0';
  setTimeout(() => { textEl.textContent = tabs[i].dataset.text; textEl.style.opacity = '1'; }, 160);
};
tabs.forEach((t, i) => t.addEventListener('click', () => select(i, true)));
tabs.forEach((t, i) => t.addEventListener('keydown', (e) => {
  const next = (n) => { e.preventDefault(); select(n, true); tabs[n].focus(); };
  if (e.key === 'ArrowDown' || e.key === 'ArrowLeft') next((i + 1) % tabs.length);
  if (e.key === 'ArrowUp' || e.key === 'ArrowRight') next((i + tabs.length - 1) % tabs.length);
}));
new IntersectionObserver(([e]) => {
  clearInterval(timer);
  if (e.isIntersecting && auto && !reduce) timer = setInterval(() => select((idx + 1) % tabs.length), 5200);
}, { threshold: 0.4 }).observe(document.querySelector('.show'));

/* ---------- contact (only what is filled in above) ---------- */
const row = document.getElementById('contactRow');
const add = (text, href, primary) => {
  const a = document.createElement('a');
  a.className = 'btn btn-lg ' + (primary ? 'btn-blue' : 'btn-glass');
  a.href = href; a.textContent = text;
  if (/^https?:/.test(href)) { a.target = '_blank'; a.rel = 'noopener'; }
  row.append(a);
};
const phoneText = CONTACT.phone ? faDigits(CONTACT.phone) + (CONTACT.phoneExt ? ' (داخلی ' + faDigits(CONTACT.phoneExt) + ')' : '') : '';
if (CONTACT.demoUrl) add('ورود به نمایش آزمایشی', CONTACT.demoUrl, true);
if (CONTACT.phone) add('تماس: ' + phoneText, 'tel:' + CONTACT.phone + (CONTACT.phoneExt ? ',' + CONTACT.phoneExt : ''), !CONTACT.demoUrl);
if (CONTACT.telegram) add('تلگرام', CONTACT.telegram, false);
if (!row.children.length) row.hidden = true;
document.querySelectorAll('[data-cta]').forEach((a) => {
  if (CONTACT.demoUrl) { a.href = CONTACT.demoUrl; a.target = '_blank'; a.rel = 'noopener'; }
});

/* ---------- the growth chart: a line is drawn over the tops of the four steps ---------- */
const chart = document.getElementById('chart');
const trace = document.getElementById('trace');
const drawChart = () => {
  if (!chart || !trace || getComputedStyle(trace).display === 'none') return;
  const NS = 'http://www.w3.org/2000/svg';
  const cr = chart.getBoundingClientRect();
  const w = cr.width, h = cr.height - 300;
  trace.setAttribute('viewBox', `0 0 ${w} ${h}`);
  const bars = [...chart.querySelectorAll('.bar-c')];
  const pts = bars.map((b) => { const r = b.getBoundingClientRect(); return [r.left - cr.left + r.width / 2, r.top - cr.top - 18]; });
  const start = [pts[0][0] + 190, pts[0][1] - 30];
  const endPt = [Math.max(10, pts[3][0] - 190), pts[3][1] + 34];
  let d = `M ${start[0]} ${start[1]} `;
  let prev = start;
  pts.forEach((p) => { const cx = (prev[0] + p[0]) / 2; d += `C ${cx} ${prev[1]}, ${cx} ${p[1]}, ${p[0]} ${p[1]} `; prev = p; });
  { const cx = (prev[0] + endPt[0]) / 2; d += `C ${cx} ${prev[1]}, ${cx} ${endPt[1]}, ${endPt[0]} ${endPt[1]} `; prev = endPt; }
  trace.innerHTML = '<defs><linearGradient id="tg" x1="1" x2="0"><stop offset="0" stop-color="#3b82f6"/><stop offset=".5" stop-color="#a855f7"/><stop offset="1" stop-color="#f97316"/></linearGradient><linearGradient id="ta" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#a855f7" stop-opacity=".16"/><stop offset="1" stop-color="#a855f7" stop-opacity="0"/></linearGradient></defs>';
  const line = document.createElementNS(NS, 'path'); line.setAttribute('class', 'line'); line.setAttribute('d', d); trace.appendChild(line);
  const len = line.getTotalLength();
  line.style.strokeDasharray = len; line.style.strokeDashoffset = trace.classList.contains('in') ? 0 : len;
  const colors = ['#3b82f6', '#7c5cf0', '#c04fd0', '#f97316'];
  pts.forEach((p, i) => { const pl = document.createElementNS(NS, 'circle'); pl.setAttribute('class', 'pulse'); pl.setAttribute('cx', p[0]); pl.setAttribute('cy', p[1]); pl.setAttribute('r', 12); pl.style.animationDelay = (i * 0.65) + 's'; trace.appendChild(pl); const c = document.createElementNS(NS, 'circle'); c.setAttribute('cx', p[0]); c.setAttribute('cy', p[1]); c.setAttribute('r', 11); c.setAttribute('stroke', colors[i]); c.style.transitionDelay = (0.5 + i * 0.35) + 's'; trace.appendChild(c); });
  const spark = document.createElementNS(NS, 'circle'); spark.setAttribute('class', 'spark'); spark.setAttribute('r', 5); trace.appendChild(spark);
  trace._len = len; trace._line = line; trace._spark = spark;
};
if (chart) {
  drawChart();
  addEventListener('resize', drawChart);
  new IntersectionObserver(([e]) => {
    if (!e.isIntersecting) return;
    trace.classList.add('in');
    const line = trace._line;
    if (line && !reduce) { line.style.transition = 'stroke-dashoffset 1.9s cubic-bezier(0.23, 1, 0.32, 1) .2s'; line.style.strokeDashoffset = 0; }
    else if (line) line.style.strokeDashoffset = 0;
  }, { threshold: 0.35 }).observe(chart);
  addEventListener('load', drawChart);
}


/* ---------- hero: living light rays. Soft beams fan out from below the page and slowly breathe; dust rises through them;
   the whole fan leans toward the pointer. Pauses when the hero is off screen; one still frame when motion is reduced. ---------- */
(() => {
  const cv = document.getElementById('rayCanvas');
  if (!cv) return;
  const ctx = cv.getContext('2d');
  const hero = cv.closest('.hero');
  const SCALE = 0.5;
  let W = 0, H = 0, running = false, t0 = performance.now(), lean = 0, leanTo = 0;
  const stops = [[59, 99, 255], [99, 70, 255], [150, 80, 240], [196, 80, 215], [226, 84, 170], [240, 110, 110], [249, 140, 50]];
  const col = (k) => { const x = k * (stops.length - 1), i = Math.min(Math.floor(x), stops.length - 2), f = x - i, a = stops[i], b = stops[i + 1]; return a.map((v, j) => Math.round(v + (b[j] - v) * f)); };
  const BEAMS = 24;
  const beams = Array.from({ length: BEAMS }, (_, i) => ({ k: i / (BEAMS - 1), ph: Math.random() * 6.28, sp: 0.35 + Math.random() * 0.5, w: 0.7 + Math.random() * 0.7 }));
  const dust = Array.from({ length: 46 }, () => ({ x: Math.random(), y: Math.random(), s: 0.4 + Math.random() * 1.4, v: 0.015 + Math.random() * 0.04, ph: Math.random() * 6.28 }));
  const size = () => { const r = hero.getBoundingClientRect(); W = Math.max(2, Math.round(r.width * SCALE)); H = Math.max(2, Math.round(r.height * SCALE)); cv.width = W; cv.height = H; };
  const draw = (now, still) => {
    const t = still ? 2.2 : (now - t0) / 1000;
    lean += (leanTo - lean) * 0.06;
    ctx.clearRect(0, 0, W, H);
    ctx.globalCompositeOperation = 'lighter';
    const ox = W / 2 + lean * W * 0.06, oy = H * 1.3, R = H * 1.25;
    const spread = 0.82 + Math.sin(t * 0.25) * 0.04;            // the fan opens and closes very slowly
    beams.forEach((b) => {
      const ang = (b.k - 0.5) * spread * 2 + lean * 0.05 - Math.PI / 2;
      const half = (0.034 + 0.02 * Math.sin(t * b.sp + b.ph)) * b.w;
      const a = 0.26 + 0.22 * Math.sin(t * b.sp * 1.3 + b.ph);   // each beam breathes on its own
      const [r, g, bl] = col(b.k);
      const x1 = ox + Math.cos(ang - half) * R, y1 = oy + Math.sin(ang - half) * R;
      const x2 = ox + Math.cos(ang + half) * R, y2 = oy + Math.sin(ang + half) * R;
      const gr = ctx.createRadialGradient(ox, oy, R * 0.10, ox, oy, R * 0.98);
      gr.addColorStop(0, `rgba(${r},${g},${bl},0)`);
      gr.addColorStop(0.30, `rgba(${r},${g},${bl},${(a * 0.9).toFixed(3)})`);
      gr.addColorStop(1, `rgba(${r},${g},${bl},0)`);
      ctx.fillStyle = gr;
      ctx.beginPath(); ctx.moveTo(ox, oy); ctx.lineTo(x1, y1); ctx.lineTo(x2, y2); ctx.closePath(); ctx.fill();
    });
    // the bright core where the beams meet
    const core = ctx.createRadialGradient(ox, oy, 0, ox, oy, H * 0.55);
    core.addColorStop(0, 'rgba(255,214,170,0.55)'); core.addColorStop(0.35, 'rgba(190,110,240,0.22)'); core.addColorStop(1, 'rgba(120,80,255,0)');
    ctx.fillStyle = core; ctx.fillRect(0, 0, W, H);
    // dust rising through the light
    dust.forEach((d) => {
      const y = ((d.y - (still ? 0 : t) * d.v) % 1 + 1) % 1;
      const x = d.x + Math.sin(t * 0.4 + d.ph) * 0.012;
      const tw = 0.5 + 0.5 * Math.sin(t * 1.4 + d.ph);
      ctx.fillStyle = `rgba(255,235,220,${(0.10 + 0.5 * tw * (1 - y)).toFixed(3)})`;
      ctx.beginPath(); ctx.arc(x * W, (0.2 + 0.8 * y) * H, d.s * 1.2, 0, 6.283); ctx.fill();
    });
  };
  const loop = (now) => { if (!running) return; draw(now, false); requestAnimationFrame(loop); };
  size(); draw(performance.now(), true);
  addEventListener('resize', () => { size(); draw(performance.now(), true); });
  if (reduce) return;
  new IntersectionObserver(([e]) => { running = e.isIntersecting; if (running) requestAnimationFrame(loop); }).observe(hero);
  if (matchMedia('(hover: hover) and (pointer: fine)').matches) {
    hero.addEventListener('pointermove', (e) => { const r = hero.getBoundingClientRect(); leanTo = ((e.clientX - r.left) / r.width - 0.5) * 2; });
    hero.addEventListener('pointerleave', () => { leanTo = 0; });
  }
})();


/* a bright spark travels along the chart line, again and again */
(() => {
  const tr = document.getElementById('trace');
  if (!tr || reduce) return;
  let t0 = 0, vis = false;
  new IntersectionObserver(([e]) => { vis = e.isIntersecting; if (vis) requestAnimationFrame(step); }).observe(tr);
  const step = (now) => {
    if (!vis) return;
    const line = tr._line, spark = tr._spark;
    if (line && spark && tr.classList.contains('in')) {
      if (!t0) t0 = now + 2200;
      const t = Math.max(0, now - t0) / 4200 % 1.0;          // 4.2 s per trip
      const e = t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
      const pt = line.getPointAtLength(tr._len * e);
      spark.setAttribute('cx', pt.x); spark.setAttribute('cy', pt.y);
    }
    requestAnimationFrame(step);
  };
})();


/* the soft spotlight inside each list item follows the pointer */
document.querySelectorAll('.col li').forEach((li) => {
  li.addEventListener('pointermove', (e) => { const r = li.getBoundingClientRect(); li.style.setProperty('--mx', (e.clientX - r.left) + 'px'); li.style.setProperty('--my', (e.clientY - r.top) + 'px'); });
});


/* ---------- crystal navigation: the lens slides to the hovered link and rests on the section you are reading ---------- */
(() => {
  const box = document.getElementById('navLinks');
  if (!box) return;
  const lens = box.querySelector('.lens');
  const links = [...box.querySelectorAll('a')];
  let current = null;
  const to = (a) => {
    if (!a) { lens.style.opacity = '0'; return; }
    lens.style.width = a.offsetWidth + 'px';
    lens.style.transform = `translateX(${a.offsetLeft}px)`;
    lens.style.opacity = '1';
  };
  const rest = () => to(current);
  if (matchMedia('(hover: hover) and (pointer: fine)').matches) {
    links.forEach((a) => a.addEventListener('pointerenter', () => to(a)));
    box.addEventListener('pointerleave', rest);
  }
  const map = new Map(links.map((a) => [a.getAttribute('href').slice(1), a]));
  const seen = new Map();
  const io2 = new IntersectionObserver((es) => {
    es.forEach((e) => seen.set(e.target.id, e.isIntersecting ? e.intersectionRatio : 0));
    let best = null, bv = 0;
    seen.forEach((v, id) => { if (v > bv && map.has(id)) { bv = v; best = map.get(id); } });
    current = bv > 0 ? best : null;
    links.forEach((a) => a.classList.toggle('cur', a === current));
    if (!box.matches(':hover')) rest();
  }, { threshold: [0, .15, .3, .5, .75] });
  map.forEach((_, id) => { const s = document.getElementById(id); if (s) io2.observe(s); });
  addEventListener('resize', rest);
})();
