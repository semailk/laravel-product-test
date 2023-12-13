<?php

namespace App\DTO;

use Illuminate\Http\Request;

class ProductDto
{
    private string $article;
    private string $name;
    private string $status;
    private array $data;

    public function __construct(Request $request)
    {
        $this->article = $request->article;
        $this->name = $request->name;
        $this->status = $request->status;
        $this->data = $request->data ?? [];
    }

    public function getArticle(): string
    {
        return $this->article;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
