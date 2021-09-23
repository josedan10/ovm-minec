<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

use App\Imports\PermitTypeImport;
use App\Models\PermitType;
use App\Models\Requeriment;

class IntoPermitDbController extends Controller
{
    public function readFileXlsx(Request $request){
        
        $collectionPermits = Excel::toArray(new PermitTypeImport, 'permissions_files\CITES_MINEC_Tramites_vs_requisitos_consolidados_y_detallados.xlsx');
        //save permit
        $array=[];
        foreach ($collectionPermits as $collectionPermit[2]) {
            foreach ($collectionPermit as $listPermit) {
                array_push($array, $listPermit[2]);
            }
        }
        foreach ($array as $permit) {
            for ($i=2; $i < 63 ; $i++) { 
                $permitType = new PermitType();
                $permitType->name = $permit[$i];
                $permitType->status = 'active';
                $permitType->departament_id = 1;
                $permitType->save();
            }//return $permit[3];
        }
        $requerimentArray=[];
        foreach($collectionPermits as $collectionPermit){
            for ($j=4; $j <= 54 ; $j++) { 
                array_push($requerimentArray, $collectionPermit[$j]);
            }
        }
    
        foreach ($requerimentArray as $requeriment) {
            for ($i=3; $i < 51 ; $i++) { 
                //return $requeriment[$i];
                $consulta = Requeriment::where('name', '=', $requeriment[$i])->get();
                //return count($consulta);
                if (count($consulta) == 0 && $requeriment[$i] !== NULL) {
                    
                    /*$requeriment = new Requeriment();
                    
                    
                    $requeriment->name =$requeriment[$i];
                    $requeriment->short_name = 'sda';
                    $requeriment->type = 'physical';
                    $requeriment->save();*/
                    //return "no se encontro una coincidencia";

                    Requeriment::create([
                        'name' =>$requeriment[$i],
                        'type' => 'physical'
                    ]);
                }
                
            }
        }

        return "finish Upload data of file .XLSx";
    
    }

    public function showPermitTypes(){
        return PermitType::get();
    }

    public function editPermitType(Request $request, $id){
        
        $permit = PermitType::find($id);
        $permit->name = $request->input('name');
        $permit->Type = $request->input('Type');
        $permit->status = $request->input('status');
        $permit->save();

        $requeriments = $request->only('requeriments');
        $requeriments = json_decode(json_encode($requeriments['requeriments']));

        $requerimentsIds = array_map(function ($requeriment){
            return $requeriment->id;
        }, $requeriments);


        $permit->requeriments()->sync($requerimentsIds);
    }

}
