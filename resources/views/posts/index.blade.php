<x-templates.template>

    <h1 class="text-3xl">
        Posts
    </h1>

    <ul>
        @foreach($posts as $post)
            <li class="underline"><a href="{{route('posts.show',$post)}}">{{$post->title}}</a></li>
        @endforeach
    </ul>
</x-templates.template>
