<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Scope hanya berjalan jika ada user yang login dan role-nya bukan super_admin
        if (Auth::hasUser() && Auth::user()->role !== 'super_admin') {
            
            // Dapatkan tenant_id milik user yang sedang aktif
            $tenantId = Auth::user()->tenant_id;
            
            if ($tenantId) {
                // Untuk model yang memiliki kolom `wo_profile_id` (misal: WeddingPackage, Vendor, Client, WeddingProject, dll.)
                if (in_array('wo_profile_id', $model->getFillable()) || $model->getConnection()->getSchemaBuilder()->hasColumn($model->getTable(), 'wo_profile_id')) {
                    $builder->where($model->getTable() . '.wo_profile_id', $tenantId);
                } 
                // Untuk model User sendiri jika difilter berdasarkan tenant_id
                elseif ($model->getTable() === 'users') {
                    $builder->where('tenant_id', $tenantId);
                }
            }
        }
    }
}
