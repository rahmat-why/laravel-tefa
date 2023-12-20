<?php

namespace App\Http\Controllers;

use App\Models\MsVehicle;
use App\Models\TrsBooking;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = MsVehicle::where('id_customer', auth()->user()->id_customer)
            ->whereIn('classify',['MOBIL','MOTOR'])
            ->orderBy('type', 'ASC')
            ->get();
        
        return view('Vehicle.index', compact('vehicles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Vehicle.Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data agar tidak boleh kosong
        $request->validate([
            'type' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'classify' => 'required|regex:/^[A-Za-z0-9]+$/',
            'police_number' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'color' => 'required|regex:/^[A-Za-z ]+$/',
            'year' => 'required|numeric',
            'vehicle_owner' => 'required|regex:/^[A-Za-z ]+$/',
        ], [
            'type.required' => 'Tipe wajib diisi.',
            'type.regex' => 'Tipe harus mengandung huruf, angka, dan spasi saja.',
            'classify.required' => 'Klasifikasi wajib diisi.',
            'classify.regex' => 'Klasifikasi harus mengandung huruf dan angka saja.',
            'police_number.required' => 'Nomor Polisi wajib diisi.',
            'police_number.regex' => 'Nomor Polisi harus mengandung huruf dan angka saja.',
            'color.required' => 'Warna wajib diisi.',
            'color.regex' => 'Warna harus mengandung huruf dan spasi saja.',
            'year.required' => 'Tahun wajib diisi.',
            'year.numeric' => 'Tahun harus mengandung angka saja.',
            'vehicle_owner.required' => 'Pemilik Kendaraan wajib diisi.',
            'vehicle_owner.regex' => 'Pemilik Kendaraan harus mengandung huruf dan spasi saja.',
        ]);
    
        // Automatically assign id_customer based on the authenticated user
        $request->merge(['id_customer' => auth()->user()->id_customer]);
    
        // Generate the next id_vehicle
        $count_vehicle = MsVehicle::count();
        $autoid = $count_vehicle+1;
        $request->merge(['id_vehicle' => 'VC' . $autoid]);
    
        // Simpan data ke dalam database setelah validasi
        MsVehicle::create($request->all());
    
        // Redirect ke halaman yang diinginkan setelah data disimpan
        return redirect()->route('Vehicle.Index')->with('successMessage', 'Kendaraan berhasil disimpan!');
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
    public function edit($id_vehicle)
    {
        $vehicle = MsVehicle::findOrFail($id_vehicle);
        return view('Vehicle.edit', ['vehicle' => $vehicle]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_vehicle)
    {
        // Validasi data agar tidak boleh kosong
        $request->validate([
            'type' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'classify' => 'required|regex:/^[A-Za-z0-9]+$/',
            'police_number' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'color' => 'required|regex:/^[A-Za-z ]+$/',
            'year' => 'required|numeric',
            'vehicle_owner' => 'required|regex:/^[A-Za-z ]+$/',
        ], [
            'type.required' => 'Tipe wajib diisi.',
            'type.regex' => 'Tipe harus mengandung huruf, angka, dan spasi saja.',
            'classify.required' => 'Klasifikasi wajib diisi.',
            'classify.regex' => 'Klasifikasi harus mengandung huruf dan angka saja.',
            'police_number.required' => 'Nomor Polisi wajib diisi.',
            'police_number.regex' => 'Nomor Polisi harus mengandung huruf dan angka saja.',
            'color.required' => 'Warna wajib diisi.',
            'color.regex' => 'Warna harus mengandung huruf dan spasi saja.',
            'year.required' => 'Tahun wajib diisi.',
            'year.numeric' => 'Tahun harus mengandung angka saja.',
            'vehicle_owner.required' => 'Pemilik Kendaraan wajib diisi.',
            'vehicle_owner.regex' => 'Pemilik Kendaraan harus mengandung huruf dan spasi saja.',
        ]);
        // Ambil data yang diterima dari formulir
        $data = $request->all();
    
        // Ambil data kendaraan berdasarkan $id_vehicle
        $vehicle = MsVehicle::findOrFail($id_vehicle);
    
        // Pastikan id_vehicle dan id_customer tidak dapat diubah
        $data['id_vehicle'] = $vehicle->id_vehicle;
        $data['id_customer'] = $vehicle->id_customer;
    
            $vehicle->update($data);
            return redirect(route('Vehicle.Index'))->with('successMessage', 'Kendaraan berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_vehicle)
    {
        $vehicle = MsVehicle::findOrFail($id_vehicle);
        $vehicle->update(['classify'=>'nonaktif']);
        
        return redirect()->route('Vehicle.Index')->with('successMessage', 'Data berhasil dihapus!');
    }
    public function showHistory($id_vehicle)
    {
        $vehicle = MsVehicle::findOrFail($id_vehicle);
        return view('vehicle.history', ['vehicle' => $vehicle]);
    }
}
