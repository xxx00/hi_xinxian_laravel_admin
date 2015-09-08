<?php namespace App\Repositories\Admin;

use App\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository {
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }



    /**
     * Get role list
     * @param $perPage
     * @return mixed
     */
    public function index()
    {
        return $this->model->orderBy('id', 'desc')->get();
    }
    /**
     * Store user
     * @param $inputs
     * @return bool
     */
    public function store($inputs,$user_id = '1')
    {
        $model = new $this->model;
        $model->name = $inputs['name'];
        $model->email = $inputs['email'];
        $model->position = $inputs['position'];
        $model->description = $inputs['description'];
        $model->password = bcrypt($inputs['password']);
        if ($model->save()) {
            return $model->id;
        }
        return false;
    }

    /**
     * 获取编辑的内容
     *
     * @param  int $id
     * @param  string $type 内容模型类型
     * @return Illuminate\Support\Collection
     */
    public function edit($id)
    {
        $city = $this->city->findOrFail($id);
        return $city;
    }
    /**
     * Get user list
     * @param int $perPage
     * @return mixed
     */
    public function userList()
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

    /**
     * Attach roles to user
     * @param $userId
     * @param $roles
     */
    public function attachRole($userId, $roles)
    {
        foreach ($roles as $role) {
            $this->model->find($userId)->attachRole($role);
        }

    }

    /**
     * Update User
     * @param $id
     * @param $inputs
     */
    public function update($id, $inputs)
    {
        $isAble = $this->model->where('id', '<>', $id)->where('name', $inputs['name'])->count();
        if ($isAble) {
            return [
                'status' => false,
                'error' => '用户名已被使用'
            ];
        }

        $isAble = $this->model->where('id', '<>', $id)->where('email', $inputs['email'])->count();
        if ($isAble) {
            return [
                'status' => false,
                'error' => '邮箱已被使用'
            ];
        }

        $data = [];
        if ($inputs['password']) {
            $data['password'] = bcrypt($inputs['password']);
        }
        $data['name'] = $inputs['name'];
        $data['email'] = $inputs['email'];
        $data['position'] = $inputs['position'];
        $data['description'] = $inputs['description'];
        $result = $this->model->where('id', $id)->update($data);
        if (!$result) {
            return [
                'status' => false,
                'error' => '用户更新失败'
            ];
        }
        $this->model->find($id)->roles()->detach();

        if (isset($inputs['roles'])) {
            $this->attachRole($id, $inputs['roles']);
        }
        return ['status' => true];
    }

    /**
     * Destroy user by id
     * @param int $id
     * @return bool|null
     */
    public function destroy($id)
    {
        $user = $this->model->find($id);
        if(!$user){
            return false;
        }
        $user->roles()->detach();
        return $user->delete();
    }
}