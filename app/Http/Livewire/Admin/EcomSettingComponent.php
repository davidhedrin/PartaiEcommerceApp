<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EcomSettingComponent extends Component
{
    public $email, $contact, $address;
    public $sosmedFb, $sosmedTw, $sosmedLi;
    public $sosmedFb_status, $sosmedTw_status, $sosmedLi_status;
    public $pass_confirm;

    public function checkUrlAccess($url)
    {
        $result;
        $client = new Client();
        
        try{
            try {
                $response = $client->head($url);
                $result = $response->getStatusCode() == 404 ? false : true;
            } catch (RequestException $e) {
                $statusCode = $e->getResponse()->getStatusCode();
                $result = $statusCode == 404 ? false : true;
            }
        } catch (Exception $e) {
            $statusCode = $e->getCode();
            $result = $statusCode != 404 ? ($statusCode == 0 ? false : true) : false;
        }

        return $result;
    }

    public function mount() {
        $filePath = HalperFunctions::colName('ecom_set');
        if (Storage::exists($filePath)) {
            $content = Storage::get($filePath);
            if (!empty($content)) {
                $datas = explode(PHP_EOL, $content);
                $data_json = json_decode($datas[0]);
        
                $this->email = $data_json->email ?? null;
                $this->contact = $data_json->contact ?? null;
                $this->address = $data_json->address ?? null;
                $this->sosmedFb = $data_json->sosmed[0]->url ?? null;
                $this->sosmedTw = $data_json->sosmed[1]->url ?? null;
                $this->sosmedLi = $data_json->sosmed[2]->url ?? null;
            }
        }
    }

    public function updated($fields) {
        $this->validateOnly($fields, [
            'email' => 'email',
            'contact' => 'numeric',
            'pass_confirm' => 'required',
        ]);
    }

    public function clearConfirmPass() {
        $this->pass_confirm = null;
    }
    
    public function saveChangeInfo() {
        $this->validate([
            'pass_confirm' => 'required',
        ]);

        $userLogin = Auth::user();
        if(Hash::check($this->pass_confirm, $userLogin->password)){
            $dataInfo = [
                "email" => $this->email,
                "contact" => $this->contact,
                "address" => $this->address,
                "sosmed" => array_filter([
                    ($this->sosmedFb) ? [
                        "name" => "facebook",
                        "url" => $this->sosmedFb
                    ] : null,
                    ($this->sosmedTw) ? [
                        "name" => "twitter",
                        "url" => $this->sosmedTw
                    ] : null,
                    ($this->sosmedLi) ? [
                        "name" => "linkedin",
                        "url" => $this->sosmedLi
                    ] : null,
                ], function($value) {
                    return !is_null($value);
                }),
                "last_updated" => now(),
                "update_by" => Auth::user()->email,
            ];
    
            Storage::put(HalperFunctions::colName('ecom_set'), json_encode($dataInfo));
            
            session()->flash('msgAlert', 'Information ecommerce successful save');
            session()->flash('msgStatus', 'Success');

            $this->dispatchBrowserEvent('close-form-modal');
            $this->clearConfirmPass();
        }else{
            session()->flash('msgAlert', 'Your password information incorrect');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function getDataStorage() {
        $content = Storage::get(HalperFunctions::colName('ecom_set'));
        $datas = explode(PHP_EOL, $content);
        $data_json = json_decode($datas[0]);
    }

    public function render()
    {
        $this->sosmedFb_status = $this->sosmedFb ? $this->checkUrlAccess($this->sosmedFb) : false;
        $this->sosmedTw_status = $this->sosmedTw ? $this->checkUrlAccess($this->sosmedTw) : false;
        $this->sosmedLi_status = $this->sosmedLi ? $this->checkUrlAccess($this->sosmedLi) : false;

        return view('livewire.admin.ecom-setting-component')->layout('layouts.admin');
    }
}
