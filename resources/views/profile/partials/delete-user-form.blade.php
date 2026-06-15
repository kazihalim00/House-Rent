<section class="space-y-6">
    <header>
        <h4 class="text-danger fw-bold">Delete Account</h4>
        <p class="text-secondary small">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
    </header>


    <button type="button" class="btn btn-danger mt-3 px-4 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        <i class="fa-solid fa-user-xmark me-2"></i> Delete Account
    </button>


    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-secondary">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title text-white fw-bold" id="deleteAccountModalLabel">Are you sure you want to delete your account?</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body text-secondary">
                        <p class="mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label text-light">Password</label>
                            <input type="password" id="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="Enter your password to confirm">
                            @error('password') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>