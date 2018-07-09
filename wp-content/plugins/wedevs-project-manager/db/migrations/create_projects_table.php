<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use WeDevs\PM\Core\Database\Abstract_Migration as Migration;

class Create_Projects_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'pm_projects', function( $table ) {
            $table->increments( 'id' );

            $table->string( 'title' );
            $table->text( 'description' )->nullable();
            $table->tinyInteger( 'status' )->default(0)
                ->comment('0: incomplete; 1: complete; 2: pending; 3: archived');
            $table->float( 'budget' )->nullable();
            $table->float( 'pay_rate' )->nullable();
            $table->timestamp( 'est_completion_date' )->nullable();
            $table->string( 'color_code' )->nullable();
            $table->tinyInteger( 'order' )->nullable();
            $table->string( 'projectable_type' )->nullable();
            $table->timestamp( 'completed_at' )->nullable();
            $table->unsignedInteger( 'created_by' )->nullable();
            $table->unsignedInteger( 'updated_by' )->nullable();

            $table->timestamps();
        });
    }
}