<?php

declare(strict_types=1);

namespace App\Traits;

use App\Services\CategoryService;

trait AddsCategoryIdToValidatedArrayBag
{
    public function validated(): array
    {
        $category = (new CategoryService)->getByUuid($this->category_uuid);

        return array_merge($this->validator->validated(), [
            'category_id' => $category->id,
        ]);
    }
}
