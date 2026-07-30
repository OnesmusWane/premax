#!/usr/bin/env node
/**
 * Image optimization for public/assets/images.
 * Overwrites files in place (same path/filename => DB-stored URLs and
 * asset() references keep working) and generates responsive srcset
 * variants for the static hero/content images. Originals are recoverable
 * from git history — see OPTIMIZATION_REPORT.md for rollback instructions.
 *
 * Usage: node scripts/optimize-images.mjs
 */
import sharp from 'sharp';
import { promises as fs } from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '..');
const IMAGES = path.join(ROOT, 'public/assets/images');

// width, quality tiers per the target spec.
// Hero images are displayed full-bleed with CSS object-cover inside
// fixed/viewport-capped-height banners, so portrait source photos are
// cropped client-side regardless — capping height too (not just width)
// avoids shipping resolution that's cropped away, with no visible change.
const HERO_TIER = {
    variants: [
        { width: 480, height: 300, quality: 80 },
        { width: 1024, height: 640, quality: 80 },
        { width: 1920, height: 1200, quality: 80 },
    ],
};
const CONTENT_TIER = { width: 1200, quality: 78 };
const GALLERY_TIER = { width: 1200, quality: 75 };
const SERVICE_TIER = { width: 800, quality: 75 };
const LOGO_MAX_WIDTH = 800;

const heroFiles = [
    'hero/home.webp', 'hero/shop.webp', 'hero/home-clinic.webp', 'hero/home-craft.webp',
    'hero/signup.webp', 'hero/signin.webp', 'hero/service.webp', 'hero/work.webp',
    'hero/contact.webp', 'hero/about.webp',
];

const contentFiles = ['about-support.webp', 'about-engineering.webp', 'booking.webp'];

const manifest = { generatedAt: null, images: [] };

async function size(p) {
    try { return (await fs.stat(p)).size; } catch { return 0; }
}

function fmt(bytes) {
    return `${(bytes / 1024).toFixed(0)}KB`;
}

async function record(label, before, after, extra = {}) {
    manifest.images.push({ file: label, beforeBytes: before, afterBytes: after,
        beforeHuman: fmt(before), afterHuman: fmt(after),
        savingsPct: before ? Math.round((1 - after / before) * 100) : 0, ...extra });
    console.log(`  ${label}: ${fmt(before)} -> ${fmt(after)} (${before ? Math.round((1 - after / before) * 100) : 0}% smaller)`);
}

async function optimizeHero(relPath) {
    const abs = path.join(IMAGES, relPath);
    const before = await size(abs);
    if (!before) { console.warn(`  skip (missing): ${relPath}`); return; }
    const buf = await fs.readFile(abs);
    const variants = HERO_TIER.variants;
    const largest = variants[variants.length - 1].width;

    for (const { width, height, quality } of variants) {
        const out = await sharp(buf)
            .resize({ width, height, fit: 'inside', withoutEnlargement: true })
            .webp({ quality })
            .toBuffer();
        if (width === largest) {
            // also overwrite the canonical (un-suffixed) path used by existing <img src>, OG tags, CSS
            await fs.writeFile(abs, out);
            await record(relPath, before, out.length, { variant: 'canonical+largest' });
        } else {
            const variantPath = abs.replace(/\.webp$/, `-${width}.webp`);
            await fs.writeFile(variantPath, out);
            await record(relPath.replace(/\.webp$/, `-${width}.webp`), before, out.length, { variant: `${width}w` });
        }
    }
}

async function optimizeContent(relPath, tier) {
    const abs = path.join(IMAGES, relPath);
    const before = await size(abs);
    if (!before) { console.warn(`  skip (missing): ${relPath}`); return; }
    const buf = await fs.readFile(abs);
    const isWebp = relPath.endsWith('.webp');
    let pipeline = sharp(buf).resize({ width: tier.width, withoutEnlargement: true });
    pipeline = isWebp ? pipeline.webp({ quality: tier.quality }) : pipeline.jpeg({ quality: tier.quality, mozjpeg: true });
    const out = await pipeline.toBuffer();
    await fs.writeFile(abs, out);
    await record(relPath, before, out.length);
}

async function optimizeDirJpeg(dirRel, tier) {
    const dir = path.join(IMAGES, dirRel);
    let entries;
    try { entries = await fs.readdir(dir); } catch { return; }
    for (const name of entries) {
        if (!/\.(jpe?g|webp)$/i.test(name)) continue;
        const abs = path.join(dir, name);
        const before = await size(abs);
        const buf = await fs.readFile(abs);
        // normalize actual content type to match the file's extension
        // (some files here are WebP bytes with a .jpg name — a real MIME bug)
        const wantsJpegOutput = /\.jpe?g$/i.test(name);
        let pipeline = sharp(buf).resize({ width: tier.width, withoutEnlargement: true });
        pipeline = wantsJpegOutput
            ? pipeline.jpeg({ quality: tier.quality, mozjpeg: true })
            : pipeline.webp({ quality: tier.quality });
        const out = await pipeline.toBuffer();
        await fs.writeFile(abs, out);
        await record(`${dirRel}/${name}`, before, out.length);
    }
}

async function optimizeLogo(relPath) {
    const abs = path.join(IMAGES, relPath);
    const before = await size(abs);
    if (!before) return;
    const buf = await fs.readFile(abs);
    const out = await sharp(buf)
        .resize({ width: LOGO_MAX_WIDTH, withoutEnlargement: true })
        .png({ compressionLevel: 9, palette: true })
        .toBuffer();
    await fs.writeFile(abs, out);
    await record(relPath, before, out.length);
}

async function main() {
    console.log('Hero images (responsive 480/1024/1920w, q80 webp):');
    for (const f of heroFiles) await optimizeHero(f);

    console.log('\nContent images (1200w, q78):');
    for (const f of contentFiles) await optimizeContent(f, CONTENT_TIER);

    console.log('\nGallery/works images (1200w, q75, fixes .jpg/.webp mismatch):');
    await optimizeDirJpeg('works', GALLERY_TIER);

    console.log('\nService images (800w, q75):');
    await optimizeDirJpeg('services', SERVICE_TIER);

    console.log('\nLogo (resized to 800w max, palette PNG):');
    await optimizeLogo('logos/logo.png');

    manifest.generatedAt = new Date().toISOString();
    const totalBefore = manifest.images.reduce((s, i) => s + i.beforeBytes, 0);
    const totalAfter = manifest.images.reduce((s, i) => s + i.afterBytes, 0);
    manifest.totals = {
        beforeBytes: totalBefore, afterBytes: totalAfter,
        beforeHuman: fmt(totalBefore), afterHuman: fmt(totalAfter),
        savingsPct: Math.round((1 - totalAfter / totalBefore) * 100),
    };

    await fs.writeFile(path.join(IMAGES, 'images-manifest.json'), JSON.stringify(manifest, null, 2));
    console.log(`\nTotal: ${fmt(totalBefore)} -> ${fmt(totalAfter)} (${manifest.totals.savingsPct}% smaller)`);
    console.log('Manifest written to public/assets/images/images-manifest.json');
}

main().catch((err) => { console.error(err); process.exit(1); });
