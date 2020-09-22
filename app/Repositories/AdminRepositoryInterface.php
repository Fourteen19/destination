<?php

namespace App\Repositories;
		  
use App\Models\Admin\Admin;
use Illuminate\Support\Collection;

Interface AdminRepositoryInterface
{

    public function all(): Collection;

    //public function create(array $data);

    //public function update(array $data, Admin $admin);

    public function delete($id);

}