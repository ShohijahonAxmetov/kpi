<?php

namespace App\Http\Controllers\admin\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Certificate\CertificateLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CertificateLanguageController extends Controller
{
    protected $title = 'Языки сертификата иностранных языков';
    protected $route_name = 'lang_certificate_langs';
    protected $route_parameter = 'lang_certificate_lang';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = CertificateLanguage::orderBy('name')
            ->paginate(12);

        return view('app.lang_certificates_langs.index', [
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
        return view('app.lang_certificates_langs.create', [
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

        CertificateLanguage::create($data);

        return redirect()->route($this->route_name . '.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LangCertificateLang  $langCertificateLang
     * @return \Illuminate\Http\Response
     */
    public function show(CertificateLanguage $langCertificateLang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LangCertificateLang  $langCertificateLang
     * @return \Illuminate\Http\Response
     */
    public function edit(CertificateLanguage $langCertificateLang)
    {
        return view('app.lang_certificates_langs.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'lang_certificate_lang' => $langCertificateLang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LangCertificateLang  $langCertificateLang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertificateLanguage $langCertificateLang)
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

        $langCertificateLang->update($data);

        return redirect()->route($this->route_name.'.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LangCertificateLang  $langCertificateLang
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertificateLanguage $langCertificateLang)
    {
        //
    }
}
