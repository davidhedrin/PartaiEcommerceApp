<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategoryComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $image, $cat_code, $newimage, $viewImage;
    public $idForDelete;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'image' => 'required',
        ]);
    }

    public function resetFormValue()
    {
        $this->name = null;
        $this->image = null;
        $this->newimage = null;
        $this->viewImage = null;
        $this->cat_code = null;
        $this->idForDelete = null;
    }

    public function resetImageVal()
    {
        $this->image = null;
    }
    
    public function saveKagetoriToDb()
    {
        $this->validate([
            'name' => 'required',
            'image' => 'required',
        ]);

        $category = new Category;
        $category->code = Str::random(6);
        $category->name = $this->name;
        $imageName = Carbon::now()->timestamp. '.' . $this->image->extension();
        $category->image = $imageName;
        $category->save();
        $this->image->storeAs(HalperFunctions::colName('ct'), $imageName);

        $this->dispatchBrowserEvent('close-form-modal');
        session()->flash('msgAlert', 'Category baru telah berhasil ditambahkan');
        session()->flash('msgStatus', 'Success');
    }

    public function openModalEdit($id)
    {
        $category = Category::find($id);
        $this->name = $category->name;
        $this->viewImage = $category->image;
        $this->cat_code = $category->code;
        
        $this->dispatchBrowserEvent('open-edit-modal');
    }

    public function openModalDelete($id){
        $this->idForDelete = $id;
    }
    
    public function deleteCategory()
    {
        $category = Category::find($this->idForDelete);
        Storage::delete(HalperFunctions::colName('ct') . '/' . $category->image);
        $category->delete();

        $this->dispatchBrowserEvent('close-form-modal');
        session()->flash('msgAlert', 'Category telah berhasil dihapus');
        session()->flash('msgStatus', 'Success');
    }

    public function loadAllData()
    {
        $allCategory = Category::all();
        return [
            'allCategory' => $allCategory
        ];
    }

    public function render()
    {
        return view('livewire.admin.category-component', $this->loadAllData())->layout('layouts.admin');
    }
}
