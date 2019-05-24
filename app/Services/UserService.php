<?php

namespace App\Services;

use App\Http\Requests\CreateUserRequest;
use App\Mail\UserCreatedEmail;
use App\Repositories\UserActivityRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Okipa\LaravelBootstrapTableList\TableList;
use App\User;
use App\Models\UserActivity;

use Carbon\Carbon;

class UserService 
{
    	
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    /**
     * @var UserActivityRepository $userActivityRepository
     */
    private $userActivityRepository;
    const status = 0;

    /**
     * UserService constructor.
     * Initialize object/instance for classes.
     *
     * @param UserRepository $userRepository
     * @param UserActivityRepository $userActivityRepository
     */
    public function __construct(UserRepository $userRepository, UserActivityRepository $userActivityRepository)
    {
        $this->userRepository = $userRepository;
        $this->userActivityRepository = $userActivityRepository;
    }

    public function search(Request $request)
    {
        $table=$this->userRepository->search($request);
        return $table;
    }	

    public function index(Request $request)
    {
        $table=$this->userRepository->index($request);
        return $table;
    }
    public function sort(Request $request)
    {
    $table = $this->userRepository->sort($request);
    return $table;
    }
    /**
     * Method to create the user.
     *
     * @param CreateUserRequest $request
     * @return Collection|null
     */
    public function createUser(CreateUserRequest $request)
    {
        $inputData = $request->all();
        $user = $this->userRepository->create($inputData);
        return $user;
    }
    /**
     * Method to get all the users in the table format.
     *
     * @return TableList
     * @throws \ErrorException
     */
    public function getAllUsers() : TableList
    {
        $table = $this->userRepository->getUsersList();
        $table->addColumn('user_name')
            ->setTitle('User Name')
            ->isSortable()
            ->isSearchable()
            ->useForDestroyConfirmation();

        $table->addColumn('first_name')
            ->setTitle('First Name')
            ->isSortable();

        $table->addColumn('last_name')
            ->setTitle('Last Name')
            ->isSortable();

        $table->addColumn('email')
            ->setTitle('Email')
            ->isSearchable()
            ->isSortable();

        $table->addColumn('created_at')
            ->setTitle('Created At')
            ->isSortable()
            ->sortByDefault('desc')
            ->setColumnDateTimeFormat('d-M-Y');

        $table->addColumn('last_sign_in_at')
            ->setTitle('Last Login At')
            ->isSortable()
            ->setColumnDateTimeFormat('d-M-Y H:i');

        return $table;
    }

    /**
     * Method to find the user by user ID.
     *
     * @param $id
     * @return Collection
     */
    public function getUser(string $id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * Method to delete the user.
     * Actually we are not deleting the user, here user will updated with "is_active = 0".
     *
     * @param $id
     * @return bool
     */
    public function deleteUser(string $id)
    {
        return $this->userRepository->delete($id); 
    }

    /**
     * Method to update the user.
     *
     * @param $request
     * @param string $userId
     * @return bool
     */
    public function updateUser($request, string $userId) : bool
    {
        $inputData = $request->all();

        if (isset($inputData['password']) && !empty($inputData['password'])) {
            $inputData['password'] = Hash::make($inputData['password']);
        } else {
            unset($inputData['password']);
        }
        // Unset the password_confirmation field from the array.
        unset($inputData['password_confirmation']);

        if (!isset($inputData['status'])) {
            $inputData['status'] = self::IN_ACTIVE;
        }

        return $this->userRepository->update($userId, $inputData);
        
    }

    /**
     * Method to track the user update activity.
     *
     * @param string $modifiedBy
     * @param $class
     * @param $trackableFields
     * @param $dataBeforeUpdated
     * @param $dataAfterUpdated
     * @return bool
     * @throws \Exception
     */
    public function trackUserActivity($modifiedBy, $class, $trackableFields, $dataBeforeUpdated, $dataAfterUpdated) : bool
    {
        $dataAfterUpdated = $dataAfterUpdated->toArray();
        $dataBeforeUpdated = $dataBeforeUpdated->toArray();

        $updatedData = array_diff($dataAfterUpdated, $dataBeforeUpdated);

        if (empty($updatedData)) {
            return true;
        }

        $trackableData = array_only($updatedData, $trackableFields);

        if (empty($trackableData)) {
            return true;
        }

        $trackableDataToInsert = [];
        foreach ($trackableFields as $field) {
            if (isset($trackableData[$field]) && !empty($trackableData[$field])) {
                
                $information['entity_type'] = $class;
                $information['entity_id'] = $dataBeforeUpdated['id'];
                $information['field_name'] = $field;
                $information['old_value'] = $dataBeforeUpdated[$field];
                $information['new_value'] = $dataAfterUpdated[$field];
                $information['modified_by'] = $modifiedBy;
                $information['created_at'] = Carbon::now()->toDateTimeString();
                $information['updated_at'] = Carbon::now()->toDateTimeString();

                $trackableDataToInsert[] = $information;
            }
        }

        $this->userActivityRepository->insertMultipleRows($trackableDataToInsert);

        return true;
    }
}
