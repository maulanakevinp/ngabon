<?php

namespace App\Http\Controllers;

use App\Http\Resources\KasbonCollection;
use App\Http\Resources\KasbonResource;
use App\Models\Kasbon;
use App\Rules\KasbonRule;
use App\Rules\PegawaiRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KasbonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new KasbonCollection(Kasbon::paginate());
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
            'pegawai_id'    => ['required','numeric',new PegawaiRule($request->total_kasbon)],
            'total_kasbon'  => ['required','numeric','min:1000']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'     => true,
                'message'   => $validator->errors()->all()
            ]);
        }

        $kasbon = Kasbon::create([
            'tanggal_diajukan'  => date('Y-m-d'),
            'pegawai_id'        => $request->pegawai_id,
            'total_kasbon'      => $request->total_kasbon,
        ]);

        return new KasbonResource($kasbon);
    }

    public function setujui($id)
    {
        $kasbon = Kasbon::where('id',$id)->where('tanggal_disetujui',null)->first();
        if ($kasbon) {
            $kasbon->update([
                'tanggal_disetujui' => date('Y-m-d')
            ]);
        }
        return new KasbonResource($kasbon);
    }

    public function setujui_masal()
    {
        $i = 0;
        foreach(Kasbon::where('tanggal_disetujui',null)->get() as $kasbon) {
            $kasbon->update([
                'tanggal_disetujui' => date('Y-m-d')
            ]);
            $i++;
        }

        return response()->json([
            'success'   => true,
            'message'   => $i. ' pengajuan kasbon berhasil disetujui secara masal.'
        ]);
    }
}
