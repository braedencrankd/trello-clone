<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Component;
use Livewire\Attributes\Computed;

class TodoCard extends Component
{
    public Card $card;
    public $draft = '';

    public function add()
    {
        $this->query()->create([
            'name' => $this->pull('draft'),
        ]);
    }

    public function remove($id)
    {
        $this->query()->findOrFail($id)->delete();
    }

    public function sort($key, $position)
    {
        $todo = auth()->user()->todos()->findOrFail($key);

        // When moving betweeen tranfer ownership of the todo to this card
        if ($todo->card->isNot($this->card)) {
            $todo->displace();
            $todo->card()->associate($this->card);
        }

        $todo->move($position);
    }

    #[Computed()]
    public function todos()
    {
        return $this->query()->get();
    }

    protected function query()
    {
        return $this->card->todos();
    }
}
