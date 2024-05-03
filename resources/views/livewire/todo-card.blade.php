<div class="card-wrapper">
	<div class="card-content flex flex-col gap-5">
		<h2 class="text-lg font-semibold text-slate-50">
			{{ $card->name }}
		</h2>
		{{-- Add todo --}}
		<form wire:submit="add">
			<div class="flex gap-2">
				<input
					class="block w-full rounded-full border-0 px-6 py-3.5 text-lg text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-slate-800 dark:text-gray-100 dark:ring-slate-300 dark:placeholder:text-slate-400 dark:focus:ring-indigo-600 sm:leading-6"
					wire:model="draft"
					placeholder="Today I'm gonna..."
					type="text">
			</div>
		</form>

		{{-- Todo List --}}
		<x-sortable class="grid gap-4"
			group="todos"
			handler="sort">
			@foreach ($this->todos as $todo)
				<x-sortable.item
					class="border-opacity-45 px-4.5 group flex items-center justify-between rounded-full border border-indigo-400 bg-white p-3.5 py-2 shadow dark:bg-slate-900"
					:key="$todo->id">
					<div class="overflow-hidden text-slate-600 dark:text-slate-200">
						<div
							class="flex -translate-x-[1.5rem] items-center gap-2.5 transition duration-300 [body:not(.sorting)_&]:group-hover:translate-x-0">
							<x-sortable.handle class="cursor-grab text-slate-800 opacity-50 transition dark:text-indigo-100">
								<svg class="h-5 w-5"
									width="24"
									height="24"
									viewBox="0 0 24 24"
									xmlns="http://www.w3.org/2000/svg">
									<path fill="none"
										stroke="currentColor"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="1.5"
										d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
								</svg>
							</x-sortable.handle>
							{{ $todo->name }}
						</div>
					</div>

					<button class="full rounded-full p-1.5 text-slate-200 duration-200 hover:bg-indigo-100 hover:text-indigo-800"
						wire:click="remove({{ $todo->id }})">
						<svg class="h-5 w-5 opacity-0 transition-opacity duration-200 group-hover:opacity-100"
							width="24"
							height="24"
							viewBox="0 0 24 24"
							xmlns="http://www.w3.org/2000/svg">
							<path fill="currentColor"
								fill-rule="evenodd"
								d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353l8.493-12.74a.75.75 0 0 1 1.04-.207"
								clip-rule="evenodd" />
						</svg>
					</button>
				</x-sortable.item>
			@endforeach
		</x-sortable>
	</div>
</div>
