<?php
$pageTitle = 'Products';
require_once __DIR__ . '/includes/header.php';
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$products = getProducts(['search' => $search, 'category' => $category]);
$categories = getCategories();
?>
<section class="section">
    <div class="section-title">Explore Products</div>
    <p class="section-intro">Browse a curated collection of digital assets with refined search and category filters.</p>
    <form method="get" class="filter-panel">
        <label class="filter-field">
            <span class="input-label">Search</span>
            <input name="search" value="<?= sanitize($search) ?>" placeholder="Search products">
        </label>
        <label class="filter-field">
            <span class="input-label">Category</span>
            <select name="category">
                <option value="">All categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= sanitize($cat['category']) ?>" <?= $cat['category'] === $category ? 'selected' : '' ?>><?= sanitize($cat['category']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <div class="filter-actions">
            <button type="submit" class="button">Filter</button>
        </div>
    </form>
    <div class="card-grid">
        <?php if (empty($products)): ?>
            <div class="card card-body">No products match your search.</div>
        <?php endif; ?>
        <?php foreach ($products as $product): ?>
            <article class="card">
                <img class="product-image" src="<?= sanitize($product['image_url']) ?>" alt="<?= sanitize($product['title']) ?>">
                <div class="card-body">
                    <h3 class="card-title"><?= sanitize($product['title']) ?></h3>
                    <div class="card-meta"><span><?= sanitize($product['category']) ?></span><span><?= CURRENCY . number_format($product['price'], 2) ?></span></div>
                    <p style="color: var(--muted);"><?= sanitize(substr($product['description'], 0, 90)) ?>…</p>
                </div>
                <div class="card-footer">
                    <a class="button" href="<?= BASE_URL ?>product.php?id=<?= $product['id'] ?>">View</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
