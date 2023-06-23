<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
    public $idForDelete, $idForUpdate;

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
        $this->idForUpdate = null;
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

        try{
            $category = new Category;
            $category->code = Str::random(6);
            $category->name = $this->name;
            $imageName = Carbon::now()->timestamp. '.' . $this->image->extension();
            $category->image = $imageName;
            $category->created_by = Auth::user()->email;
            $category->save();
            $this->image->storeAs(HalperFunctions::colName('ct'), $imageName);
    
            $this->dispatchBrowserEvent('close-form-modal');
            session()->flash('msgAlert', 'Category baru telah berhasil ditambahkan');
            session()->flash('msgStatus', 'Success');
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            $insertError = HalperFunctions::insertLogError(Auth::user()->email, "saveKagetoriToDb", "POST", $error_msg." | ".$stackTrace);
    
            $this->dispatchBrowserEvent('close-form-modal');
            session()->flash('msgAlert', 'Category gagal disimpan! Error ID: ' . $insertError);
            session()->flash('msgStatus', 'Danger');
        }
    }

    public function openModalEdit($id)
    {
        $this->idForUpdate = $id;
        $category = Category::find($id);
        $this->name = $category->name;
        $this->viewImage = $category->image;
        $this->cat_code = $category->code;
        
        $this->dispatchBrowserEvent('open-edit-modal');
    }

    public function updateCategory(){
        try{
            $imageName;
            $category = Category::find($this->idForUpdate);
            $category->name = $this->name;
            $category->updated_by = Auth::user()->email;
            $category->save();
            if($this->newimage){
                Storage::delete(HalperFunctions::colName('ct') . $category->image);
                $imageName = Carbon::now()->timestamp. '.' . $this->newimage->extension();
                $category->image = $imageName;
            }
            $this->newimage->storseAs(HalperFunctions::colName('ct'), $imageName);

            $this->dispatchBrowserEvent('close-form-modal');
            session()->flash('msgAlert', 'Category telah berhasil diperhaharui');
            session()->flash('msgStatus', 'Success');
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            $insertError = HalperFunctions::insertLogError(Auth::user()->email, "updateCategory", "POST", $error_msg." | ".$stackTrace);
    
            $this->dispatchBrowserEvent('close-form-modal');
            session()->flash('msgAlert', 'Category gagal diperbaharui! Error ID: ' . $insertError);
            session()->flash('msgStatus', 'Danger');
        }
    }

    public function openModalDelete($id){
        $this->idForDelete = $id;
    }
    
    public function deleteCategory()
    {
        try{
            $category = Category::find($this->idForDelete);
            $category->delete();
            Storage::delete(HalperFunctions::colName('ct') . $category->image);
    
            $this->dispatchBrowserEvent('close-form-modal');
            session()->flash('msgAlert', 'Category telah berhasil dihapus');
            session()->flash('msgStatus', 'Success');
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            $insertError = HalperFunctions::insertLogError(Auth::user()->email, "deleteCategory", "DELETE", $error_msg." | ".$stackTrace);
    
            $this->dispatchBrowserEvent('close-form-modal');
            session()->flash('msgAlert', 'Category gagal dihapus! Error ID: ' . $insertError);
            session()->flash('msgStatus', 'Danger');
        }
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
