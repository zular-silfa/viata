<?php

namespace App\Http\Controllers;

use App\Models\Perawatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerawatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perawatan = Perawatan::all();
        return view('perawatan.index', [
            'perawatan' => $perawatan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perawatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fotokucing');
            $data['foto'] = $path;
        }

        $perawatan = Perawatan::create($data);
        return redirect()->route('perawatan.index')->with('success_message', ' Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perawatan = Perawatan::find($id);
        if (!$perawatan) return redirect()->route('perawatan.index')
            ->with('error_message', 'Perawatan dengan id' . $id . 'tidak ditemukan');
        return view('perawatan.edit', [
            'perawatan' => $perawatan
        ]);
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
        $data = $request->all();
        $perawatan = Perawatan::find($id);

        if ($request->has('foto')) {
            $data['foto'] = $request->file('foto')->store('fotokucing');
        }
        $perawatan->update($data);
        return redirect()->route('perawatan.index')
            ->with('success_message', 'Berhasil mengubah Perawatan Kucing');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perawatan = Perawatan::find($id);
        $perawatan->delete();
        return redirect()->route('perawatan.index')
            ->with('success_message', 'Data perawatan berhasil dihapus');
    }
}
