<?php

namespace App\Http\Controllers\Blog\Admin;

use Illuminate\Http\Request;
use App\Models\BlogCategory;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $item = BlogCategory::find($id);
        //$item = BlogCategory::where('id', '=', $id)->first();
        $item = BlogCategory::findOrfail($id);//if not return 404

        $categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
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
        // dd(__METHOD__, $request->all(), $id);

        $rules = [
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'string|max:500|min:3',
            'parent_id' => 'required|integer|exists:blog_categories,id',
        ];

        // 3 способа валидации:
        // 1)
        // $validateData = $this->validate($request, $rules); //валидация с помошью объекта контроллера
        // 2)
        // $validateData = $request->validate($rules); //валидация с помошью объекта Request
        // 3)
        /*$validator = \Validator::make($request->all(), $rules);//валидация с помошью объекта Validator
        $validateData[] = $validator->passes();//без редиректа если ошибка то false (true если все хорошо)
        $validateData[] = $validator->validate(); // редирект обратно если ошибка
        $validateData[] = $validator->valid(); //все валидные данные
        $validateData[] = $validator->failed();//не валидные данные
        $validateData[] = $validator->errors();// все сообщения с ошибками
        $validateData[] = $validator->fails();// если ошибка то вернет true (false если все хорошо)
        */
        

        $item = BlogCategory::find($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        $result = $item
            ->fill($data)//обновляем свойства объекта
            ->save();//сохраняем их в базу

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => "Ошибка сохранения"])
                ->withInput();
        }
    }
}
