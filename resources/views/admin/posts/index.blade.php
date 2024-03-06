<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Articulos'
    ],
]">


<x-slot name="action">
    <a class="btn btn-blue" href="{{route('admin.posts.create')}}">
        Nuevo Articulo
    </a>
</x-slot>

@if ($posts->count())

    <ul class="space-y-4">
        @foreach ($posts as $post)
            <li class="grid grid-cols-2 gap-4">
                <div>
                    <img src="{{ Storage::url($post->image_path)}}" class="aspect-[16/9] object-cover object-center" alt="">
                </div>

                <div>
                    <h1 class="text-xl font-semibold">
                        {{$post->title}}
                    </h1>
                    <hr class="mt-1 mb-2">
                    <span @class([
                        'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300' => $post->published,
                        'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300' => !$post->published,
                    ])>
                        {{$post->published ? 'Publicado' : 'Borrador'}}
                    </span>

                    <p class="text-gray-600 mt-2">
                        {{$post->excerpt}}
                    </p>

                    <div class="flex justify-end mt-4">
                        <a href="{{route('admin.posts.edit', $post)}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Editar
                        </a>
                    </div>

                </div>

            </li>
        @endforeach
    </ul>

{{-- <div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Titulo
                </th>
                <th scope="col" class="px-6 py-3">
                    Publicado    
                </th>
                <th scope="col" class="px-6 py-3">
                    Creado
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                
          
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{$post->id}}
                </th>
                <td class="px-6 py-4">
                    {{$post->title}}
                </td>
                <td class="px-6 py-4">
                    {{$post->published}}
                </td>
                <td class="px-6 py-4">
                    {{$post->published_at}}
                </td>
                <td class="px-6 py-4">
                   <a href="{{route('admin.posts.edit', $post)}}">Editar</a>
                </td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
</div> --}}

<div class="mt-4">
    {{$posts->links()}}
</div> 
@else
<div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
    <span class="font-medium">Info alert!</span> Todavia no hay articulos registrados.
  </div>
@endif



</x-admin-layout>