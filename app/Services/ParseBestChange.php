<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;  
use GuzzleHttp\Client;
use ZipArchive;

class ParseBestChange 
{

    const FILENAME = 'info.zip';
    const LOCAL_DIR = 'courses';   

    public static function handle(){
        $res = self::download();    
        if ($res) {
            self::extract(); 
            self::findBestRates(); 
        }
    }

    public static function download(){
        $res = false;
        $url = config('app.bestchange_api') . 'info.zip';           
        $valid_types = ['zip'];
        $client = new Client(); 
        try {  
            $response = $client->get($url);
            if (isset($response->getHeaders()['Content-Type']) && isset($response->getHeaders()['Content-Type'][0]) && $response->getHeaders()['Content-Type'][0] == 'application/zip') {    
                Log::info('Downloading file');     
                Storage::disk('local')->put(self::LOCAL_DIR . '/' . self::FILENAME, $response->getBody()->getContents());
                $res = true;
            } else {
                throw new \Exception('Remote file not found'); 
            }        
        } catch (\Exception $e) {    
            Log::error('Remote file not downloaded');         
        }
        return $res;            
    } 


    public static function extract(){
        $zip = new ZipArchive();
        $status = $zip->open(Storage::disk('local')->path(self::LOCAL_DIR . '/' . self::FILENAME));
        if ($status !== true) {  
         throw new \Exception($status);  
        }
        else {
            $storageDestinationPath= storage_path('app/' . self::LOCAL_DIR . '/unzip/');
       
            if (!\File::exists( $storageDestinationPath)) {
                \File::makeDirectory($storageDestinationPath, 0755, true);
            }
            $zip->extractTo($storageDestinationPath);
            $zip->close();
        }  
    }

    public function findBestRates() {
        $storageDestinationPath = Storage::disk('local')->path(self::LOCAL_DIR . '/unzip/bm_rates.dat');
        if (\File::exists( $storageDestinationPath)) {
            $file = fopen(, "r");
            while(!feof($file)) {
                $info = explode(';', fgets($file));   
                Log::info(implode(' ', $info));           
            }    

            fclose($file);
        }
    }
    
}
