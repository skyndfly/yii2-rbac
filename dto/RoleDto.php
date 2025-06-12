<?php

namespace app\dto;

class RoleDto
{
    public int $type;
    public string $name;
    public string $description;
    public ?string $ruleName;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(int $type, string $name, string $description, ?string $ruleName, string $createdAt, string $updatedAt)
    {
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
        $this->ruleName = $ruleName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

}