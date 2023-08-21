<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Str;
    use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\Sluggable;
    use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\SluggableScopeHelpers;
    // use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
    use Backpack\CRUD\app\Models\Traits\CrudTrait;
    use Spatie\Permission\Traits\HasRoles;

    class NewsArticle extends Model {
        use CrudTrait;
        use HasRoles;
        // use Sluggable, SluggableScopeHelpers;
        // use HasTranslations;

        protected $table = 'news_articles';
        protected $primaryKey = 'id';
        public $timestamps = true;
        // protected $guarded = ['id'];
        protected $fillable = [
            'title', 'slug', 'content', 'short_desc', 'publisher', 'status'
        ];


        /**
         * Return the sluggable configuration array for this model.
         *
         * @return array
         */

        /*
        |--------------------------------------------------------------------------
        | FUNCTIONS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | RELATIONS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | SCOPES
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | ACCESSORS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | MUTATORS
        |--------------------------------------------------------------------------
        */
    }
