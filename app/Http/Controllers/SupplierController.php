<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $title = 'Index Supplier';

        return view('supplier.index', compact('title', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tambah Supplier';
        return view('supplier.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'phone' => 'required|min:10|max:15',
            'address' => 'required'
        ]);

        $data = Supplier::create([
            'name' => $request->name,
            'slug'=> \Str::slug($request->name, '-'),
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        \Session::flash('success', 'Berhasil menambahkan data.');

        return redirect(route('supplier.index'));
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
        $supplier = Supplier::findOrFail($id);
        $title = 'Supplier Edit';

        return view('supplier.edit', compact('supplier', 'title'));
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

        $this->validate($request, [
            'name' => 'required|min:3',
            'phone' => 'required|min:10|max:15',
            'address' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        ];

        $supplier = Supplier::findOrFail($id)->update($data);

        \Session::flash('success', 'Berhasil mengupdate data.');

        return redirect(route('supplier.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            \Session::flash('success', 'Berhasil menghapus data.');
        }catch (Exception $e) {
            \Session::flash('error', 'Gagal menghapus data' . $e->getMessage());
        }

        return redirect(route('supplier.index'));
    }
}
