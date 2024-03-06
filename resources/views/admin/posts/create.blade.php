<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Productos',
        'route' => route('admin.posts.index'),
    ],
    [
        'name' => 'Nuevo Ariculo'
    ],
]">

@livewire('admin.posts.post-create')

</x-admin-layout>