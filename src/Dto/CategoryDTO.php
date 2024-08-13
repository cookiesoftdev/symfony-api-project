<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CategoryDTO
{

    private ?int $id = null;

    #[
        Assert\NotBlank(message: 'Name is required')
    ]
    private ?string $name = null;

    #[
        Assert\NotBlank(message: 'Description is required')
    ]
    private ?string $description = null;
    private ?string $picture = null;

    #[
        Assert\NotNull(message: 'Status is required'),
        Assert\Choice(choices: ['0','1'],message: 'Status have 0 or 1')
    ]
    private ?int $status = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CategoryDTO
     */
    public function setId(?int $id): CategoryDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return CategoryDTO
     */
    public function setName(?string $name): CategoryDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return CategoryDTO
     */
    public function setDescription(?string $description): CategoryDTO
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string|null $picture
     * @return CategoryDTO
     */
    public function setPicture(?string $picture): CategoryDTO
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return CategoryDTO
     */
    public function setStatus(?int $status): CategoryDTO
    {
        $this->status = $status;
        return $this;
    }



}