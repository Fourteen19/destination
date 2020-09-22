<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin\Admin;

use App\Repositories\AdminRepositoryInterface;
use Illuminate\Support\Collection;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{

   /**
    * AdminRepository constructor.
    *
    * @param Admin $model
    */
   public function __construct(Admin $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   public function all(): Collection
   {
       return $this->model->all();    
   }

/*
   public function update($id)
   {

   }
*/
   public function delete($id)
   {

        DB::beginTransaction();

        try {
            
            $user = $this->model->find(4);
          
            if (!$user) {
                throw new ModelNotFoundException('User could not be found');
            }
            
            $user->delete();

            DB::commit();
            
            return True;

        } catch (Exception $e) {

            DB::rollBack();

            throw new GeneralException("Your user could not be deleted", 0, $e);
        }
        
        return False;

   }


}