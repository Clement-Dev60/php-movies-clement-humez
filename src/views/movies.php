<?php ob_start() ?>

<div class="test">
    <h1>Ma Collection</h1>

    <?php if (!empty($error)) : ?>
        <ul style="color:red;">
            <?php foreach ($error as $err) : ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div>
            <label for="type">Type :</label>
            <select name="type" id="type" required>
                <option value="film">Film</option>
                <option value="serie">Série</option>
            </select>
        </div>

        <div>
            <label for="genre">Genre :</label>
            <input type="text" name="genre" id="genre">
        </div>

        <div>
            <label for="rating">Note (1-5) :</label>
            <input type="number" name="rating" id="rating" min="1" max="5">
        </div>


        <button type="submit">Ajouter</button>
    </form>

    <?php if (!empty($movies)) : ?>
        <ul>
            <form method="GET" action="">
                <select name="filter_type">
                    <option value="">Tous</option>
                    <option value="film">Films</option>
                    <option value="serie">Séries</option>
                </select>
                <button type="submit">Filtrer</button>
            </form>
            <?php foreach ($movies as $movie) : ?>
                <li>
                    <strong><?= htmlspecialchars($movie['title']) ?></strong> -
                    <?= ucfirst(htmlspecialchars($movie['type'])) ?>
                    <?php if (!empty($movie['genre'])) : ?>
                        (Genre : <?= htmlspecialchars($movie['genre']) ?>)
                    <?php endif; ?>
                    <?= !empty($movie['rating']) ? ' - Note : ' . htmlspecialchars($movie['rating']) : '' ?>

                    - <?= (!empty($movie['is_watched']) && $movie['is_watched']) ? 'Vu' : 'À voir' ?>
                    <form method="POST" action="">
                        <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                        <button type="submit" name="mark_watched">Marquer comme vu</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
</div>
<?php else : ?>
    <p>Aucun film/série pour le moment.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();

render('default', true, [
    'title'   => 'Ma Collection',
    'css'     => 'movies',
    'content' => $content,
    'movies'  => $movies,
    'error'   => $error
]);
?>