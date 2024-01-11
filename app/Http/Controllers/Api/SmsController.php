<?php

namespace App\Http\Controllers\Api;


use App\Filters\SmsFilter;
use App\Http\Requests\SmsRequest;
use App\Http\Resources\SmsReportResource;
use App\Http\Resources\SmsResource;
use App\Models\Sms;
use Illuminate\Http\Request;

class SmsController extends BaseController
{
    /**
     * @OA\Get(path="/sms", summary="Sms List", description="Sms List", tags={"Sms"},security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="page", in="query",description="Page Id",required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="id[eq]", in="query",description="Filter by id, diğer kullanabileceğini operatorler
     *      'eq'=>'eşit (=)', 'lt=>küçük(<)', 'lte => küçük ve eşit (<=)', 'gt => büyük (>)', 'gte=> büyük ve eşit (>=)', 'btw => between'",required=false,
     *      @OA\Schema(type="string")),
     *     @OA\Parameter(name="sendDate[btw]", in="query",description="Filter by send date, btw yerine eq yazarak verdiğiniz tarihe göre de filtreleme yapabilirsiniz. ",example="01-01-2024x30-12-2024",required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="statusCode[eq]", in="query",description="Filter by status code",required=false, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/SmsResource")),
     *     @OA\Response(response="401", description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/UnAuthorized"))),
     *     @OA\Response(response="500", description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))),
     *)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        try {

            $filter = new SmsFilter();

            $query = Sms::customers()->with('sms_details');

            $query = $filter->transform($request, $query);

            $query = $query->paginate(100)->appends($request->query());

            return SmsResource::collection($query);

        } catch (\Throwable $ex) {
            return rj(false, $ex->getMessage(), null, 500);
        }

    }


    /**
     * @OA\Post(path="/sms",summary="Send Sms",tags={"Sms"},security={{"bearerAuth":{}}},description="Send Sms",
     * @OA\RequestBody(required=true,
     * @OA\JsonContent(type="object",required={"send_date","numbers"},
     *      @OA\Property(property="send_date", type="string", example="11.01.2024 22:50",description="Sms send date"),
     *      @OA\Property(property="numbers", type="array", @OA\Items(
     *          type="object",required={"number","message"},
     *          @OA\Property(property="number", type="string", example="905555555555",description="Sms number"),
     *          @OA\Property(property="message", type="string", example="Sms message",description="Sms message"),
     *     ),description="Sms numbers")
     *  )
     * ),
     * @OA\Response(response="201", description="Sms Created", @OA\JsonContent(ref="#/components/schemas/SmsResource")),
     * @OA\Response(response="422", description="Validation errors", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     * @OA\Response(response="500", description="Server error", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))
     * )
     */
    public function store(SmsRequest $request): \Illuminate\Http\JsonResponse|SmsResource
    {
        try {
            $sms = new Sms($request->all());
            if ($sms->save())
                $sms->sms_details()->createMany($request->numbers);
            return new SmsResource($sms);
        } catch (\Throwable $ex) {
            return rj(false, $ex->getMessage(), null, 500);
        }
    }


    /**
     * @OA\Get(path="/sms/{id}",summary="Sms Show",tags={"Sms"},security={{"bearerAuth":{}}},description="Sms Show",
     *     @OA\Parameter(name="id", in="path",description="Sms Id",required=true, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/SmsResource")),
     *     @OA\Response(response="401", description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/UnAuthorized"))),
     * )
     */
    public function show($id): \Illuminate\Http\JsonResponse|SmsResource
    {
        try {
            $sms = Sms::customers()->where('id', $id)->first();
            if ($sms != null) {
                return new SmsResource($sms);
            } else {
                return rj(false, 'Kayıt Bulunamadı !', null, 404);
            }

        } catch (\Throwable $ex) {
            return rj(false, $ex->getMessage(), null, 500);
        }
    }

    /**
     * @OA\Get(path="/sms/{id}/report",summary="Sms Report",tags={"Sms"},security={{"bearerAuth":{}}},description="Sms Report",
     *     @OA\Parameter(name="id", in="path",description="Sms Id",required=true, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/SmsReportResource")),
     *     @OA\Response(response="401", description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/UnAuthorized"))),
     * )
     */
    public function report($id): \Illuminate\Http\JsonResponse|SmsReportResource
    {
        try {
            $sms = Sms::customers()->where('id', $id)->first();
            if ($sms != null) {
                return new SmsReportResource($sms);
            } else {
                return rj(false, 'Kayıt Bulunamadı !', null, 404);
            }

        } catch (\Throwable $ex) {
            return rj(false, $ex->getMessage(), null, 500);
        }
    }

    /**
     * @OA\Delete(path="/sms/{id}",summary="Sms Delete",tags={"Sms"},security={{"bearerAuth":{}}},description="Sms Delete",
     *     @OA\Parameter(name="id", in="path",description="Sms Id",required=true, @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *     @OA\Response(response="401", description="Unauthorized", @OA\JsonContent(ref="#/components/schemas/UnAuthorized")))
     * )
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $sms = Sms::customers()->where('id', $id)->first();
            if ($sms != null) {
                $sms->delete();
                return rj(true, 'İşlem başarılı');
            } else {
                return rj(false, 'Kayıt Bulunamadı !', null, 404);
            }
        } catch (\Throwable $ex) {
            return rj(false, $ex->getMessage(), null, 500);
        }
    }

}
