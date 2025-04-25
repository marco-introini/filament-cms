<x-templates.template>

    @foreach($contents as $content)
        @if($content['type'] == 'title')
            <x-blocks.heading :level="$content['data']['level']">
                {{$content['data']['title']}}
            </x-blocks.heading>
        @elseif($content['type'] == 'markdown')
            <x-blocks.markdown>
                {{$content['data']['markdown']}}
            </x-blocks.markdown>

        @endif
    @endforeach

</x-templates.template>
