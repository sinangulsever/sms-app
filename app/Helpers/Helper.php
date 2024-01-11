<?php

if (!function_exists("rj")) {

    function rj($type, $message, $extra = null, $status = 200): \Illuminate\Http\JsonResponse
    {
        $arr = ['status' => (bool)$type, 'message' => $message];

        if (is_array($extra)) {
            if (count($extra))
                $arr = array_merge($arr, $extra);
        }
        return response()->json($arr, $status);
    }
}


if (!function_exists("user")) {
    function user(): ?\App\Models\User
    {
        return auth('api')->user() ?? new \App\Models\User();
    }
}
