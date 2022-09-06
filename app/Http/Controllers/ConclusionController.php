<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConclusionRequest;
use App\Http\Requests\UpdateConclusionRequest;
use App\Models\Conclusion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConclusionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conclusions = Conclusion::paginate();
        return view('conclusions.index',["conclusions"=>$conclusions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('conclusions.create',["examId"=>$id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConclusionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "description"=>"required|min:3",
            "low"=>"required",
            "high"=>"required"
        ]);
        if($request->low>=$request->high){
            return redirect()->back();
        }
        Conclusion::create([
            "exam_id"=>$request->examId,
            "description"=>$request->description,
            "low"=>$request->low,
            "high"=>$request->high
        ]);
        return redirect()->route('exam.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conclusion  $conclusion
     * @return \Illuminate\Http\Response
     */
    public function show(Conclusion $conclusion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conclusion  $conclusion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conclusion = Conclusion::find($id);
        return view('conclusions.edit',["conclusion"=>$conclusion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConclusionRequest  $request
     * @param  \App\Models\Conclusion  $conclusion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            "description"=>"required|min:3",
            "low"=>"required",
            "high"=>"required"
        ]);
        if($request->low>=$request->high){
            return redirect()->back();
        }
        DB::table("conclusions")->where("id","=",$id)->update([
            "description"=>$request->description,
            "low"=>$request->low,
            "high"=>$request->high
        ]);
        return redirect()->route('conclusion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conclusion  $conclusion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conclusion $conclusion)
    {
        //
    }
}
