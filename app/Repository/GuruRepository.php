<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class GuruRepository {
    /**
     * Store user as guru
     *
     * @param Array $request
     * @return void
     */
    public function storeGuru(Array $request) {
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request['name'];
            $user->nidn = intval($request['nidn']);
            $user->email = $request['email'];
            $user->password = Hash::make('smkdarulmawa');
            $user->role = 'guru';
            $user->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}