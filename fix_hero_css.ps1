$file = "D:\xampp\htdocs\xspeed-revamp\public\build\css\dashboard.css"
$lines = Get-Content $file

$before = $lines[0..131]
$after = $lines[508..($lines.Length - 1)]

$newCss = @'
/* =======================
   HERO NEW (sleek dark premium)
======================= */
.hero-new {
    position: relative;
    min-height: 100vh;
    overflow: hidden;
    background: #0a0f1a;
    display: flex;
    flex-direction: column;
}
.hero-bg-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(105deg, #0a0f1a 38%, transparent 100%), linear-gradient(to right, rgba(10,15,26,0.85) 30%, transparent 60%), linear-gradient(180deg, rgba(10,15,26,0.6) 0%, transparent 40%);
    pointer-events: none;
}
.hero-bg-img {
    position: absolute;
    inset: 0;
    z-index: 0;
    background: url("/build/img/hero-bg.jpg") no-repeat right center / 65% auto;
    filter: brightness(0.55) saturate(0.9);
}
.hero-new .container {
    position: relative;
    z-index: 2;
    flex: 1;
    display: flex;
    align-items: center;
    padding-top: 120px;
    padding-bottom: 40px;
}
.hero-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    width: 100%;
}
.hero-left {
    display: flex;
    flex-direction: column;
}
.hero-nav {
    display: flex;
    align-items: center;
    margin-bottom: 36px;
}
.hero-nav-link {
    font-family: Rajdhani, sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    padding: 6px 14px;
    transition: color .2s;
    position: relative;
}
.hero-nav-link:hover, .hero-nav-link.active { color: #FF9F43; }
.hero-nav-link.active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 14px;
    right: 14px;
    height: 2px;
    background: #FF9F43;
    border-radius: 1px;
}
.hero-nav-spacer { flex: 1; }
.hero-nav-icon {
    background: none;
    border: none;
    color: rgba(255,255,255,0.45);
    cursor: pointer;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    transition: color .2s;
}
.hero-nav-icon:hover { color: #FF9F43; }
.hero-brand-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: Rajdhani, sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #FF9F43;
    margin-bottom: 14px;
}
.hero-brand-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FF9F43;
    box-shadow: 0 0 8px #FF9F43;
    animation: dotPulse 2s ease-in-out infinite;
}
@keyframes dotPulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 8px #FF9F43; }
    50% { opacity: 0.6; box-shadow: 0 0 3px #FF9F43; }
}
.hero-headline {
    display: flex;
    flex-direction: column;
    font-family: Orbitron, sans-serif;
    font-weight: 900;
    text-transform: uppercase;
    line-height: 0.92;
    margin: 0 0 20px;
    letter-spacing: 1px;
}
.hl-line {
    font-size: clamp(52px, 6vw, 88px);
    color: #ffffff;
}
.hl-accent { color: #FF9F43; }
.hero-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
}
.hero-tag {
    font-family: Rajdhani, sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 20px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.6);
}
.hl-tag-active {
    background: rgba(255,159,67,0.15);
    border-color: rgba(255,159,67,0.4);
    color: #FF9F43;
}
.hero-desc {
    font-family: Poppins, sans-serif;
    font-size: 15px;
    font-weight: 300;
    color: rgba(255,255,255,0.6);
    line-height: 1.7;
    margin: 0 0 28px;
    max-width: 440px;
}
.hero-cta-row { margin-bottom: 36px; }
.btn-hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 32px;
    background: linear-gradient(135deg, #FF9F43, #ff8510);
    color: #0a0f1a;
    font-family: Rajdhani, sans-serif;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(255,159,67,0.35);
    transition: transform .2s, box-shadow .2s;
}
.btn-hero-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(255,159,67,0.45);
    color: #0a0f1a;
}
.hero-features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.hero-feature {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.hf-icon {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: rgba(255,159,67,0.1);
    border: 1px solid rgba(255,159,67,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}
.hf-text { display: flex; flex-direction: column; gap: 2px; }
.hf-text strong {
    font-family: Rajdhani, sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #e2e8f0;
    text-transform: uppercase;
}
.hf-text span {
    font-family: Poppins, sans-serif;
    font-size: 11px;
    color: rgba(255,255,255,0.4);
}
.hero-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    position: relative;
}
.hero-moto-wrap {
    position: relative;
    width: 100%;
    max-width: 580px;
}
.hero-moto-img {
    width: 100%;
    height: auto;
    display: block;
    position: relative;
    z-index: 1;
    filter: drop-shadow(0 0 60px rgba(255,159,67,0.2));
    animation: motoFloat 4s ease-in-out infinite;
}
@keyframes motoFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
.hero-moto-glow {
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 70%;
    height: 60px;
    background: radial-gradient(ellipse, rgba(255,159,67,0.2) 0%, transparent 70%);
    z-index: 0;
}
.hero-bottom-strip {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,0.03);
    border-top: 1px solid rgba(255,255,255,0.06);
    backdrop-filter: blur(10px);
    padding: 16px 0;
}
.hero-stats-bar {
    display: flex;
    align-items: center;
    justify-content: center;
}
.hsb-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 36px;
}
.hsb-num {
    font-family: Orbitron, sans-serif;
    font-weight: 800;
    font-size: 22px;
    color: #FF9F43;
    line-height: 1;
    text-shadow: 0 0 16px rgba(255,159,67,0.3);
}
.hsb-label {
    font-family: Rajdhani, sans-serif;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    margin-top: 4px;
}
.hsb-sep {
    width: 1px;
    height: 32px;
    background: rgba(255,255,255,0.08);
}
@media (max-width: 1024px) {
    .hero-inner { grid-template-columns: 1fr; }
    .hero-right { display: none; }
    .hero-bg-img { background-size: 100% auto; background-position: right center; }
    .hero-bg-overlay { background: linear-gradient(to right, #0a0f1a 50%, rgba(10,15,26,0.7) 100%); }
}
@media (max-width: 768px) {
    .hero-new .container { padding-top: 100px; }
    .hero-nav { overflow-x: auto; scrollbar-width: none; }
    .hero-nav::-webkit-scrollbar { display: none; }
    .hero-nav-link { padding: 6px 10px; font-size: 11px; }
    .hero-features { grid-template-columns: 1fr 1fr; gap: 12px; }
    .hero-stats-bar { flex-wrap: wrap; gap: 16px; }
    .hsb-sep { display: none; }
    .hsb-item { padding: 0 20px; }
}
@media (max-width: 480px) {
    .hero-tags { gap: 6px; }
    .hero-tag { font-size: 9px; padding: 3px 10px; }
    .hero-desc { font-size: 13px; }
    .btn-hero-cta { padding: 12px 24px; font-size: 13px; width: 100%; justify-content: center; }
    .hero-features { grid-template-columns: 1fr; }
}
'@

$newLines = ($newCss -split "`n")
$merged = $before + $newLines + $after
$merged | Out-File -FilePath $file -Encoding UTF8
Write-Host "Done. Total lines: $($merged.Count)"
