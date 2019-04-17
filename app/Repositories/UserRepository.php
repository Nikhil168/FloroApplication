<?php

namespace App\Repositories;
use Model;
use App\User;
use Illuminate\Support\Facades\Auth;
use Okipa\LaravelBootstrapTableList\TableList;
use DB;
use Illuminate\Http\Request; 

class UserRepository extends Repository
{
   /**
     * To initialize class objects/variables.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function sort(Request $request)
    {
        $column = $request->get('column');
        $order = $request->get('order');
        $users = User::orderBy($column,$order) 
        ->get();
        return $users;
    }
    public function index(Request $request)
    {
       $table=User::paginate(5);
        return $table;
    }
 
    public function search(Request $request)
    {
        $data = $request->get('data');
        $users = User::where('user_name', 'like', "%{$data}%")
        ->orWhere('first_name', 'like', "%{$data}%")
        ->orWhere('last_name', 'like', "%{$data}%")
        ->get();

        return response()->json(['data'=>$users]); 
    }

    public function create($attributes)
    {
        $this->model->create($attributes);
        return $this->model->create($attributes);
    }
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Method to get model class
     *
     * @return string
     */
    public function getModelClass() : string
    {
        return User::class;
    }

    /**
     * Method to create the users list as view by using external "Okipa\LaravelBootstrapTableList" package.
     *
     * @return TableList
     */
    public function getUsersList() : TableList
    {
        return app(TableList::class)
            ->setModel(User::class)
            ->setRoutes([
                'index'      => ['alias' => 'users.index', 'parameters' => []],
                'edit'       => ['alias' => 'users.edit', 'parameters' => []],
                'destroy'    => ['alias' => 'users.destroy', 'parameters' => []],
            ])
            ->setRowsNumber(10)
            ->addQueryInstructions(function ($query){
                $query->select('users.*');
                $query->selectRaw('MAX(authentication_logs.created_at) as last_sign_in_at');
                $query->leftJoin('authentication_logs', 'authentication_logs.user_id', '=', 'users.id');
                $query->where('users.id', '!=', Auth::id());
                $query->where('users.status', 1);
                $query->groupBy('users.id');
            });
    }
}
