<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    protected $secretkey = "tMEj6JCB3pp3GU6";

    public function imageUpload(Request $request)
    {
        if (!$request->images) {
            return response()->json([
                'code' => 1000011,
                'msg' => 'Error',
                'response' => 'Images Required'
            ]);
        } elseif (!$request->path) {
            return response()->json([
                'code' => 100025,
                'msg' => 'Error',
                'response' => 'Path Required'
            ]);
        } elseif (!$request->secret) {
            return response()->json([
                'code' => 100020,
                'msg' => 'Error',
                'response' => 'Secret Required'
            ]);
        } elseif ($request->secret !== $this->secretkey) {
            return response()->json([
                'code' => 9999999,
                'msg' => 'Error',
                'response' => 'https://wizegamings.com'
            ]);
        } elseif ($request->secret === $this->secretkey) {
            $imageName = Str::random() . '_' . time() . '_' . $request->images->getClientOriginalName();
            $request->images->move(public_path($request->path), $imageName);

            $result = asset($request->path . '/' . $imageName);

            return response()->json([
                'code' => 0,
                'msg' => 'Success',
                'data' => $result
            ]);
        }
    }
}
