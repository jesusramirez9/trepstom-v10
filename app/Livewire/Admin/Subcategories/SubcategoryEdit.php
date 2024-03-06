<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SubcategoryEdit extends Component
{
    public $families;

    public $subcategory;

    public $subcategoryEdit;

    public function mount($subcategory){

        $this->families = Family::all();

        $this->subcategoryEdit = [
            'family_id' => $subcategory->category->family_id,
            'category_id' => $subcategory->category_id,
            'name' => $subcategory->name
        ];
    }

    public function updatedSubcategoryEditFamilyId(){
        $this->subcategoryEdit['category_id'] = '';
    }

    #[Computed()]
    public function categories(){
        return Category::where('family_id', $this->subcategoryEdit['family_id'])->get();
    }

    public function save(){

        

        $this->validate([
            'subcategoryEdit.family_id' => 'required|exists:families,id',
            'subcategoryEdit.category_id' => 'required|exists:categories,id',
            'subcategoryEdit.name' => 'required',
        ],[],[
            'subcategoryEdit.family_id' => 'familia',
            'subcategoryEdit.category_id' => 'categoria',
            'subcategoryEdit.name' => 'nombre',
        ]);

        Subcategory::create($this->subcategoryEdit);

        // session()->flash('swal', [
        //     'icon' => 'success',
        //     'title' => '¡Bien hecho!',
        //     'text' => 'Subcategoría actualizada correctamente.',

        // ]);

        $this->dispatch('swal',[
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Subcategoría actualizada correctamente.',
        ] );


    }

    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-edit');
    }
}
