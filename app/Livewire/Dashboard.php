<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class Dashboard extends Component
{
    #[Computed]
    public function cards()
    {
        return auth()->user()->cards;
    }

    public function render()
    {
        return <<<'HTML'
            <div class="flex justify-between gap-12">
                @foreach ($this->cards as $card)
                    <div class="p-6 w-full text-gray-900 dark:text-gray-100 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <livewire:todo-card :$card :key="$card->id" />
                    </div>
                @endforeach
            </div>
        HTML;
    }
}
