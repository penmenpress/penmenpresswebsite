<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use WeDevs\PM\Core\Database\Abstract_Migration as Migration;

class Create_Category_Project_Table extends Migration {
    public function schema() {
        Capsule::schema()->create( 'pm_category_project', function( $table ) {
            $table->unsignedInteger( 'project_id' );
            $table->unsignedInteger( 'category_id' );
        });
    }
}