<div>
    @push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <form wire:submit="store">

        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py2 rounded-lg bg-white cursor-pointer hover:text-gray-700">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen

                    <input type="file" class="hidden" accept="image/*" wire:model="image" name="" id="">
                </label>
            </div>

            <img src="{{ $image ? $image->temporaryUrl() : Storage::url($postEdit['image_path']) }}"
                class="aspect-[16/9] object-cover object-center w-full" alt="">
        </figure>

        <x-validation-errors class="mb-4"></x-validation-errors>

        <div class="card">
            <div class="mb-4">
                <x-label class="mb-2">
                    Titulo
                </x-label>
                <x-input wire:model="postEdit.title" class="w-full" placeholder="Ingrese el código del posto" />
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Slug
                </x-label>
                <x-input wire:model="postEdit.slug" class="w-full" placeholder="Ingrese el nombre del posto" />
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Extracto
                </x-label>
                <x-textarea wire:model="postEdit.excerpt" class="w-full"
                    placeholder="Ingrese el extracto del Post"></x-textarea>
            </div>
            <div class="mb-4"  wire:ignore>
                <x-label class="mb-2">
                    Etiquetas
                </x-label>
                <select class="tag-multiple" wire:model="tagsselect" name="tags[]" multiple="multiple" style="width: 100%;">
                    @foreach ($tags as $tag)
                        <option value="{{$tag->id}}" @selected(collect(old('tags', $post->tags->pluck('id')))->contains($tag->id))>{{$tag->name}}</option>
                    @endforeach
                  </select>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Descripcion
                </x-label>
                <x-textarea rows="4" wire:model="postEdit.body" class="w-full"
                    placeholder="Ingrese el cuerpo del Post"></x-textarea>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Familias
                </x-label>
                <x-select class="w-full" wire:model.live="family_id">
                    <option value="" disabled>Seleccione una familia</option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">{{ $family->name }}</option>
                    @endforeach
                </x-select>

            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Categoría
                </x-label>
                <x-select class="w-full" wire:model.live="category_id">
                    <option value="" disabled>Seleccione una categoría</option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>

            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Subcategoría
                </x-label>
                <x-select class="w-full" wire:model.live="postEdit.subcategory_id">
                    <option value="" disabled>Seleccione una subcategoria</option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </x-select>

            </div>

            <div class="mb-4">

                <label class="relative inline-flex items-center cursor-pointer">
                    <input wire:model="postEdit.published" name="published" type="checkbox" value="1" class="sr-only peer" @checked(old('published', $post->published) == 1)>
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Publicar</span>
                </label>

            </div>


        </div>

        <div class="flex justify-end">

            <x-danger-button onclick="confirmDelete()">
                Eliminar
            </x-danger-button>
            <x-button class="ml-2">
                Actualizar
            </x-button>
        </div>

    </form>


    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" id="delete-form">
        @csrf
        @method('DELETE')



    </form>

    @push('js')
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            function confirmDelete() {
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
                        document.getElementById('delete-form').submit();
                    }
                });
            }
        </script>
    {{-- <script>
        $(document).ready(function() {
    $('.tag-multiple').select2();
});
    </script> --}}
    <script>
    
            $('.tag-multiple').select2();
            $('.tag-multiple').on('change', function (e) {
                var data = $('.tag-multiple').select2("val");
                @this.set('tagsselect', data);
            });
       
    </script>
    @endpush

</div>
