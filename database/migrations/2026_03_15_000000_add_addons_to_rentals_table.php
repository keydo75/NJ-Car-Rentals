<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Add-on fields stored as JSON
            $table->json('addons')->nullable()->after('notes');
            $table->decimal('addons_price', 10, 2)->default(0)->after('addons');
            $table->decimal('subtotal', 10, 2)->default(0)->after('addons_price');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('subtotal');
            // Terms acceptance
            $table->boolean('terms_accepted')->default(false)->after('tax_amount');
            $table->timestamp('terms_accepted_at')->nullable()->after('terms_accepted');
        });
    }

    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn([
                'addons',
                'addons_price',
                'subtotal',
                'tax_amount',
                'terms_accepted',
                'terms_accepted_at',
            ]);
        });
    }
};

