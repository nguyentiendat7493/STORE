<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table): void {
            if (! Schema::hasColumn('orders', 'shipping_method_code')) {
                $table->string('shipping_method_code', 100)->nullable()->after('customer_address');
            }

            if (! Schema::hasColumn('orders', 'shipping_method_name')) {
                $table->string('shipping_method_name', 120)->nullable()->after('shipping_method_code');
            }

            if (! Schema::hasColumn('orders', 'shipping_fee')) {
                $table->decimal('shipping_fee', 12, 2)->default(0)->after('discount_amount');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table): void {
            foreach (['shipping_fee', 'shipping_method_name', 'shipping_method_code'] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
