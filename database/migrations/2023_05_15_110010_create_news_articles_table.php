<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateNewsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('slug')->unique();
            $table->longText('image')->nullable();
            $table->text('short_desc')->nullable();
            $table->longtext('content');
            $table->string('publisher');
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
        Schema::drop('news_articles');
    }
}
