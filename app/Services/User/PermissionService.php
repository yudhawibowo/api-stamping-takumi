<?php

namespace App\Services\User;

use App\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Log;

class PermissionService {

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
            
            $searchables = (new Permission())->getSearchables();
            $permissionQ = Permission::select('*');
            
            // Filter
            if(!empty($data['filters']))
            {
                foreach ($data['filters'] as $field => $value) {
                    // jika value nya array maka query menggunakan IN
                    if(is_array($value))
                        $permissionQ->whereIn($field, $value);
                    else
                        $permissionQ->where($field, $value);
                }
            }

            if(!empty($data['search']))
            {
                $permissionQ->where(function($query) use ($data, $searchables) {
                    foreach ($searchables as $field_index) {
                        $query->orWhere($field_index, 'ILIKE', "%{$data['search']}%");
                    }
                });
            }

            $permissionQ->orderBy($data['sort_by'], $data['sort']);

            if(!empty($permissionQ->count()))
            {
                $permissions = $permissionQ->paginate($data['per_page']);
                // dd(\DB::getQueryLog());
                $response['current_page'] = $permissions->currentPage();
                $response['per_page'] = $permissions->perPage();
                $response['total'] = $permissions->total();
                $response['has_more'] = $permissions->hasMorePages();
                $response['data'] = $permissions->items();
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
            

            $permission_exist = Permission::where('display_name', $data['display_name'])->first();
            if(!empty($permission_exist))
            {
                throw new Exception("Hak akses {$data['display_name']} sudah ada didatabase!", 400);
            }

            $permission = new Permission();
            $permission->name = \Str::slug($data['display_name']);
            $permission->display_name = $data['display_name'];
            if(!empty($data['description']))
                $permission->description = $data['description'];

            $permission->save();

            $permission = Permission::find($permission->id);

            $response['data'] = $permission;
            $response['message'] = 'Hak akses berhasil disimpan.';

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
            
            $permission = Permission::find($id);
            if(empty($permission))
            {
                throw new Exception("Hak akses ID #{$id} tidak ada didatabase!", 400);
            }

            $response['data'] = $permission;
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

            $permission_exist = Permission::where('display_name', $data['display_name'])->where('id', '!=', $id)->first();
            if(!empty($permission_exist))
            {
                throw new Exception("Hak akses {$data['display_name']} sudah ada didatabase!", 400);
            }

            $permission = $resp['data'];
            $permission->name = \Str::slug($data['display_name']);
            $permission->display_name = $data['display_name'];
            if(!empty($data['description']))
                $permission->description = $data['description'];

            $permission->save();

            $permission = $this->findById($id)['data'];

            $response['data'] = $permission;
            $response['message'] = 'Hak akses berhasil diupdate.';

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

            $permission = $resp['data'];
            $permission->delete();

            $response['data'] = $permission;
            $response['message'] = "Hak akses {$permission->display_name} berhasil didelete.";

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