<a href="{{ route("admin.admins.edit", ["admin" => $user->uuid]) }}" class="edit btn btn-primary btn-sm">Edit</a>
<button class="open-delete-modal btn btn-danger" data-id="{{$user->uuid}}">Delete</button>