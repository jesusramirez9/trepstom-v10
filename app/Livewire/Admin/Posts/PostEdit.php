<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Http\Request;
class PostEdit extends Component
{
    public $post;
    public $postEdit;

    public $families;
    public $family_id = '';
    public $category_id = '';
    public $published = '';
    public $image;
    public $tags;
    public $tagsselect;

    public function mount($post){
       
      
        $this->postEdit = $post->only('title', 'slug', 'body', 'excerpt', 'image_path', 'published', 'subcategory_id', 'published_at', 'user_id');
        $this->families = Family::all();
        $this->category_id = $post->subcategory->category->id;
      
       $this->family_id = $post->subcategory->category->family_id;

       $this->tags = Tag::all();
     
    }

    public function boot(){
        $this->withValidator(function ($validador){
            if ($validador->fails()) {
                $this->dispatch('swal',[
                    'icon' => 'error',
                    'title' => 'error',
                    'text' => 'El formulario contiene errores'
                ]);
            }
        });
    }

    public function updatedFamilyId($value){
        $this->category_id = '';
        $this->postEdit['subcategory_id'] = '';
    }

    public function updatedCategoryId($value){
    
        $this->postEdit['subcategory_id'] = '';
    }

    
    #[Computed()]
    public function categories(){
        return Category::where('family_id', $this->family_id)->get();
    }

    #[Computed()]
    public function subcategories(){
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    #[On('variants-generate')]
    public function updatedProduct(){
        $this->post = $this->post->fresh();
    }

    public function store(Request $request){

    //    dd($request->all());

       

        // $this->validate([
          
        //   'image' => 'nullable|image|max:1024',
        //   'productEdit.sku' => 'required|unique:products,sku,'.$this->product->id,
        //   'productEdit.name' => 'required|max:255',
        //   'productEdit.description' => 'nullable',
        //   'productEdit.price' => 'required|numeric|min:0',
        //   'productEdit.stock' => 'required|numeric|min:0',
        //   'productEdit.subcategory_id' => 'required|exists:subcategories,id',
        // ],[],[
        //   'image' => 'imagen',
        //   'productEdit.sku' => 'codigo',
        //   'productEdit.name' => 'nombre',
        //   'productEdit.description' => 'descripcion',
        //   'productEdit.price' => 'precio',
        //   'productEdit.subcategory_id' => 'subcategoria',
        // ]);

        $this->post->tags()->sync($this->tagsselect);

        if ($this->image) {
            Storage::delete($this->postEdit['image_path']);
            $this->postEdit = $this->image->store('posts');
        }
        
        if ($this->postEdit['published'] && !$this->postEdit['published_at'] ) {
            $this->postEdit['published_at'] = now();
        }


        $this->post->update($this->postEdit);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Articulo actualizado correctamente.',
    
        ]);
    
          return redirect()->route('admin.posts.edit', $this->post);
  
  
      }
  
  

    public function render()
    {
        return view('livewire.admin.posts.post-edit');
    }
}
