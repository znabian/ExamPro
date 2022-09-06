<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormularConditation;
use Illuminate\Support\Facades\DB;

class FormularConditationController extends Controller
{
    public function check(Request $req)
    {
        try {
            $test=strtr($req->conditation,['{:RESULT}'=>10,'{:RESULT-'=>'','{:mode}'=>'%','{:'=>'','}'=>'']);
                $a=eval("return $test ;");
                return response()->json(['success'=>0,'msg'=>'']);
            } catch (\Throwable $th) {
                return response()->json(['success'=>1,'msg'=>'فرمول وارد شده اشتباه است']);
            }
    }
    public function create(Request $req)
    {
        try {
            $test=strtr($req->conditation['conditation'],['{:RESULT}'=>10,'{:RESULT-'=>'','{:mode}'=>'%','{:'=>'','}'=>'']);
                $a=eval("return $test ;");
            } catch (\Throwable $th) {
                return response()->json(['msg'=>'شرط  وارد شده اشتباه است'],'500');
            }
            $con=DB::table('formular_conditations')->insertGetId($req->conditation);
            $con=FormularConditation::find($con);
            $out="<tr>
                <td>$con->conditation</td>
                <td>$con->then</td>
                <td>
                <a class='btn btn-outline-danger' onclick='removeif2($req->num,$con->id)'><i class='fa fa-trash'></i></a>
                <a class='btn btn-outline-warning' onclick='editif2($req->num,$con->id)'><i class='fa fa-pencil'></i></a>
                </td>
                </tr>
            ";
                return response()->json(['id'=>$con->id,'out'=>$out]);
       
    }
    public function update(Request $req)
    {
        try {
            $test=strtr($req->conditation,['{:RESULT}'=>10,'{:RESULT-'=>'','{:mode}'=>'%','{:'=>'','}'=>'']);
                $a=eval("return $test ;");
            } catch (\Throwable $th) {
                return response()->json(['msg'=>$test],'500');
                return response()->json(['msg'=>'شرط وارد شده اشتباه است'],500);
            }
        $formulid=DB::table('formular_conditations')->find($req->id)->formular_id;
        DB::table('formular_conditations')->where('id',$req->id)->update([
                "conditation"=>$req->conditation,
                "then"=>$req->then
            ]);
            
            if($formulid)
            {
               $cons= DB::table('formular_conditations')->where("formular_id",$formulid)->get();
               $out="";
               foreach($cons as $con)
               {
                    $out.="<tr>
                    <td>$con->conditation</td>
                    <td>$con->then</td>
                    <td>
                    <a class='btn btn-outline-danger' onclick='removeif2($req->num,$con->id)'><i class='fa fa-trash'></i></a>
                    <a class='btn btn-outline-warning' onclick='editif2($req->num,$con->id)'><i class='fa fa-pencil'></i></a>
                    </td>
                    </tr>";
               }
            }
            else
            {
                $cons= DB::table('formular_conditations')->whereNull("formular_id")->whereNull("exam_id")->get();
               $out="";
               foreach($cons as $con)
               {
                    $out.="<tr>
                    <td>$con->conditation</td>
                    <td>$con->then</td>
                    <td>
                    <a class='btn btn-outline-danger' onclick='removeif2($req->num,$con->id)'><i class='fa fa-trash'></i></a>
                    <a class='btn btn-outline-warning' onclick='editif2($req->num,$con->id)'><i class='fa fa-pencil'></i></a>
                    </td>
                    </tr>";
               }
            } 
            return response()->json(['id'=>$req->id,'out'=>$out]);
       
    }
    public function get(Request $req)
    {
            $con=DB::table('formular_conditations')->find($req->id);
            if($con)
            return response()->json(['id'=>$con->id,'if'=>$con->conditation,'then'=>$con->then]);
            else
            return response()->json([],404);
       
    }
    public function delete(Request $req)
    {
            $formulid=DB::table('formular_conditations')->find($req->id)->formular_id;
            $con=DB::table('formular_conditations')->delete($req->id);
            if($con)
            {
                if($formulid)
                {
                   $cons= DB::table('formular_conditations')->where("formular_id",$formulid)->get();
                   $out="";
                   foreach($cons as $con)
                   {
                        $out.="<tr>
                        <td>$con->conditation</td>
                        <td>$con->then</td>
                        <td>
                        <a class='btn btn-outline-danger' onclick='removeif2($req->num,$con->id)'><i class='fa fa-trash'></i></a>
                        <a class='btn btn-outline-warning' onclick='editif2($req->num,$con->id)'><i class='fa fa-pencil'></i></a>
                        </td>
                        </tr>";
                   }
                }
                else
                {
                    $cons= DB::table('formular_conditations')->whereNull("formular_id")->whereNull("exam_id")->get();
                   $out="";
                   foreach($cons as $con)
                   {
                        $out.="<tr>
                        <td>$con->conditation</td>
                        <td>$con->then</td>
                        <td>
                        <a class='btn btn-outline-danger' onclick='removeif2($req->num,$con->id)'><i class='fa fa-trash'></i></a>
                        <a class='btn btn-outline-warning' onclick='editif2($req->num,$con->id)'><i class='fa fa-pencil'></i></a>
                        </td>
                        </tr>";
                   }
                } 
                return response()->json(['id'=>$req->id,'out'=>$out]);
            }           
            else
            return response()->json([],404);
       
    }
}
