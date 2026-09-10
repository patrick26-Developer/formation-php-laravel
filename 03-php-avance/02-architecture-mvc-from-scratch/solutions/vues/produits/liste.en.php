<h1>Our products</h1>
<ul>
    <?php foreach ($produits as $produit): ?>
        <li><?= htmlspecialchars($produit['nom']) ?> — <?= htmlspecialchars((string) $produit['prix']) ?> €</li>
    <?php endforeach; ?>
</ul>
