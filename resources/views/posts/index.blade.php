<x-templates.template>

    <h1 class="text-3xl">
        Posts
    </h1>

    <ul>
        @foreach($posts as $post)
            <li>{{$post->title}}</li>
        @endforeach
    </ul>
</x-templates.template>
