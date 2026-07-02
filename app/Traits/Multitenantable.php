<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;

trait Multitenantable
{
    public static function bootMultitenantable(): void
    {
        // 1. Secara otomatis memfilter query menggunakan TenantScope
        static::addGlobalScope(new TenantScope);

        // 2. Secara otomatis mengisi `wo_profile_id` saat create data baru
        static::creating(function ($model) {
            if (Auth::hasUser()) {
                $tenantId = Auth::user()->tenant_id;
                
                // Cari apakah model memiliki fillable property 'wo_profile_id' dan isi dengan tenant_id
                if ($tenantId && in_array('wo_profile_id', $model->getFillable())) {
                    $model->wo_profile_id = $tenantId;
                }
            }
        });
    }
}
