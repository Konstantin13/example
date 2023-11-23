<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Если пользователь не администратор, то всем запросам добавляется фильтр по franchise_slug
 */

class FranchiseScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if(!auth()->user()->hasAccess('app.sysadmin')){
            $builder->where($model->getTable() . '.franchise_slug', '=', auth()->user()->franchise_slug);
        }
    }
}
