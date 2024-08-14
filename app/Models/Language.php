<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Language extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'languages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'flag',
        'abbr',
        'script',
        'native',
        'active',
        'default',
    ];

    public $translatable = [
        'name'
    ];

    public static function getActiveLanguages()
    {
        return Cache::rememberForever('active_languages', function () {
            return self::where('active', 1)->get();
        });
    }
}
