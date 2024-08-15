<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Empleado;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator as ValidationValidator;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Contracts\Service\Attribute\Required;


class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Illuminate\Http\Response
     */

     public function apiget(){

        $datas=Empleado::all();

        if($datas->isEmpty()){
            $datas=['message'=>'No se encontraron Estudiantes',
                    'status'=>400];
        }

        return response()->json($datas,200);
     }

 
 /*   public function apistore(Request $request)
    {
   
}*/


    public function index()
    {

        
        $datos['empleados']=Empleado::paginate(5);
        return view('empleado.index', $datos);
    
    }    public function consultar($id){
    
        $alldatos=Empleado::find($id);
        response()->json($alldatos);
    
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
    *@param \Illuminate\Http\Request $request
    *@return \Illuminate\Http\Response 
     */
    

    public function store(Request $request)
    {
       // $datosEmpleado = request()->all();

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:10000|mimes:jpeg,png,jpg',

        ];
        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>'La foto requerida',
        ];

        $this->validate($request, $campos,$mensaje);

       $datosEmpleado = request()->except('_token');
       
       if($request->hasfile('Foto')){
        $datosEmpleado['Foto']=$request->file('Foto')->store('uploads', 'public');
       }
       
       Empleado::insert($datosEmpleado);

       //return response()->json($datosEmpleado);
       return  redirect('empleado')->with('mensaje','Empleado Agregado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Models\Empleado $empleado
     * @return \Ilumnate\Http\Response 
     */
    public function edit($id)
    {
        $empleado=Empleado::findOrFail($id);

        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            

        ];
        $mensaje=[
            'required'=>'El :attribute es requerido',
           
        ];

        if($request->hasFile('Foto')){
            $campos=[ 'Foto'=>'required|max:10000|mimes:jpeg,png,jpg', ];
            $mensaje=[ 'Foto.required'=>'La foto requerida' ];
           
        }

        $this->validate($request, $campos,$mensaje);


        $datosEmpleado = request()->except('_token', '_method');
        
         
       if($request->hasfile('Foto')){

        $empleado=Empleado::findOrFail($id);
        
        Storage::delete('public/'.$empleado->Foto);
        
        $datosEmpleado['Foto']=$request->file('Foto')->store('uploads', 'public');
       }

        Empleado::where('id', '=', $id)->update($datosEmpleado);
        $empleado=Empleado::findOrFail($id);
       // return view('empleado.edit', compact('empleado'));
       return  redirect( 'empleado')->with('mensaje', 'Empleado modificado');
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\Empleado $empleado
     * @return \Ilumnate\Http\Response 
     */
    public function destroy($id)
    {


        $empleado=Empleado::findOrFail($id);

        if(Storage::delete('public/'.$empleado->Foto)){

            Empleado::destroy(($id));
        }
        

        return  redirect( 'empleado')->with('mensaje', 'Empleado Borrado');
    }
}
