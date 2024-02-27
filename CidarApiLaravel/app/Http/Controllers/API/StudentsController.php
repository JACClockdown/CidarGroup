<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Students;

class StudentsController extends Controller
{
    //
    public function index(Students $students){
        $students = $students::with('homeworks')->get();

        return CustomResponse::success("Students Get Successfully", $students);
    }
    public function store(Request $request){

        $validate = Validator::make($request->only([
            'name',
            'age',
            'enrollment',
            'comment'
        ]),[
            'name' => 'required|string',
            'age' => 'required|integer',
            'enrollment' => 'required|string|unique:students,enrollment',
            'comment' => 'nullable|string'
        ]);

        if ($validate->fails()) {
            return CustomResponse::error('Error al validar', $validate->errors());
        }

        try{

        	$students = DB::transaction(function() use($request){
        		//

        		$students = Students::create( $request->only([
                    'name',
                    'age',
                    'enrollment',
                    'comment'
                ]));

        		return compact('students');

        	});

        	return CustomResponse::success('Student created successfuly', $students);

        }catch(\Exception $exception){

        	return CustomResponse::error('An Error Exist Imposible to Create', $exception->getMessage());
        }
    }

    public function update(Request $request, $id){

        $validate = Validator::make($request->only([
            'name',
            'age',
            'enrollment',
            'comment'
        ]),[
            'name' => 'required|string',
            'age' => 'required|integer',
            'enrollment' => 'required|string',
            'comment' => 'nullable|string'
        ]);

        if ($validate->fails()) {
            return CustomResponse::error('Error al validar', $validate->errors());
        }

        try{

        	$students = DB::transaction(function() use($request, $id){
        		//
                $students = Students::where('id',$id)->first();
        		$students->update( $request->only([
                    'name',
                    'age',
                    'enrollment',
                    'comment'
                ]));

        		return compact('students');

        	});

        	return CustomResponse::success('Student updated successfully', $students);

        }catch(\Exception $exception){

        	return CustomResponse::error('An Error Exist Imposible to Update', $exception->getMessage());
        }
    }

    public function destroy(Request $request, $id){

    	try{

    		$student_to_delete = DB::transaction(function() use($request, $id){

        		$student = Students::where('id',$id)->first();

        		if( $student->homeworks()->exists() ){

                    $student->homeworks()->delete();

                    $student->delete();
                }

                $student->delete();

        		return compact('student');
        	});

        	return CustomResponse::success('Student de activate successfully', $student_to_delete);

    	}catch(\Exception $exception){
    		
    		return CustomResponse::error('An Error Exist Imposible to Delete', $exception->getMessage());
    	}

    }
}
