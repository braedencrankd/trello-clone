<?php

namespace App\Models;

use Illuminate\Support\Lottery;
use Illuminate\Support\Facades\DB;

trait Sortable
{
    public static function bootSortable()
    {
        static::addGlobalScope('position', function ($query) {
            $query->orderBy('position');
        });
        static::creating(function ($model) {
            if (static::sortable($model)->count() === 0) {
                $model->position = 0;
            } else {
                $model->position = static::sortable($model)->max('position') + 1;
            }
        });
        static::deleting(function ($model) {
            $model->displace();
        });
    }

    public function move($position)
    {

        // Re-arrange to clean up positions every so often
        Lottery::odds(2, outOf: 100)
            ->winner(fn () => $this->arrange())
            ->choose();

        DB::transaction(function () use ($position) {
            $current = $this->position;
            $after = $position;


            if ($current === $after) return;

            // Pull it out of the list momentarily
            $this->update(['position' => -1]);

            // Shift the list
            $block = static::sortable($this)->whereBetween('position', [
                min($current, $after),
                max($current, $after),
            ]);


            // shift up if dragging down otherwise shift down
            $needToShiftBlockUp = $current < $after;

            $needToShiftBlockUp
                ? $block->decrement('position')
                : $block->increment('position');

            // place the item back in the list
            $this->update(['position' => $after]);
        });
    }
    public function arrange()
    {
        DB::transaction(function () {
            $position = 0;
            foreach (static::sortable($this)->get() as $model) {
                $model->position = $position++;
                $model->save();
            }
        });
    }
    public function displace()
    {
        $this->move(999999);
    }
}
