<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'title',
        'image',
        'show_date',
        'category_id',
    ];


    // scopes
    public function scopeToday($query)
    {
        return $query->where('show_date', Carbon::today());
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getShowDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }

}
