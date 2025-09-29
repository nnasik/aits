<div class="modal fade" id="modal-user-permission" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">User Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{route('user.addRole')}}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="role" class="col-md-4 col-form-label text-md-end">Select Role</label>
                        <div class="col-md-8">
                            <select class="form-select" name="role" id="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Permission</button>
                </div>
            </form>
            
        </div>
    </div>
</div>