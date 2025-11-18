<?php

namespace App\Http\Controllers\admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificatePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CertificatePointController extends Controller
{
    protected $title = 'Степени сертификата иностранных языков';
    protected $route_name = 'certificate_points';
    protected $route_parameter = 'certificate_point';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = CertificatePoint::orderBy('name')
            ->paginate(12);

        return view('app.certificate_points.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.certificate_points.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
        ]);
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

        $validator = Validator::make($data, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        CertificatePoint::create($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function show(CertificatePoint $certificatePoint)
    {
        //
    }

    public function edit(CertificatePoint $certificatePoint)
    {
        return view('app.certificate_points.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'certificate_point' => $certificatePoint,
        ]);
    }

    public function update(Request $request, CertificatePoint $certificatePoint)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        $certificatePoint->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    public function destroy(CertificatePoint $certificatePoint)
    {
        //
    }
}
