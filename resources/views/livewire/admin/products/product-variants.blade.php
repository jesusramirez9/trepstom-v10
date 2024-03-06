<div>

    <section class="rounded-lg border border-gray-200 shadow-lg bg-white">
        <header class="border-b border-gray-200 px-6 py-2">
            <div class="flex justify-between">
                <h1 class="text-lg font-semibold text-gray-700">
                    Opciones
                </h1>
                <x-button wire:click="$set('openModal', true)">
                    Nueva opcion
                </x-button>
            </div>
        </header>

        <div class="p-6">

            @if ($product->options->count())
            <div class="space-y-6">
                @foreach ($product->options as $option)
                    <div wire:key="product-option-{{ $option->id }}"
                        class="p-6 rounded-lg border border-gray-200 relative">
                        <div class="absolute -top-3 px-4 bg-white">
                            <button onclick="confirmDeleteOption({{ $option->id }})">
                                <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                            </button>
                        </div>
                        <span class="ml-2">
                            {{ $option->name }}
                        </span>

                        {{-- valore --}}

                        <div class="flex flex-wrap">
                            @foreach ($option->pivot->features as $feature)
                            <div wire:key="option-{{$option->id}}-feature-{{$feature['id']}}">

                            
                                @switch($option->type)
                                    @case(1)
                                        {{-- Texto --}}

                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">{{ $feature['description'] }}
                                            <button class="ml-1"
                                                onclick="confirmDeleteFeature({{ $option->id }},{{ $feature['id'] }}, 'feature')">
                                                <i class="fa-solid fa-xmark hover:text-red-500"></i>
                                            </button>
                                        </span>
                                    @break

                                    @case(2)
                                        {{-- Color --}}
                                        <div class="relative">

                                            <span
                                                class="inline-block h-6 w-6 shadow-lg rounded-full border-2 border-gray-300 mr-4"
                                                style="background-color: {{ $feature['value'] }};">
                                                <button
                                                    class="absolute left-3 -top-2 z-10 rounded-full bg-red-500 hover:bg-red-600 h-4 w-4 flex justify-center items-center"
                                                    onclick="confirmDeleteFeature({{ $option->id }},{{ $feature['id'] }}, 'feature')">
                                                    <i class="fa-solid fa-xmark hover:text-white text-xs"></i>
                                                </button>
                                            </span>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach


            </div>
            @else
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Alerta!</span> No hay opciones para este producto.
              </div>
            @endif
                    
        </div>
    </section>

    @if ($product->variants->count())
    <section class="rounded-lg border border-gray-200 shadow-lg bg-white mt-12">
        <header class="border-b border-gray-200 px-6 py-2">
            <div class="flex justify-between">
                <h1 class="text-lg font-semibold text-gray-700">
                    Variantes
                </h1>
            </div>
        </header>

        <div class="p-6">
            <ul class="divide-y -my-4">
               
                @foreach ($product->variants as $item)
                    <li class="py-4 flex items-center">
                        <img src="{{$item->image}}" class="w-12 h-12 object-cover object-center" alt="">
                        
                        <p class="divide-x">
                            @foreach ($item->features as $feature)
                               <span class="px-3">
                                    {{$feature->description}}
                               </span>     
                            @endforeach
                        </p>

                        <a href="{{route('admin.products.variants', [$product, $item])}}" class="ml-auto btn btn-blue"> 
                            Editar
                        </a>
                   
                    </li>
                @endforeach
              
            </ul>
        </div>
    
    </section>
    @else
        
    @endif

    

    <x-dialog-modal wire:model="openModal">

        <x-slot name="title">
            Agregar nueva opción
        </x-slot>

        <x-slot name="content">

            <x-validation-errors class="mb-4">

            </x-validation-errors>

            <div class="mb-4">
                <x-label>
                    Opción
                </x-label>
                <x-select class="w-full" wire:model.live="variant.option_id">
                    <option value="" disabled>Seleccione una opción</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}">
                            {{ $option->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="flex items-center mb-6">
                <hr class="flex-1">
                <span class="mx-4">Valores</span>
                <hr class="flex-1">
            </div>
            <ul class="mb-4 space-y-4">

                @foreach ($variant['features'] as $index => $feature)
                    <li wire:key="variant-feature-{{ $index }}"
                        class="relative border border-gray-200 rounded-lg p-6 mb-4">
                        <div class="absolute -top-3 bg-white  px-4">
                            <button wire:click="removeFeature({{ $index }})">
                                <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                            </button>
                        </div>
                        <div>
                            <x-label class="mb-1">
                                Valores
                            </x-label>
                            <x-select class="w-full" wire:model="variant.features.{{ $index }}.id"
                                wire:change="feature_change({{ $index }})">
                                <option value="" disabled>
                                    Seleccióne un valor
                                </option>
                                @foreach ($this->features as $feature)
                                    <option value="{{ $feature->id }}">
                                        {{ $feature->description }}
                                    </option>
                                @endforeach
                            </x-select>

                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="flex justify-end">
                <x-button wire:click="addFeature">Agregar valor</x-button>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-danger-button wire:click="$set('openModal', 'false')">
                Cancelar
            </x-danger-button>
            <x-button class="ml-2" wire:click="save">
                Guardar
            </x-button>
        </x-slot>

    </x-dialog-modal>

    @push('js')
        <script>
            function confirmDeleteFeature(option_id, feature_id) {
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

                        @this.call('deleteFeature', option_id, feature_id);

                    }
                });
            }

            function confirmDeleteOption(option_id) {
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

                        @this.call('deleteOption', option_id);

                    }
                });
            }
        </script>
    @endpush
</div>
