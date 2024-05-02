@props(['handler'])

<div {{ $attributes }}
	x-sort="$wire.{{ $handler }}($item, $position)">
	{{ $slot }}
</div>
