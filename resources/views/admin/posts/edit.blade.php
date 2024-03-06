<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ariculos',
        'route' => route('admin.posts.index'),
    ],
    [
        'name' => $post->title
    ],
]">

<div class="mb-12">
    @livewire('admin.posts.post-edit', ['post' => $post], key('post-edit'.$post->id))
</div>


</x-admin-layout>