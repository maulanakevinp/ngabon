<?php

namespace App\Http\Controllers;

use App\Http\Resources\PegawaiCollection;
use App\Http\Resources\PegawaiResource;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PegawaiCollection(Pegawai::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama'          => ['required','string','max:10','unique:pegawai,nama'],
            'tanggal_masuk' => ['required','date','before:now'],
            'total_gaji'    => ['required','numeric','min:4000000','max:10000000']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'     => true,
                'message'   => $validator->errors()->all()
            ]);
        }

        $pegawai = Pegawai::create([
            'nama'          => $request->nama,
            'tanggal_masuk' => $request->tanggal_masuk,
            'total_gaji'    => $request->total_gaji,
        ]);

        return new PegawaiResource($pegawai);
    }
}
