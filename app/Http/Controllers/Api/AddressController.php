<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
  /**
     * get prefectures
     * @param   Request  $request  
     * @return  json
     * @throws Exception
     */
    public function getProvinces(Request $request)
    {
        try {
            $name = $request->get('name');
            $data = Province::select('id', 'name')
                ->when($name, function ($query, $name) {
                    return
                        $query->where('provinces.name', 'like', '%' . $name . '%');
                })
                ->orderBy('id')
                ->get();
                return response()->json(
                    [
                        'data' => $data,
                        'message' => 'Hiển thị danh sách Tỉnh/Thành phố thành công',
                    ],
                    Response::HTTP_OK
                );
        } catch (\Exception $e) {
            \Log::error("[AddressController][getprovinces] error " . $e->getMessage());
            throw new \Exception('[AddressController][getprovinces] error ' . $e->getMessage());
        }
    }

        /**
     * get districts
     * @param   Request  $request  
     * @return  json
     * @throws Exception
     */
    public function getDistrictByProvince(Request $request) {
        try{
            $name = $request->get('name');
            $data = District::with('province')
            ->where('districts.province_id', $request->get('province_id'))
            ->when( $name , function ($query, $name) {
                return
                    $query->where('districts.name', 'like', '%' . $name . '%');
                })
            ->select([
                'id',
                'name',
            ])
            ->orderBy('id')
            ->get();
            return response()->json(
                [
                    'data' => $data,
                    'message' => 'Hiển thị danh sách Quận/Huyện theo Tỉnh/Thành phố thành công',
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            throw new \Exception('[AddressController][getDistrictByProvince] error ' . $e->getMessage());
        }
    }

      /**
     * get communes
     * @param   Request  $request  
     * @return  json
     * @throws Exception
     */
    public function getCommuneByDistrict(Request $request) {
        try{
            $name = $request->get('name');
            $data = Commune::with('district')
            ->where('communes.district_id', $request->get('district_id'))
            ->when( $name , function ($query, $name) {
                return
                    $query->where('communes.name', 'like', '%' . $name . '%');
                })
            ->select([
                'id',
                'name',
            ])
            ->orderBy('id')
            ->get();
            return response()->json(
                [
                    'data' => $data,
                    'message' => 'Hiển thị danh sách Phường/Xã theo Quận/Huyện thành công',
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            throw new \Exception('[AddressController][getCommuneByDistrict] error ' . $e->getMessage());
        }
    }
}
