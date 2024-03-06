<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Family;
use App\Models\Post;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;

use Livewire\WithFileUploads;

class PostCreate extends Component
{

    use WithFileUploads;

    public $families;
    public $family_id = '';
    public $category_id = '';

    public $image;

    public $post = [
        'title' => '',
        'slug' => '',   
        'image_path' => '',
        'subcategory_id' => '',
        'user_id' => '',
    ];

    public function mount(){
        $this->families = Family::all();
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
        $this->post['subcategory_id'] = '';
    }

    public function updatedCategoryId($value){
    
        $this->post['subcategory_id'] = '';
    }

    #[Computed()]
    public function categories(){
        return Category::where('family_id', $this->family_id)->get();
    }

    #[Computed()]
    public function subcategories(){
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function store(){

    //   $this->validate([
        
    //     'image' => 'required|image|max:1024',
    //     'post.sku' => 'required|unique:posts,sku',
    //     'post.name' => 'required|max:255',
    //     'post.description' => 'nullable',
    //     'post.price' => 'required|numeric|min:0',
    //     'post.subcategory_id' => 'required|exists:subcategories,id',
    //   ],[],[
    //     'image' => 'imagen',
    //     'post.sku' => 'codigo',
    //     'post.name' => 'nombre',
    //     'post.description' => 'descripcion',
    //     'post.price' => 'precio',
    //     'post.subcategory_id' => 'subcategoria',
    //   ]);

  
    $this->post['user_id'] = auth()->id();

      $this->post['image_path'] = $this->image->store('posts');
     
  
      $post = Post::create($this->post);

      session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡Bien hecho!',
        'text' => 'Articulo creado correctamente.',

    ]);

      return redirect()->route('admin.posts.edit', $post);

    }


    public function render()
    {
        return view('livewire.admin.posts.post-create');
    }
}
