<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TodoList extends Component
{
    public $draft = '';
    public function add()
    {
        $this->query()->create([
            'name' => $this->pull('draft'),
            'position' => $this->query()->max('position') + 1,
        ]);
    }

    public function remove($id)
    {
        $todo = $this->query()->findOrFail($id);

        // Move this todo far away and then delete
        $this->move($todo, 9999999);
        $todo->delete();
    }

    public function sort($key, $position)
    {
        $todo = $this->query()->findOrFail($key);

        $this->move($todo, $position);
    }

    #[Computed()]
    public function todos()
    {
        return $this->query()->orderBy('position')->get();
    }

    protected function query()
    {
        return auth()->user()->todos();
    }

    protected function move($todo, $position)
    {
        DB::transaction(function () use ($todo, $position) {
            $current = $todo->position;
            $after = $position;


            if ($current === $after) return;

            // Pull it out of the list momentarily
            $todo->update(['position' => -1]);

            // Shift the list
            $block = $this->query()
                ->whereBetween('position', [
                    min($current, $after),
                    max($current, $after),
                ]);


            // shift up if dragging down otherwise shift down
            $needToShiftBlockUp = $current < $after;

            $needToShiftBlockUp
                ? $block->decrement('position')
                : $block->increment('position');

            // place the item back in the list
            $todo->update(['position' => $after]);
        });
    }
}
