<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Facades\DB;
use App\Models\Language;

class LanguageController extends Controller
{
    public function language_line()
    {

        $languageLines = LanguageLine::all();

        return view('admin.language.language_line')->with('languageLines', $languageLines);
    }

    public function language_line_add()
    {
        return view('admin.language.language_line_add');
    }

    public function post_language_line_add(Request $request)
    {
        LanguageLine::create([
            'group' => $request->group,
            'key' => $request->key,
            'text' => ['vi' => $request->input('text-vi'), 'en' => $request->input('text-en'), 'fr' => $request->input('text-fr')],
        ]);
        return back();
    }
    //ngôn ngữ
    public function language()
    {
        $languages = Language::all();
        return view('admin.language.language', ['languages' => $languages]);
    }
    public function language_add()
    {
        $languages = Language::all();
        return view('admin.language.language_add', ['languages' => $languages]);
    }

    public function post_language_add(Request $request)
    {
        $language = Language::all();

        $lang = new Language;

        foreach ($language as $abbr) {
            $lang->setTranslation('name', $abbr->abbr, $request->input('language_' . $abbr->abbr));
        }
        $lang->native = $request->input('language_en');
        $lang->active = 1;
        $lang->default = 1;
        $lang->abbr = mb_strtolower(mb_substr($request->input('language_en'), 0, 2));
        $lang->save();

        return redirect()->back();
    }

    public function language_update($id)
    {
        $language = Language::find($id);
        $languages = Language::all();
        return view('admin.language.language_update', ['languages' => $languages, 'language' => $language]);
    }

    public function post_language_update(Request $request, $id)
    {
        $language = Language::find($id);
        $languages = Language::all();
        foreach ($languages as $abbr) {
            $language->setTranslation('name', $abbr->abbr, $request->input('language_' . $abbr->abbr));
        }
        $language->native = $request->input('language_en');
        $language->abbr = mb_strtolower(mb_substr($request->input('language_en'), 0, 2));
        $language->save();

        return redirect()->back();
    }

    public function language_line_update($id){
        $language_line=LanguageLine::find($id);
        $languages = Language::all();
        return view('admin.language.language_line_update', ['language'=>$language_line,'languages'=>$languages]);
    }
    public function post_language_line_update(Request $request){
        $language_line=LanguageLine::find($request->id);
        $language_line->text=['vi'=>$request->input('text-vi'),'en'=>$request->input('text-en'),'fr'=>$request->input('text-fr')];
        $language_line->save();
        return redirect()->back();
    }
}
