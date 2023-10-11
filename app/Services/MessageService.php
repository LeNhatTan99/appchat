<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Message;
use App\Events\MessagePosted;
use App\Http\Requests\UpdateProductRequest;

class MessageService
{ 


    /**
     * Store a newly created resource in storage.
     *
     * @param $request
     * @return bool
     */
    public function send($request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::guard('api')->user();
            $data = [
                'user_id' => $user->id,
                'message' => $request->message,
                'conversation_id' => Message::CONVERSATION_PUBLIC
            ];
            if($request->conversation_id) {
                $data['conversation_id'] = $request->conversation_id;
            }
            $message = Message::create($data);
            $message->load('user');
            broadcast(new MessagePosted($message, $user))->toOthers();
            DB::commit();
            return  $message;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error( $e->getMessage() );
            return response()->json($e->getMessage());
        }
    }

     /**
      * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  App\Model\Product $product
     * @return bool
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = [
            'sku' => $request->sku,
            'name' => $request->name,
            'stock' => $request->stock,  
            'price' => $request->price, 
            'expired_at' => $request->expired_at,
            'category_id' => $request->category_id,
        ];
        if($request->has('avatar')){
            $path = ProductService::uploadImage($request);
            $data['avatar'] = substr($path, strlen('upload/product_images/'));
        }

        DB::beginTransaction();
        try {
            $product->update($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Model\Product $product
     */

    public function deleteProduct(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->update(array('flag_delete' => '1'));
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }

    /**
     * create a path name when uploading pictures.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function uploadImage($request)
    {
        $nameImage = $request->sku.".".$request->avatar->getClientOriginalExtension();
        $path = $request->file('avatar')->move('upload/product_images','avatar'.$nameImage );
        return $path;
    }
}
