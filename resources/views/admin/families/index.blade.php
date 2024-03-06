<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias'
    ],
]">


<x-slot name="action">
    <a class="btn btn-blue" href="{{route('admin.families.create')}}">
        Nueva familia
    </a>
</x-slot>

@if ($families->count())
<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($families as $family)
                
          
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{$family->id}}
                </th>
                <td class="px-6 py-4">
                    {{$family->name}}
                </td>
                <td class="px-6 py-4">
                   <a href="{{route('admin.families.edit', $family)}}">Editar</a>
                </td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{$families->links()}}
</div> 
@else
<div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
    <span class="font-medium">Info alert!</span> Todavia no hay familiaa de productos registrados.
  </div>
@endif

</x-admin-layout>