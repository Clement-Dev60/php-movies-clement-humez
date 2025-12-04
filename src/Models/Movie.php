<?php

namespace Models;

use Exception;
use PDO;

class Movie extends Database
{
    private $id;
    private $title;
    private $type;
    private $genre;
    private $rating;
    private $is_watched;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        if (empty($value)) throw new Exception('Title is required');
        if (strlen($value) > 255) throw new Exception('Title must be under 255 characters');

        $this->title = htmlspecialchars($value);
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $value = strtolower($value);
        if (!($value == 'film' || $value == 'serie')) throw new Exception('film or serie is required');

        $this->type = htmlspecialchars($value);
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($value)
    {
        if (!is_null($value) && ($value < 1 || $value > 5)) {
            throw new Exception('A value between 1 and 5 or null is required');
        }

        $this->rating = $value;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM movies ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGender()
    {
        return $this->genre;
    }

    public function setGender($value)
    {
        if (strlen($value) > 100) throw new Exception('Gendre must be under 100 characters');

        $this->genre = htmlspecialchars($value);
    }

    public function setIsWatched($value)
    {
        $this->is_watched = $value ? 1 : 0;
    }

    public function markAsWatched($id)
    {
        $sql = "UPDATE movies SET is_watched = 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function save()
    {
        $queryExecute = $this->db->prepare("INSERT INTO `movies`(`title`, `type`, `genre`, `rating`,`is_watched`) 
			VALUES (:title, :type, :genre, :rating, :is_watched)");

        $queryExecute->bindValue(':title', $this->title, PDO::PARAM_STR);
        $queryExecute->bindValue(':type', $this->type, PDO::PARAM_STR);
        $queryExecute->bindValue(':genre', $this->genre, PDO::PARAM_STR);
        $queryExecute->bindValue(':rating', $this->rating, PDO::PARAM_STR);
        $queryExecute->bindValue(':is_watched', $this->is_watched, PDO::PARAM_STR);

        return $queryExecute->execute();
    }
}
