<div>

    <form wire:submit="store" x-data="data()" x-init="$watch('title', value => { string_to_slug(value) })">


        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py2 rounded-lg bg-white cursor-pointer hover:text-gray-700">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen

                    <input type="file" class="hidden" accept="image/*" wire:model="image" name="" id="">
                </label>
            </div>

            <img src="{{ $image ? $image->temporaryUrl() : asset('img/noProduct.jpg') }}"
                class="aspect-[16/6] object-cover object-center w-full" alt="">
        </figure>

        <x-validation-errors class="mb-4"></x-validation-errors>

        <div class="card">
            <div class="mb-4">
                <x-label class="mb-2">
                    Titulo
                </x-label>
                <x-input wire:model="post.title" x-model="title" class="w-full" placeholder="Ingrese el titulo del post" />
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Slug
                </x-label>
                <x-input wire:model="post.slug" x-model="slug" class="w-full" placeholder="Ingrese el slug del post" />
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
                <x-select class="w-full" wire:model.live="post.subcategory_id">
                    <option value="" disabled>Seleccione una subcategoria</option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </x-select>
            </div>
        </div>

        <div class="flex justify-end">
            <x-button>
                Crear Post
            </x-button>
        </div>

    </form>

    @push('js')
    <script>
        function data(){
            return {
                title:'',
                slug:'',
                string_to_slug(str){
                    str = str.replace(/^\s+|\s+$/g, '');
                        str = str.toLowerCase();
                        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
                        var to = "aaaaeeeeiiiioooouuuunc------";
                        for (var i = 0, l = from.length; i < l; i++) {
                            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                        }
                        str = str.replace(/[^a-z0-9 -]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                        this.slug = str;
                }
            }
        }
    </script>
@endpush
</div>
