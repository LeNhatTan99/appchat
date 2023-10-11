<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;

class UserFileService
{

 /**
     * show list user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser($request)
    {
        try {
            $search = $request->get('search');
            $data = User::leftJoin('provinces', 'users.province_id', 'provinces.id')
            ->leftJoin('districts', 'users.district_id', 'districts.id')
            ->leftJoin('communes', 'users.commune_id', 'communes.id')
            ->select(
                "users.id",
                "email",
                "full_name",
                "birthday",
                "phone",
                "address",
                "avatar",
                DB::raw('(CASE WHEN status = 1 THEN "Đã xác thực" ELSE "Chưa xác thực" END) AS status'),
                "birthday",
                "flag_delete",
                DB::raw('CONCAT_WS(", ", users.address, communes.name,districts.name, provinces.name) as address'),
            )
            ->when( $search , function ($query, $search) {
                return
                    $query->where('users.full_name', 'like', '%' . $search . '%')
                        ->orWhere('users.phone', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%');
                })
            ->where('users.flag_delete', 0)
            ->orderBy('users.id', 'DESC')
            ->paginate(10);

            return $data;
        } catch (\Exception $e) {
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

     /**
     * show list user.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchUser($request)
    {
        $data = null;
        $userId = auth('api')->user()->id;
        try {
            if($request->get('search')) {
                $search = $request->get('search');
                $data = User::leftJoin('provinces', 'users.province_id', 'provinces.id')
                ->leftJoin('districts', 'users.district_id', 'districts.id')
                ->leftJoin('communes', 'users.commune_id', 'communes.id')
                ->select(
                    "users.id",
                    "email",
                    "full_name",
                    "birthday",
                    "phone",
                    "address",
                    "avatar",
                    "birthday",
                    "flag_delete",
                    DB::raw('CONCAT_WS(", ", users.address, communes.name,districts.name, provinces.name) as address'),
                    DB::raw("CASE 
                    WHEN friendships.status = '1' THEN '1' ELSE '0' END AS friend")
                )
                ->where('users.id', '!=', $userId)
                ->where('users.status', User::ACTIVE)
                ->where('users.flag_delete', User::NOT_DELETE)
                ->leftJoin('friendships', function ($join) use ($userId) {
                    $join->on(function ($query) use ($userId) {
                        $query->on('users.id', '=', 'friendships.friend_id')
                            ->where('friendships.user_id', '=', $userId);
                    })->orOn(function ($query) use ($userId) {
                        $query->on('users.id', '=', 'friendships.user_id')
                            ->where('friendships.friend_id', '=', $userId);
                    });
                })
                ->when( $search , function ($query, $search) {
                    return
                        $query->where('users.full_name', 'like', '%' . $search . '%')
                            ->orWhere('users.phone', 'like', '%' . $search . '%')
                            ->orWhere('users.email', 'like', '%' . $search . '%');
                    })
                ->orderBy('users.id', 'DESC')
                ->get();
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

    public function create($request) {
        DB::beginTransaction();
        try{
            $data = [
                'phone' => $request->phone,
                'email' => $request->email,
                'full_name' => $request->full_name,
                'birthday' => $request->birthday,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'password' => Hash::make($request->password),
            ];
            if ($request->hasFile('avatar')) {
                $path = self::uploadImage($request->avatar, $request->email);
                $data['avatar'] = $path;
            };
            $user = User::create($data);
            DB::commit();
            return $user;
        }catch (\Exception $e) {
            DB::rollback();
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

    public function updateUser($id, $request) {
        Log::info($request->avatar);
        DB::beginTransaction();
        try{
            $user = User::find($id);
            $data = [
                'phone' => $request->phone,
                'email' => $request->email,
                'full_name' => $request->full_name,
                'birthday' => $request->birthday,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'password' => Hash::make($request->password),
            ];
            if ($request->hasFile('avatar')) {
                $path = self::uploadImage($request->avatar, $request->email);
                $data['avatar'] = $path;
            };
            if($user) {
                $user->update($data);
                DB::commit();
                return $user;
            }
        }catch (\Exception $e) {
            DB::rollback();
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }


       /**
     * show info customer login.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = $user = User::find($id);
            return $user;
        } catch (\Exception $e) {
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

        /**
     * delete user
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $user = $user = User::find($id);
            $user->update(['flag_delete'=>1]);
        DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

    /**
     * show info customer login.
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
        try {
            $account = auth('api')->user();
            return $account;
        } catch (\Exception $e) {
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return bool
     */
    public function update(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::find(Auth::user()->id);
            $data = [
                'phone' => $request->phone,
                'email' => $request->email,
                'full_name' => $request->full_name,
                'birth_day' => $request->birth_day,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'commune_id' => $request->commune_id,
                'password' => Hash::make($request->password),
            ];
            $customer->update($data);
            DB::commit();
            return $customer;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

    /**
     *  create order customer when order products
     *
     * @return JsonResponse
     */

    public function order(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = new Order();
            $customerId = Auth::id();
            $productId = $request->product_id;
            $quantity = $request->quantity;
            $totalOrder = 0;
            $quantityOrder = 0;
            $orderDetails = [];
            $dataOrder = [];
            foreach ($productId as $id) {
                $product = Product::select('id', 'stock','price')->find($id);
                if (!is_null($product)) {
                    // check quantity order with product stock
                    if ($product->stock < $quantity) {
                        $response[] = [
                            'message' => 'Quantity order =' . ' ' . $quantity . ' ' . '>' . ' ' . 'product stock =' . ' ' . $product->stock . ' ' . 'order failed',
                        ];
                    } else {
                        $product->decrement('stock', $quantity);
                        $totalOrder +=  $quantity * $product->price;
                        $quantityOrder += $quantity;
                        $orderDetails[] = [
                            'product_id' => $id,
                            'quantity' => $quantity,
                            'price' => $product->price,
                            'status' => 'Mới'
                        ];
                        $response[] = [
                            'message' => 'Order successfully',
                        ];
                    }
                }
            }
            // insert data into table Order
            $dataOrder = [
                'customer_id' => $customerId,
                'quantity' => $quantityOrder,
                'total' => $totalOrder,
            ];
            $order = Order::create($dataOrder);
            $orderDetailsInfo = $order->orderDetails()->createMany($orderDetails);
            //Show info product order
            $products = Product::select('id', 'stock')->whereIn('id', $productId)->get();
            DB::commit();
            return [
                'productId' => $productId,
                'orderInfo' => $order,
                'orderDetailsInfo' => $orderDetailsInfo,
                'products' => $products,
                'message' => $response,
            ];
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('[UserController][UserByService] error ' . $e->getMessage());
            throw new \Exception('[UserController][UserByService] error ' . $e->getMessage());
        }
    }

        /**
     * create a path name when uploading pictures.
     *
     * @param  \Illuminate\Http\Request  $request
     */

     public function uploadImage($avatar, $email)
     {
        $nameImage = 'avatar-' . $email . "." . $avatar->getClientOriginalExtension();
        $oldPath = "public/user_images/" . $nameImage;
        
        if (Storage::exists($oldPath)) {
            Storage::delete($oldPath);
        }
        
        $newPath = $avatar->storeAs('public/user_images', $nameImage);
        $newPath = str_replace('public/', '', $newPath);
        return $newPath;
     }
}
