<table class="table table-stripped">
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach($allStores as $store): ?>
            <tr>
                <td><?= $store->id ?></td>
                <td><?= $store->name ?></td>
                <td><?= $store->description ?></td>
                <td>
                    <a href="/locavore/stores/update/<?= $store->id ?>" class='btn btn-warning'>Modifier</a>
                    <a href="/locavore/admin/delete/<?= $store->id ?>" class='btn btn-danger'>Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>