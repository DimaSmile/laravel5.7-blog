<?php

namespace App\Http\Controllers\Blog\Admin;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(15);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }

        // 2 способа создания объекта модели и записи данных в бд:

        //1) создаст объект но не добавить в бд
        $item = new BlogCategory($data);
        $item->save();//добавит запись в бд

        // 2)создаст объект и добавит его в бд
        // $item = (new BlogCategory())->create($data);

        if ($item) {
            return redirect()
                ->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => "Ошибка сохранения"])
                ->withInput();
        }
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
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        // dd(__METHOD__, $request->all(), $id);

       /*  $rules = [
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'string|max:500|min:3',
            'parent_id' => 'required|integer|exists:blog_categories,id',
        ]; */

        // 4 способа валидации:
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
        
        // 4) в одтельном классе, кастомная валидация, комманда для созания: php artisan make:request BlogCategoryUpdateRequest

        $item = BlogCategory::find($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }

        $result = $item->update($data);//метод update включает в себя fill и save fill($data)->save()
        /* 
            ->fill($data)//обновляем свойства объекта
             ->save();//сохраняем их в базу
        */
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
