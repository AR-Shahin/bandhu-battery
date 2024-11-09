<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Customer;
use App\Repositories\BaseCRUDRepository;

class CustomerController extends Controller
{
    private $repository;
    private $table = "customers";

    function __construct()
    {
        parent::__construct();
        $this->repository = new BaseCRUDRepository(new Customer());
    }

    function index(Request $request)  {
        if($request->ajax()){

            return $this->table($this->repository->query())
                ->addIndexColumn()
                ->addColumn("actions",function($row) {
                    $deleteRoute = route('admin.customers.destroy', $row["id"]);
                    $editRoute = route('admin.customers.update', $row["id"]);
                    $html = $this->generateEditButton($row,$editRoute) ;
                    // .  $this->generateDeleteButton($row,$deleteRoute,"admin-delete","DELETE");
                    return $html;
                })

                ->rawColumns(["actions","status"])
                ->make(true);
        }
        return view("admin.customer.index");
    }

    function destroy($customer) {
        if($this->repository->delete($customer)){
            $this->deletedAlert();
            return back();
        }
    }

    function store(Request $request) {
        $request->validate([
            "name" => ["required"],
            "email" => ["required"],
            "phone" => ["required","unique:$this->table,phone"],
            "address" => ["required"],
        ]);
        if(
            $this->repository->store([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "phone_2" => $request->phone_2,
                "address" => $request->address,
            ])
        ){
            $this->createdAlert();
            return back();
        }
    }

    function update(Request $request,$id) {
      //  return $request;
        // $request->validate([
        //     "name" => ["required"],
        //     "email" => ["required"],
        //     "phone" => ["required","unique:$this->table,phone"],
        //     "address" => ["required"],
        // ]);
        if(
            $this->repository->update($id,[
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "phone_2" => $request->phone_2,
                "address" => $request->address,
            ])
        ){
            $this->updatedAlert();
            return back();
        }
    }


    protected function generateEditButton($row, $route)
    {
        $html = '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#rowId_' . $row['id'] . '">
            <i class="fa fa-edit"></i>
        </button>
        <div class="modal fade" id="rowId_' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="rowId_' . $row['id'] . 'Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="' . $route . '" method="post">
                    <div class="modal-content text-left">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rowId_' . $row['id'] . 'Label">Edit ' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group">
                                <label for="name_' . $row['id'] . '">Name</label>
                                <input type="text" class="form-control" id="name_' . $row['id'] . '" name="name" value="' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '" placeholder="Enter name">
                            </div>

                            <div class="form-group">
                                <label for="email_' . $row['id'] . '">Email</label>
                                <input type="email" class="form-control" id="email_' . $row['id'] . '" name="email" value="' . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . '" placeholder="Enter email">
                            </div>

                            <div class="form-group">
                                <label for="phone_' . $row['id'] . '">Phone</label>
                                <input type="text" class="form-control" id="phone_' . $row['id'] . '" name="phone" value="' . htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') . '" placeholder="Enter phone">
                            </div>

                            <div class="form-group">
                                <label for="phone_2_' . $row['id'] . '">Phone 2</label>
                                <input type="text" class="form-control" id="phone_2_' . $row['id'] . '" name="phone_2" value="' . htmlspecialchars($row['phone_2'], ENT_QUOTES, 'UTF-8') . '" placeholder="Enter secondary phone">
                            </div>

                            <div class="form-group">
                                <label for="address_' . $row['id'] . '">Address</label>
                                <textarea class="form-control" id="address_' . $row['id'] . '" name="address" placeholder="Enter address">' . htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8') . '</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>';

        return $html;
    }


}
