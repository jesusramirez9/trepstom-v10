<div>

    <section class="rounded-lg shadow-lg bg-white ">

        <header class="border-b border-gray-200 px-6 py-2">
            <div class="flex justify-between">
                <h1 class="text-lg font-semibold text-gray-700">
                    Opciones
                </h1>
                <x-button wire:click="$set('newOption.openModal', true)">
                    Nueva opcion
                </x-button>
            </div>


        </header>
        <div>

        </div>



        <div class="p-6">
            <div class="space-y-6">
                @foreach ($options as $option)
                    <div class="p-6 rounded-lg border-gray-200 border relative" wire:key="option-{{$option->id}}">


                        <div class="absolute bg-white -top-3 px-4 ">

                            <button class="mr-1" onclick="confirmDelete({{$option->id}}, 'option')">
                                <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                            </button>

                            <span>
                                {{ $option->name }}
                            </span>
                        </div>

                        {{-- valore --}}

                        <div class="flex flex-wrap mb-4">
                            @foreach ($option->features as $feature)
                                @switch($option->type)
                                    @case(1)
                                        {{-- Texto --}}

                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">{{ $feature->description }}
                                            <button class="ml-1" {{--wire:click="deleteFeature({{$feature->id}})--}}onclick="confirmDelete({{$feature->id}}, 'feature')">
                                                <i class="fa-solid fa-xmark hover:text-red-500"></i>
                                            </button>
                                        </span>
                                    @break

                                    @case(2)
                                        {{-- Color --}}
                                        <div class="relative">

                                            <span class="inline-block h-6 w-6 shadow-lg rounded-full border-2 border-gray-300 mr-4"
                                            style="background-color: {{ $feature->value }};">
                                            <button class="absolute left-3 -top-2 z-10 rounded-full bg-red-500 hover:bg-red-600 h-4 w-4 flex justify-center items-center" wire:click="deleteFeature({{$feature->id}})" {{--wire:click="deleteFeature({{$feature->id}})--}} onclick="confirmDelete({{$feature->id}}, 'feature')">
                                                <i class="fa-solid fa-xmark hover:text-white text-xs"></i>
                                            </button>
                                        </span>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            @endforeach
                        </div>

                        <div>
                            @livewire('admin.options.add-new-feature', ['option' => $option], key('add-new-feature-'.$option->id))
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>

    <x-dialog-modal wire:model="newOption.openModal">
        <x-slot name="title">
            Crear nueva opción
        </x-slot>
        <x-slot name="content">

            <x-validation-errors class="mb-4"/>

            <div class="grid grid-cols-2 gap-6 mb-4">
                <div>
                    <x-label class="mb-1">Nombre</x-label>
                    <x-input wire:model="newOption.name" class="w-full" placeholder="Por ejemplo: tamaño, color" />
                </div>
                <div>
                    <x-label class="mb-1">Tipo</x-label>
                    <x-select wire:model.live="newOption.type" class="w-full">
                        <option value="1">Texto</option>
                        <option value="2">Color</option>
                    </x-select>
                </div>
            </div>

            <div class="flex items-center mb-4">
                <hr class="flex-1">
                <span class="mx-4">
                    Valores
                </span>
                <hr class="flex-1">
            </div>
            
            <div class="mb-4 space-y-4">
                @foreach ($newOption->features as $index => $feature)
                <div class="p-6 rounded-lg border border-gray-200 relative" wire:key="features-{{$index}}">
                    <div class="absolute -top-3 px-4 bg-white">
                        <button wire:click="removeFeature({{$index}})">
                            <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-label class="mb-1">Valor</x-label>

                            @switch($newOption->type)
                                @case(1)
                                    <x-input wire:model="newOption.features.{{$index}}.value" class="w-full" placeholder="Ingrese el valor de la opción" />
                                    @break
                                @case(2)

                                <div class="border border-gray-300 h-[42px] rounded-md flex items-center justify-between px-3">
                                    {{$newOption->features[$index]['value'] ?: 'Seleccione un color'  }}
                                    <input type="color"  wire:model.live="newOption.features.{{$index}}.value">
                                </div>

                                    @break
                                @default
                                    
                            @endswitch

                        </div>

                        <div>
                            <x-label class="mb-1">Descripcion</x-label>
                            <x-input wire:model="newOption.features.{{$index}}.description" class="w-full" placeholder="Ingrese descripcion" />
                        </div>
                    </div>
                </div>
            @endforeach

            </div>

            <div class="flex justify-end">
                <x-button wire:click="addFeature">
                    Agregar valor
                </x-button>
            </div>

      


        </x-slot>
        <x-slot name="footer">
            <button class="btn btn-blue" wire:click="addOption">
                Agregar
            </button>
        </x-slot>   
    </x-dialog-modal>

    @push('js')
    <script>
        function confirmDelete(id, type) {
            // document.getElementById('delete-form').submit();

            Swal.fire({
                title: "Estas seguro?",
                text: "No podras revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Borrelo!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                 // mvc normal  document.getElementById('delete-form').submit();
                // para livewire

                switch (type) {
                    case 'feature':
                    @this.call('deleteFeature', id);
                        break;

                    case 'option':
                    @this.call('deleteOption', id);
                        break;   
                
                    default:
                        break;
                }

                  

                }
            });
        }
    </script>
@endpush


</div>
