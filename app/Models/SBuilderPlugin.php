<?php

declare(strict_types=1);

namespace App\Models;

abstract class SBuilderPlugin extends SBuilder
{
    public function getUserF(int $id) : mixed
    {
        return $this->getAttribute("user_f_$id");
    }

    public function getId() : mixed
    {
        return $this->getAttribute('p_id');
    }

    public function getTitle() : mixed
    {
        return $this->getAttribute('p_title');
    }

    public function getUrl() : mixed
    {
        return $this->getAttribute('p_url');
    }

    public function getSort() : mixed
    {
        return $this->getAttribute('p_order');
    }

    public function getExtId() : mixed
    {
        return $this->getAttribute('p_ext_id');
    }
}
