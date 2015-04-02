<?php namespace App\Http\Controllers;

use App\Repositories\Criteria\Role\RolesWithPermissions;
use App\Repositories\PermissionRepository as Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller {

	private $permission;

	public function __construct(Permission $permission)
	{
		$this->permission = $permission;
	}

	public function index()
	{
		$permissions = $this->permission->paginate(10);
		return view('permissions.index', compact('permissions'));
	}

	public function create()
	{
		return view('permissions.create');
	}

	public function store(Request $request)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required'));

		$this->permission->create($request->all());

		return redirect('/permissions');
	}

	public function edit($id)
	{
		$permission = $this->permission->find($id);
		return view('permissions.edit', compact('permission'));
	}


	public function update(Request $request, $id)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required'));

		$permission = $this->permission->find($id);
		$permission->update($request->all());

		return redirect('/permissions');
	}

	public function destroy($id)
	{
		$this->permission->delete($id);
	}

}