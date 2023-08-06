<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Voucher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;

class VoucherComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $code, $type, $value, $max_value_percent, $exp_date, $keterangan;
    public $product_discont, $min_cart, $for_product, $image;
    public $countShowVoucher = 8;
    public $idForUpdate, $idForDelete, $viewImage, $newimage;
    public $pass_confirm;

    public function updated($fields){
        $rules = [
            'code' => 'required|unique:vouchers,code',
            'type' => 'required',
            'exp_date' => 'required',
            'value' => 'required',
        ];

        if ($this->type === 'percent') {
            $rules['value'] .= '|numeric|min:1|max:100';
            $rules['max_value_percent'] = 'required';
        }

        $this->validateOnly($fields, $rules);
    }

    public function reselFormValue(){
        $this->code = null;
        $this->type = null;
        $this->value = null;
        $this->max_value_percent = null;
        $this->exp_date = null;
        $this->keterangan = null;
        $this->product_discont = null;
        $this->min_cart = null;
        $this->for_product = null;
        $this->image = null;

        $this->idForUpdate = null;
        $this->idForDelete = null;
        $this->viewImage = null;
        $this->newimage = null;
        $this->pass_confirm = null;
    }

    public function resetImageVal() {
        $this->image = null;
    }

    public function saveNewVoucher(){
        $rules = [
            'code' => 'required|unique:vouchers,code',
            'type' => 'required',
            'exp_date' => 'required',
            'value' => 'required',
        ];

        if ($this->type === 'percent') {
            $rules['value'] .= '|numeric|min:1|max:100';
            $rules['max_value_percent'] = 'required';
        }

        $this->validate($rules);

        HalperFunctions::SaveWithTransaction(
            function() {
                $uniqImage = Carbon::now()->timestamp . Str::random(6);
                $imageName = $this->image && $uniqImage . '.' . $this->image->extension();
                
                $voucher = new Voucher;
                $voucher->code = $this->code;
                $voucher->type = $this->type;
                $voucher->value = HalperFunctions::currencyToNumber($this->value);
                $voucher->max_value_percent = $this->max_value_percent ? HalperFunctions::currencyToNumber($this->max_value_percent) : null;
                $voucher->exp_date = $this->exp_date;
                $voucher->keterangan = $this->keterangan;
                $voucher->product_discont = $this->product_discont ?? false;
                $voucher->min_cart = $this->min_cart ? HalperFunctions::currencyToNumber($this->min_cart) : null;
                $voucher->for_product = $this->for_product ?? null;
                $voucher->image = $this->image ? $imageName : null;
                $voucher->save();
        
                if($this->image){
                    $folderName = HalperFunctions::colName('vc');
                    $checkCurrentPath = storage_path('app/'. $folderName);
                    $existCurrentPath = file_exists($checkCurrentPath);
                    $this->image->storeAs($folderName, $imageName);
                    if (!$existCurrentPath){
                        HalperFunctions::desiredPermissions($checkCurrentPath);
                    }
                }
        
                session()->flash('msgAlert', 'Voucher baru telah berhasil ditambahkan');
                session()->flash('msgStatus', 'Success');
                
                $this->dispatchBrowserEvent('close-form-modal');
                $this->reselFormValue();
            },
            "saveNewVoucher"
        );
    }

    public function openModalEdit($id){
        $this->idForUpdate = $id;
        $voucher = Voucher::find($id);
        $this->code = $voucher->code;
        $this->type = $voucher->type;
        $this->value = $voucher->value;
        $this->max_value_percent = $voucher->max_value_percent;
        $this->exp_date = $voucher->exp_date;
        $this->keterangan = $voucher->keterangan;
        $this->product_discont = $voucher->product_discont;
        $this->min_cart = $voucher->min_cart;
        $this->for_product = $voucher->for_product;
        $this->viewImage = $voucher->image;
        
        $this->dispatchBrowserEvent('open-edit-modal');
    }

    public function updateVoucher(){
        HalperFunctions::SaveWithTransaction(
            function(){
                $auth = Auth::user();
                $folderName = HalperFunctions::colName('vc');
                $imageName;
                $voucher = Voucher::find($this->idForUpdate);
                $voucher->code = $this->code;
                $voucher->type = $this->type;
                $voucher->value = HalperFunctions::currencyToNumber($this->value);
                $voucher->max_value_percent = $this->max_value_percent ? HalperFunctions::currencyToNumber($this->max_value_percent) : null;
                $voucher->exp_date = $this->exp_date;
                $voucher->keterangan = $this->keterangan;
                $voucher->product_discont = $this->product_discont ? $this->product_discont : false;
                $voucher->min_cart = $this->min_cart ? HalperFunctions::currencyToNumber($this->min_cart) : null;
                $voucher->for_product = $this->for_product ? $this->for_product : null;
                if($this->newimage){
                    Storage::delete($folderName . $voucher->image);
                    $imageName = Carbon::now()->timestamp. '.' . $this->newimage->extension();
                    $voucher->image = $imageName;
                }
                $voucher->save();
                
                if($this->newimage){
                    $this->newimage->storseAs($folderName, $imageName);
                }

                $this->dispatchBrowserEvent('close-form-modal');
                session()->flash('msgAlert', 'Voucher telah berhasil diperhaharui');
                session()->flash('msgStatus', 'Success');
            },
            "updateVoucher"
        );
    }
    
    public function activeInActiveVoucher($id, $action) {
        $throttleKey = request()->ip() . "activeInActiveVoucher" . $id;
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 5, 2);
        if (!$rateLimitNotExceeded) return;

        $flag_active = $action == 1 ? false : true;
        $voucher = Voucher::find($id);
        if($voucher){
            $voucher->flag_active = $flag_active;
            $voucher->save();
    
            $status = $flag_active ? 'Aktifkan' : 'NonAktifkan';
            session()->flash('msgAlert', 'Voucher telah berhasil di ' . $status);
            session()->flash('msgStatus', 'Success');
        }else{
            session()->flash('msgAlert', 'Update gagal! Voucher tidak ditemukan');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function deleteVoucherModal($id){
        $this->idForDelete = $id;
    }
    public function clearConfirmPass(){
        $this->idForDelete = null;
        $this->pass_confirm = null;
    }
    public function executeDeleteConfirm(){
        $throttleKey = request()->ip() . "executeDeleteConfirm" . $this->idForDelete;
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 3, 2);
        if (!$rateLimitNotExceeded) return;

        $userLogin = Auth::user();
        if(Hash::check($this->pass_confirm, $userLogin->password)){
            HalperFunctions::SaveWithTransaction(
                function() {
                    $voucher = Voucher::find($this->idForDelete);
                    if($voucher->image) Storage::delete(HalperFunctions::colName('vc') . $voucher->image);
                    
                    $voucher->delete();
    
                    $this->dispatchBrowserEvent('close-form-modal');
                    session()->flash('msgAlert', 'Voucher telah berhasil dihapus');
                    session()->flash('msgStatus', 'Success');
                },
                "executeDeleteConfirm"
            );
        }else{
            session()->flash('msgAlert', 'Your password information incorrect');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function copyToClipboard($text){
        $this->dispatchBrowserEvent('hit-function-copy', ["code" => $text]);

        session()->flash('msgAlert', 'Voucher telah berhasil disalin');
        session()->flash('msgStatus', 'Success');
    }

    public function loadAddData(){
        $allVoucher = Voucher::paginate($this->countShowVoucher);

        return [
            'allVoucher' => $allVoucher,
        ];
    }
    
    public function render()
    {
        return view('livewire.admin.voucher-component', $this->loadAddData())->layout('layouts.admin');
    }
}
