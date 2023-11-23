<?php

namespace App\Observers;

/**
 * Присваивает модели при ее создании franchise_slug текущего пользователя
 */

class FranchiseObserver
{
    public function creating($model): void
    {
        $model->franchise_slug = auth()->user()->franchise_slug;
    }
}
