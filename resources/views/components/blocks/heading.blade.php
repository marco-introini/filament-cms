@props([
    'level' => 'h1'
    ])

<div class="prose">
    <{{$level}}>
{{$slot}}
    </{{$level}}>
</div>
