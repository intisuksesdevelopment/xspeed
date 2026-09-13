import shutil

# Fix breadcrumb + append all missing CSS in single-product.css

old_breadcrumb = """/* =======================
   PRODUCT BREADCRUMB
======================= */
.product-breadcrumb {
    padding: 14px 0;
    font-size: 12px;
    color: var(--muted);
}

.product-breadcrumb .container {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;

    font-family: Rajdhani, sans-serif;
}

.product-breadcrumb a {
    color: #9ca3af;
    text-decoration: none;
}

.product-breadcrumb a:hover {
    color: var(--accent);
}

.product-breadcrumb .active {
    color: var(--accent);
    font-weight: 600;
}"""

new_breadcrumb = """/* =======================
   PRODUCT BREADCRUMB
======================= */
.product-breadcrumb {
    padding: 14px 0;
    font-size: 12px;
}
.product-breadcrumb .container {
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    align-items: center;
    font-family: Rajdhani, sans-serif;
    font-size: 12px;
}
.crumb-home {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #9ca3af;
    text-decoration: none;
    font-weight: 600;
    transition: color .2s;
}
.crumb-home:hover { color: #FFCC00; }
.crumb-sep {
    display: flex;
    align-items: center;
    color: #4b5563;
    margin: 0 4px;
}
.crumb-link {
    color: #9ca3af;
    text-decoration: none;
    font-weight: 600;
    transition: color .2s;
    padding: 2px 4px;
    border-radius: 4px;
}
.crumb-link:hover {
    color: #FFCC00;
    text-decoration: underline;
    text-underline-offset: 3px;
}
.crumb-active {
    color: #e5e7eb;
    font-weight: 600;
    padding: 2px 4px;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}"""

missing_css = """
/* =======================
   PROMO BANNER
======================= */
.promo-banner {
    display: flex;
    align-items: center;
    gap: 14px;
    background: linear-gradient(135deg, rgba(255,204,0,0.1) 0%, rgba(255,204,0,0.04) 100%);
    border: 1px solid rgba(255,204,0,0.2);
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 14px;
    position: relative;
    overflow: hidden;
}
.promo-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,204,0,0.4), transparent);
}
.promo-badge {
    flex-shrink: 0;
    background: linear-gradient(135deg, #FFCC00, #FFB300);
    color: #111;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(255,204,0,0.3);
}
.promo-content { flex: 1; min-width: 0; }
.promo-text {
    font-size: 12px;
    color: #e8ecf4;
    font-weight: 600;
    line-height: 1.5;
}
.promo-code {
    margin-top: 5px;
    font-size: 11px;
    color: #8892a0;
    display: flex;
    align-items: center;
    gap: 6px;
}
.promo-code strong {
    color: #FFCC00;
    font-family: 'Courier New', monospace;
    font-size: 12px;
    letter-spacing: 1px;
    background: rgba(255,204,0,0.1);
    padding: 2px 8px;
    border-radius: 4px;
    border: 1px solid rgba(255,204,0,0.2);
}
.promo-close {
    position: absolute;
    top: 8px;
    right: 8px;
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 2px;
    line-height: 1;
    transition: color .2s;
}
.promo-close:hover { color: #ef4444; }

/* =======================
   SECTION MINI LABEL
======================= */
.section-mini-label {
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #67748E;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-mini-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,0.06);
}

/* =======================
   ADS SLIDER
======================= */
.ads-slider-wrap { margin-bottom: 0; }
.ads-slider { position: relative; }
.ads-slide-track { position: relative; min-height: 80px; }
.ads-slide-card {
    display: block;
    text-decoration: none;
    border-radius: 12px;
    overflow: hidden;
}
.ads-slide-inner {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: linear-gradient(135deg, rgba(255,204,0,0.1) 0%, rgba(255,204,0,0.04) 100%);
    border: 1px solid rgba(255,204,0,0.2);
    border-radius: 12px;
    position: relative;
    overflow: hidden;
    transition: transform .2s;
}
.ads-slide-inner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #FFCC00, #FFB300);
}
.ads-slide-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(255,204,0,0.12);
    border: 1px solid rgba(255,204,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFCC00;
}
.ads-slide-text { flex: 1; min-width: 0; }
.ads-slide-title {
    font-size: 11px;
    font-weight: 700;
    color: #FFCC00;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2px;
}
.ads-slide-desc {
    font-size: 12px;
    color: #c8cdd8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ads-slide-arrow {
    flex-shrink: 0;
    color: #67748E;
    transition: color .2s, transform .2s;
}
.ads-slide-card:hover .ads-slide-inner {
    background: linear-gradient(135deg, rgba(255,204,0,0.15) 0%, rgba(255,204,0,0.07) 100%);
    border-color: rgba(255,204,0,0.35);
    transform: translateX(3px);
}
.ads-slide-card:hover .ads-slide-arrow {
    color: #FFCC00;
    transform: translateX(4px);
}
.ads-slider-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-top: 10px;
}
.ads-nav-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.04);
    color: #67748E;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s, border-color .2s, color .2s;
}
.ads-nav-btn:hover {
    background: rgba(255,204,0,0.15);
    border-color: rgba(255,204,0,0.3);
    color: #FFCC00;
}
.ads-dots { display: flex; gap: 6px; align-items: center; }
.ads-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.2);
    cursor: pointer;
    padding: 0;
    transition: background .2s, width .2s, border-radius .2s;
}
.ads-dot.active {
    background: #FFCC00;
    width: 18px;
    border-radius: 3px;
}

/* =======================
   PRODUCT ADS BANNER (full-width)
======================= */
.ads-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 16px 20px;
    background: linear-gradient(135deg, rgba(255,204,0,0.08) 0%, rgba(255,204,0,0.03) 100%);
    border: 1px solid rgba(255,204,0,0.15);
    border-radius: 12px;
    text-decoration: none;
    color: #e2e8f0;
    font-size: 12px;
    transition: background .25s, border-color .25s, transform .2s;
    position: relative;
    overflow: hidden;
    margin-bottom: 10px;
}
.ads-banner:last-child { margin-bottom: 0; }
.ads-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,204,0,0.4), transparent);
}
.ads-banner:hover {
    background: linear-gradient(135deg, rgba(255,204,0,0.14) 0%, rgba(255,204,0,0.06) 100%);
    border-color: rgba(255,204,0,0.3);
    transform: translateX(4px);
    color: #fff;
}
.ads-banner-content {
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
    min-width: 0;
}
.ads-banner-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: Rajdhani, sans-serif;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #FFCC00;
    margin-bottom: 2px;
}
.ads-banner-title {
    font-size: 13px;
    font-weight: 700;
    color: #FFCC00;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ads-banner-desc {
    font-size: 11px;
    color: rgba(255,255,255,0.5);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ads-banner-cta {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: Rajdhani, sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #FFCC00;
    text-transform: uppercase;
    opacity: 0;
    transition: opacity .2s;
}
.ads-banner:hover .ads-banner-cta { opacity: 1; }
"""

for path in ['public/build/css/single-product.css', 'resources/css/single-product.css']:
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Replace old breadcrumb CSS
    if 'product-breadcrumb a {' in content:
        content = content.replace(old_breadcrumb, new_breadcrumb)

    # Fix related-grid mobile: repeat(8, -> repeat(3,
    content = content.replace(
        '@media (max-width:480px) {\n    .related-grid {\n        display: grid;\n        grid-template-columns: repeat(8, minmax(0, 1fr));',
        '@media (max-width:480px) {\n    .related-grid {\n        display: grid;\n        grid-template-columns: repeat(3, 1fr);'
    )
    # Also handle already fixed version
    content = content.replace(
        'grid-template-columns: repeat(8, minmax(0, 1fr));',
        'grid-template-columns: repeat(3, 1fr);'
    )

    # Append missing CSS
    if '.ads-banner' not in content:
        content = content.rstrip() + '\n' + missing_css

    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f'Done: {path}')
    print(f'  Lines: {len(content.splitlines())}')
