<h1>Liste des magasins</h1>

<?php foreach($allStores as $store): ?>
    <article>
        <h2><?= $store->name ?></h2>
        <div><?= $store->description ?></div>
        <a href="/locavore/stores/read/<?= $store->id ?>">Pour plus d'informations...</a>
    </article>
<?php endforeach; ?>