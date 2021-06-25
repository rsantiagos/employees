<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Employee::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'last_name' => 'required',
            'dni' => 'required',
            'birthdate' => 'required',
            'address' => 'required',
            'picture' => 'required',
            'email' => 'required',
            'password' => 'required',
            'jobPosition_id' => 'required',
            'entity_name' => 'required',
            'entity_identifier' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error de validación', $validator->errors());
        }

        return Employee::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Employee::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkEmail(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'last_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error de validación', $validator->errors());
        }

        $last_name = str_split($input['last_name']);
        $email = $input['name'].$input['last_name'].'@test.com.mx';
        foreach ($last_name as $value) {
            $email = $input['name'].$value.'@test.com';
            $verify = User::where('email', '=', $email)->first();
            if (!$verify) {
                break;
            }
        }

        $response = [
            'email' => $email
        ];
        return response()->json($response, 200);
    }
}
