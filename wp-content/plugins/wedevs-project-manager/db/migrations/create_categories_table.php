<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use WeDevs\PM\Core\Database\Abstract_Migration as Migration;

class Create_Categories_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'pm_categories', function( $table ) {
            $table->increments( 'id' );

            $table->string('title');
            $table->text('description')->nullable();
            $table->string( 'categorible_type' )->nullable();

            $table->unsignedInteger( 'created_by' )->nullable();
            $table->unsignedInteger( 'updated_by' )->nullable();

            $table->timestamps();
        });
    }
}