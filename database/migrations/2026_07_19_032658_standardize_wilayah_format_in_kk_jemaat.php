<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            UPDATE kk_jemaat SET id_group_wilayah = CASE
                WHEN TRIM(id_group_wilayah) = '-' THEN '0'
                WHEN TRIM(id_group_wilayah) = '009' THEN '9'
                WHEN TRIM(id_group_wilayah) = '01-02' THEN '1-2'
                WHEN TRIM(id_group_wilayah) IN ('03','04','05','06','07','08','09') THEN SUBSTRING(TRIM(id_group_wilayah), 2, 1)
                WHEN TRIM(id_group_wilayah) = '0' THEN '0'
                WHEN TRIM(id_group_wilayah) = '99' THEN '99'
                ELSE TRIM(id_group_wilayah)
            END
        ");
    }

    public function down(): void
    {
    }
};