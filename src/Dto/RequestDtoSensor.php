<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class RequestDtoSensor
{
    #[Assert\NotBlank]
    #[Assert\Expression(
        expression: "this.getOrder() in ['asc', 'desc']"
    )]
    private string $order = 'asc';

    #[Assert\NotBlank]
    #[Assert\Expression(
        expression: "this.getSort() in ['id, 'name', 'location','value']"
    )]
    private string $sort = 'name';

    #[Assert\NotBlank]
    #[Assert\Expression(
        expression: "this.getPage() >= 1"
    )]
    private int $page = 1;

    public function __construct(string $sort, string $order, int $page)
    {
        $this->sort = $sort;
        $this->page = $page;
        $this->order = $order;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function setOrder(string $order): RequestDtoSensor
    {
        $this->order = $order;

        return $this;
    }

    public function getSort(): string
    {
        return $this->sort;
    }

    public function setSort(string $sort): RequestDtoSensor
    {
        $this->sort = $sort;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): RequestDtoSensor
    {
        $this->page = $page;

        return $this;
    }
}
