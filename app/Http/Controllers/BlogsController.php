<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->sendSucess(Blog::limit($request->limit)->offset($request->offset)->get(),'Data Found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' =>'required',
            'type' =>'required',
            'type_2'=>'required',
            'description'=>'required',
            'rating' => 'required'
            ]);
        if($validate->fails()){
            return $this->sendFailure($validate->errors ());
        }
        $imgpath = '';
        if($request->hasFile('file')){
            $file = $request->file('file');
            $destinationPath = public_path() . '/images/';
            $filename = $file->getClientOriginalName();
            $image = time() . $filename;
            $file->move($destinationPath, $image);
            $imgpath = $destinationPath . $image;

        }
        $blogData = [
            'name'=>$request->name,
            'type'=>$request->type,
            'type_2'=>$request->type_2,
            'rating'=>$request->rating,
            'description'=>$request->description,
            'file' => $imgpath

        ];


        return $this->sendSucess(Blog::insertGetId($blogData), 'Data Added');




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->sendSucess(Blog::findOrFail($id), 'Data Found');

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
        $validate = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
                'type_2' => 'required',
                'description' => 'required',
                'rating' => 'required',
            ]);
            if ($validate->fails()) {
                return $this->sendFailure($validate->errors());
            }
            $imgpath = '';
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $destinationPath = public_path() . '/images/';
                $filename = $file->getClientOriginalName();
                $image = time() . $filename;
                $file->move($destinationPath, $image);
                $imgpath = $destinationPath . $image;

            }
            $blogData = [
                'name' => $request->name,
                'type' => $request->type,
                'type_2' => $request->type_2,
                'rating' => $request->rating,
                'description' => $request->description,
                'file' => $imgpath,

            ];

            return $this->sendSucess(Blog::findOrFail($id)->update($blogData), 'Data Added');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->sendSucess(Blog::findOrFail($id)->delete(), 'Data Found');

    }
}
