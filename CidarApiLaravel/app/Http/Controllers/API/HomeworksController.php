<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Homeworks;

class HomeworksController extends Controller
{
    //
    public function index(Homeworks $homeworks){
        $homeworks = $homeworks::with('student')->get();

        return CustomResponse::success("Homeworks Get Successfully", $homeworks);
    }
    public function store(Request $request){

        $validate = Validator::make($request->only([
            'title',
            'description',
            'qualification',
            'student_id'
        ]),[
            'title' => 'required|string',
            'description' => 'required|string',
            'qualification' => 'required|integer',
            'student_id' => 'required|integer|exists:students,id'
        ]);

        if ($validate->fails()) {
            return CustomResponse::error('Error al validar', $validate->errors());
        }

        try{

        	$homework = DB::transaction(function() use($request){
        		//

        		$homework = Homeworks::create( $request->only([
                    'title',
                    'description',
                    'qualification',
                    'student_id'
                ]));

        		return compact('homework');

        	});

        	return CustomResponse::success('Homework created successfuly', $homework);

        }catch(\Exception $exception){

        	return CustomResponse::error('An Error Exist Imposible to Create', $exception->getMessage());
        }
    }

    public function update(Request $request, $id){

        $validate = Validator::make($request->only([
            'title',
            'description',
            'qualification',
            'student_id'
        ]),[
            'title' => 'required|string',
            'description' => 'required|string',
            'qualification' => 'required|integer',
            'student_id' => 'required|integer|exists:students,id'
        ]);

        if ($validate->fails()) {
            return CustomResponse::error('Error al validar', $validate->errors());
        }

        try{

        	$homework = DB::transaction(function() use($request, $id){
        		//
                $homework = Homeworks::where('id',$id)->first();
        		$homework->update( $request->only([
                    'title',
                    'description',
                    'qualification',
                    'student_id'
                ]));

        		return compact('homework');

        	});

        	return CustomResponse::success('Homework updated successfully', $homework);

        }catch(\Exception $exception){

        	return CustomResponse::error('An Error Exist Imposible to Update', $exception->getMessage());
        }
    }

    public function destroy(Request $request, $id){

    	try{

    		$homework_to_delete = DB::transaction(function() use($request, $id){

        		$homework = Homeworks::where('id',$id)->first();

                $homework->delete();

        		return compact('homework');
        	});

        	return CustomResponse::success('Homework de activate successfully', $homework_to_delete);

    	}catch(\Exception $exception){
    		
    		return CustomResponse::error('An Error Exist Imposible to Delete', $exception->getMessage());
    	}

    }
}
