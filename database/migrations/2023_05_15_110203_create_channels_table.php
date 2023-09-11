<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateChannelsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('channels', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('desc')->nullable();
                $table->string('profile_image')->nullable();
                $table->string('cover_image')->nullable();
                $table->longText('recipient_units');
                $table->longText('recipient_programmes');
                $table->string('email')->unique();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('channels');
        }
    }
