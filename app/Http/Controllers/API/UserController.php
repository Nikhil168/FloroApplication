<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Requests;
use App\Http\Resources\Users as UserResource;
use Auth;
class UserController extends Controller
{
    /**
     * @var UserService $userService
     */
    private $userService;
    private $user;
    public $successStatus = 200;

    /**
     * UserController constructor.
     * Initialize all class instances.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
   
    public function login(Request $request)
    { 
         if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            //$table = $this->userService->index($request);
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised',"message" => "The user credentials were incorrect."], 401); 
        } 
    }
    /**
     * Method to show users list.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $table=User::paginate(10);
        $table = $this->userService->index($request);
        return $table;
    }

    public function sort(Request $request)
    {
    $table = $this->userService->sort($request);
    return $table;
    }
    
    public function getSearchResults(Request $request) 
    {
        $table = $this->userService->search($request);
        return response()->json([
            $table,'message' => 'Searched Record::'
         ]); 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.user');
    }
    /**
     * Store a newly created user in the database.
     *
     * @param  CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $result = $this->userService->createUser($request);
        return response()->json([
            'message' => 'Successfully Created Record..',$result
         ]); 
    }

    /**
     * Method to show a particular user.
     *
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userService->getUser($id);
        // if ($user == null) {
        //     return redirect('/users')->with('errorMessage',
        //         __('frontendMessages.EXCEPTION_MESSAGES.FIND_USER_MESSAGE'));
        // }

        return view('admin.users.user', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $result = $this->userService->updateUser($request, $id);
        //  if ($result == null) {
        //      return redirect('/users/edit')->with('errorMessage',
        //          config('frontendMessages.EXCEPTION_MESSAGES.UPDATE_USER_MESSAGE'));
        //  }

        // return redirect('/users')->with('successMessage', __('frontendMessages.SUCCESS_MESSAGES.USER_UPDATED'));
        return response()->json([
            'message' => 'Successfully Updated',$result
         ]);  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);
        return response()->json([
        'message' => 'Successfully deleted',$result
     ]);        
    }
    public function home()
    {
        if(!empty(Auth::user()) && Auth::user()!=null) {
        return redirect('/users');
        }
        else
        {
        return view('auth.login');
        }
    }
public function logout(Request $request)
{
    $request->user()->token()->revoke();
    return response()->json([
        'message' => 'Successfully logged out'
    ]);
}

}
