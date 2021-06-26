<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $per_page = \Request::get('per_page') ?: 5;
        $employees = Employee::paginate($per_page);
        $employees->map(function ($e) {
           $e->picture = env('APP_URL') . $e->picture;
           $e->user;
        });
        return $employees;
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
            'photo'   => ['image', 'max:20000|dimensions:max_width=1000,max_height=1000'],
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

        $file = $request->file('photo');
        $name =  uniqid() . '.' . $file->extension();
        $urlImage = '/images/avatars/';
        $request->photo->move(public_path($urlImage), $name);
        $input['picture'] = $urlImage.$name;


        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $e = new Employee();
        $e->name = $input['name'];
        $e->last_name = $input['last_name'];
        $e->dni = $input['dni'];
        $e->birthdate = $input['birthdate'];
        $e->address = $input['address'];
        $e->picture = $input['picture'];
        $e->user_id = $user['id'];
        $e->save();
        $e->picture = env('APP_URL') . $e->picture;
        return $e;
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

        $last_name = str_split(str_replace(' ', '', $input['last_name']));
        $email = str_replace(' ', '', $input['name']).$input['last_name'].'@test.com.mx';
        $prefix = '';
        foreach ($last_name as $value) {
            $prefix .= $value;
            $email = str_replace(' ', '', $input['name']).$prefix.'@test.com';
            $verify = User::where('email', '=', $email)->first();
            if (!$verify) {
                break;
            }
        }

        $response = [
            'email' => strtolower($email)
        ];
        return response()->json($response, 200);
    }
}
