<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HtmlRecord;
use Goutte\Client;

class HtmlApiController extends Controller
{
    public function storeUrl(Request $request){
        $this->validate($request, [
            'url' => ['required','regex:/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i'],
        ]);
        $token = sha1(uniqid(rand(), true));
        $check_token = HtmlRecord::where('token',$token)->first();
        while ($check_token){
            $token = sha1(uniqid(rand(), true));
            $check_token = HtmlRecord::where('token',$token)->first();
        }

        $HtmlRecord = new HtmlRecord();
        $HtmlRecord->url = $request['url'];
        $HtmlRecord->token = $token;
        $HtmlRecord->save();

        return response()->json([
            'token' => $token,
            'url'  =>  $request['url'],
            'status' => 'success',
        ]);
    }
    public function getHtml(Request $request){
        $HtmlRecord = HtmlRecord::where('token',$request['token'])->first();
        if($HtmlRecord == NULL){
            return response()->json([
                'token' => $request['token'],
                'html' => '',
                'status' => 'error:Please specify the correct token',
            ]);
        }else{
            return response()->json([
                'token' => $HtmlRecord->token,
                'html' => $HtmlRecord->html,
                'status' => 'success',
            ]);
        }
    }

    public function getList(Request $request){
        if($request['start_date'] === $request['end_date']){
            $this->validate($request, [
                'start_date' => ['required','date_format:Y-m-d'],
                'end_date' => ['required','date_format:Y-m-d'],
                'type' => ['required','in:updated_at,created_at'],
            ]);
        }else{
            $this->validate($request, [
                'start_date' => ['required','date_format:Y-m-d'],
                'end_date' => ['required','date_format:Y-m-d','after:start_date+1'],
                'type' => ['required','in:updated_at,created_at'],
            ]);
        }

        $arr = array();
        $HtmlRecords = HtmlRecord::all();
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $type = $request['type'];
        $i = 0;
        foreach ($HtmlRecords as $HtmlRecord) {
            if($HtmlRecord->html == NULL){
                continue;
            }
            $date = date_format($HtmlRecord->$type , 'Y-m-d');
            if($start_date <= $date && $end_date >= $date){
                $arr[$i] = array(
                    'token' => $HtmlRecord->token,
                    'html'  => $HtmlRecord->html,
                    'updated_at' =>date_format($HtmlRecord->updated_at , 'Y-m-d H:i:s'),
                    'created_at' =>date_format($HtmlRecord->created_at , 'Y-m-d H:i:s'),
                );
                $i++;
            }
        }
        $arr += array(
            'status' => 'success'
        );
        $json = json_encode($arr,true);
        return $json;
    }
}
