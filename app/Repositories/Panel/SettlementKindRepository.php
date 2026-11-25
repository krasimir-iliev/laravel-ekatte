<?php

namespace App\Repositories\Panel;

use App\Models\SettlementKind;
use App\Repositories\Repository;

class SettlementKindRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected SettlementKind $model) {}
}
