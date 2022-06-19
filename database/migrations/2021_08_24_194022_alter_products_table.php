<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table
                ->json('pictures')
                ->after('picture')
                ->nullable();
            $table
                ->foreignId('cover_id')
                ->after('pages')
                ->constrained('covers')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_cover_id_foreign');
            $table->dropColumn('cover_id');
            $table->dropColumn('pictures');
        });
    }
}
