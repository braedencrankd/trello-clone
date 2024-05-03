<?php

namespace App\Models;

use App\Models\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, Sortable;

    protected $guarded = [];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    protected function scopeSortable($query, $todo)
    {
        return $todo->card->todos();
    }
}
