<?php

$error = [];

use Models\Movie;

$movieModel = new Movie();

$filterType = $_GET['filter_type'] ?? '';

function getFilteredMovies($model, $filterType) {
    $movies = $model->getAll();
    if ($filterType) {
        $movies = array_filter($movies, fn($m) => $m['type'] === $filterType);
    }
    return $movies;
}

$movies = getFilteredMovies($movieModel, $filterType);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['mark_watched'], $_POST['movie_id'])) {
        try {
            $movieModel->markAsWatched((int)$_POST['movie_id']);
        } catch (\Exception $e) {
            $error[] = $e->getMessage();
        }
    }

    if (isset($_POST['title'], $_POST['type'])) {
        $newMovie = new Movie();
        try {
            $newMovie->setTitle($_POST['title']);
            $newMovie->setType($_POST['type']);
            $newMovie->setRating(!empty($_POST['rating']) ? (int)$_POST['rating'] : null);
            $newMovie->setGender($_POST['genre'] ?? '');
            $newMovie->setIsWatched(0);

            $newMovie->save();

        } catch (\Exception $e) {
            $error[] = $e->getMessage();
        }
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$movies = getFilteredMovies($movieModel, $filterType);

render('movies', false, [
    'title'       => 'Ma Collection',
    'css'         => 'movies',
    'movies'      => $movies,
    'error'       => $error,
    'filter_type' => $filterType
]);
