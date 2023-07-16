<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EcomSettingComponent extends Component
{
    public $email, $contact, $address;
    public $sosmedFb, $sosmedTw, $sosmedLi;
    public $confirm, $pass_confirm;

    public function mount() {
        $content = Storage::get(HalperFunctions::colName('ecom_set'));
        $datas = explode(PHP_EOL, $content);
        $data_json = json_decode($datas[0]);

        $this->email = $data_json->email;
        $this->contact = $data_json->contact;
        $this->address = $data_json->address;
        $this->sosmedFb = $data_json->sosmed->sosmed1->url;
        $this->sosmedTw = $data_json->sosmed->sosmed2->url;
        $this->sosmedLi = $data_json->sosmed->sosmed3->url;
    }

    public function updated($fields) {
        $this->validateOnly($fields, [
            'pass_confirm' => 'required',
        ]);
    }
    
    public function saveChangeInfo() {
        $this->validate([
            'pass_confirm' => 'required',
        ]);

        $dataInfo = [
            "email" => $this->email,
            "contact" => $this->contact,
            "address" => $this->address,
            "sosmed" => [
                "sosmed1" => [
                    "name" => "facebook",
                    "url" => $this->sosmedFb
                ],
                "sosmed2" => [
                    "name" => "twitter",
                    "url" => $this->sosmedTw
                ],
                "sosmed3" => [
                    "name" => "linkedin",
                    "url" => $this->sosmedLi
                ],
            ],
            "last_updated" => now(),
            "update_by" => Auth::user()->email,
        ];

        Storage::put(HalperFunctions::colName('ecom_set'), json_encode($dataInfo));
        
        session()->flash('msgAlert', 'Information ecommerce successful save');
        session()->flash('msgStatus', 'Success');
    }

    public function getDataStorage() {
        $content = Storage::get(HalperFunctions::colName('ecom_set'));
        $datas = explode(PHP_EOL, $content);
        $data_json = json_decode($datas[0]);
    }

    public function render()
    {
        return view('livewire.admin.ecom-setting-component')->layout('layouts.admin');
    }
}
