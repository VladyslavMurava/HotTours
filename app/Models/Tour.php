<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['destination_id', 'title', 'description', 'price', 'duration', 'departure_date', 'image', 'is_hot'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function photos()
    {
        return $this->hasMany(TourImage::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
