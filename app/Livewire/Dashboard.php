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
            <div class="space-y-6 py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                </div>
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between gap-5">
                        @foreach ($this->cards as $card)                       
                            <livewire:todo-card :$card :key="$card->id" />
                        @endforeach
                    </div>
                </div>
            </div>
        HTML;
    }
}
