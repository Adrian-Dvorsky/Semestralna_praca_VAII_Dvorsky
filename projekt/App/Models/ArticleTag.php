<?php

namespace App\Models;

use App\Core\Model;

class ArticleTag extends Model
{
    protected ?int $id;
    protected int $idArticle;
    protected int $idTag;

    public function getIdTag(): int
    {
        return $this->idTag;
    }

    public function setIdTag(int $idTag): void
    {
        $this->idTag = $idTag;
    }

    public function getIdArticle(): int
    {
        return $this->idArticle;
    }

    public function setIdArticle(int $idArticle): void
    {
        $this->idArticle = $idArticle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}