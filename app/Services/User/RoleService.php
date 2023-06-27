<?php

namespace App\Services\User;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleService {

    public function getList($data)
    {
        $response = [
            'success' => true,
            'current_page' => 0,
            'per_page' => 0,
            'total' => 0,
            'has_more' => false,
            'data' => [],
        ];

        try {
            
            $searchables = (new Role())->getSearchables();
            $roleQ = Role::select('*');
            
            // Filter
            if(!empty($data['filters']))
            {
                foreach ($data['filters'] as $field => $value) {
                    // jika value nya array maka query menggunakan IN
                    if(is_array($value))
                        $roleQ->whereIn($field, $value);
                    else
                        $roleQ->where($field, $value);
                }
            }

            if(!empty($data['search']))
            {
                $roleQ->where(function($query) use ($data, $searchables) {
                    foreach ($searchables as $field_index) {
                        $query->orWhere($field_index, 'ILIKE', "%{$data['search']}%");
                    }
                });
            }

            $roleQ->orderBy($data['sort_by'], $data['sort']);

            if(!empty($roleQ->count()))
            {
                $roles = $roleQ->paginate($data['per_page']);
                // dd(\DB::getQueryLog());
                $response['current_page'] = $roles->currentPage();
                $response['per_page'] = $roles->perPage();
                $response['total'] = $roles->total();
                $response['has_more'] = $roles->hasMorePages();
                $response['data'] = $roles->items();
            }

            return $response;

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $response;
        }    
    }

    public function store($data)
    {
        $response = [
            'code' => 200,
            'success' => true,
            'message' => '',
            'data' => null,
        ];

        try {
            
            $permission_ids = Permission::whereIn('id', $data['permission_id'])->pluck('id')->toArray();
            $perm_id_not_exists = [];
            foreach ($data['permission_id'] as $perm_id) {
                if(!in_array($perm_id, $permission_ids))
                    $perm_id_not_exists[] = $perm_id;
            }

            if(!empty($perm_id_not_exists))
            {
                throw new Exception("Hak akses ID #" . implode(', ', $perm_id_not_exists) . " tidak ada didatabase. Silakan tambahkan terlebih dahulu di menu Hak Akses / Permission.", 400);
            }

            $role_exist = Role::where('display_name', $data['display_name'])->first();
            if(!empty($role_exist))
            {
                throw new Exception("Role {$data['display_name']} sudah ada didatabase!", 400);
            }

            \DB::beginTransaction();

            $role = new Role();
            $role->name = \Str::slug($data['display_name']);
            $role->display_name = $data['display_name'];
            if(!empty($data['description']))
                $role->description = $data['description'];

            $role->save();

            $role->syncPermissions($data['permission_id']);

            \DB::commit();

            $role = Role::with('permissions')->find($role->id);

            $response['data'] = $role;
            $response['message'] = 'Role berhasil disimpan.';

            return $response;
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $response['code'] = $th->getCode();
            $response['success'] = false;
            $response['message'] = $th->getMessage();
            return $response;
        }    
    }

    public function findById($id)
    {
        $response = [
            'code' => 200,
            'success' => true,
            'message' => '',
            'data' => null,
        ];

        try {
            
            $role = Role::with('permissions')->find($id);
            if(empty($role))
            {
                throw new Exception("Role ID #{$id} tidak ada didatabase!", 400);
            }

            $response['data'] = $role;
            $response['message'] = 'Success';

            return $response;
            
        } catch (\Throwable $th) {
            $response['code'] = $th->getCode();
            $response['success'] = false;
            $response['message'] = $th->getMessage();
            return $response;
        }   
    }

    public function update($data, $id)
    {
        $response = [
            'code' => 200,
            'success' => true,
            'message' => '',
            'data' => null,
        ];

        try {
            
            $resp = $this->findById($id);
            if(!$resp['success'])
            {
                return $resp;
            }

            $permission_ids = Permission::whereIn('id', $data['permission_id'])->pluck('id')->toArray();
            $perm_id_not_exists = [];
            foreach ($data['permission_id'] as $perm_id) {
                if(!in_array($perm_id, $permission_ids))
                    $perm_id_not_exists[] = $perm_id;
            }

            if(!empty($perm_id_not_exists))
            {
                throw new Exception("Hak akses ID #" . implode(', ', $perm_id_not_exists) . " tidak ada didatabase. Silakan tambahkan terlebih dahulu di menu Hak Akses / Permission.", 400);
            }

            $role_exist = Role::where('display_name', $data['display_name'])->where('id', '!=', $id)->first();
            if(!empty($role_exist))
            {
                throw new Exception("Role {$data['display_name']} sudah ada didatabase!", 400);
            }

            \DB::beginTransaction();
            $role = $resp['data'];
            $role->name = \Str::slug($data['display_name']);
            $role->display_name = $data['display_name'];
            if(!empty($data['description']))
                $role->description = $data['description'];

            $role->save();

            $role->syncPermissions($data['permission_id']);

            \DB::commit();

            $role = $this->findById($id)['data'];

            $response['data'] = $role;
            $response['message'] = 'Role berhasil diupdate.';

            return $response;
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $response['code'] = $th->getCode();
            $response['success'] = false;
            $response['message'] = $th->getMessage();
            return $response;
        }    
    }

    public function delete($id)
    {
        $response = [
            'code' => 200,
            'success' => true,
            'message' => '',
            'data' => null,
        ];

        try {
            
            $resp = $this->findById($id);
            if(!$resp['success'])
            {
                return $resp;
            }

            $role = $resp['data'];
            $role->delete();

            $response['data'] = $role;
            $response['message'] = "Role {$role->display_name} berhasil didelete.";

            return $response;
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $response['code'] = $th->getCode();
            $response['success'] = false;
            $response['message'] = $th->getMessage();
            return $response;
        }   
    }
}