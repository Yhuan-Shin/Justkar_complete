@foreach ($admins as $admin)  
<div class="modal fade" id="edit-admin{{ $admin->id }}" tabindex="-1" aria-labelledby="editAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.update', $admin->id)}}" class="update-admin-form" method="post">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <input type="hidden" name="role" id="role" value="admin">
                        <label for="name{{ $admin->id }}" class="form-label">Name</label>
                        <input type="text" maxlength="20" id="name{{ $admin->id }}" class="form-control admin-name" name="name" value="{{ $admin->name }}" required>
                        <div class="invalid-feedback name-error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="username{{ $admin->id }}" class="form-label">Username</label>
                        <input type="text" id="username{{ $admin->id }}" class="form-control admin-username" name="username" maxlength="20" value="{{ $admin->username }}" required>
                        <div class="invalid-feedback username-error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="password{{ $admin->id }}" class="form-label">Password</label>
                        <input type="password" id="password{{ $admin->id }}" class="form-control admin-password" maxlength="16" name="password" placeholder="Update Password" required>
                        <div class="invalid-feedback password-error"></div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function initializeValidation(form) {
            const nameInput = form.querySelector('.admin-name');
            const usernameInput = form.querySelector('.admin-username');
            const passwordInput = form.querySelector('.admin-password');
            const submitButton = form.querySelector('button[type="submit"]');
    
            const nameError = form.querySelector('.name-error');
            const usernameError = form.querySelector('.username-error');
            const passwordError = form.querySelector('.password-error');
    
            const originalName = nameInput.value;
            const originalUsername = usernameInput.value;
    
            function validateForm() {
                validateName();
                validateUsername();
                validatePassword();
                updateSubmitButton();
            }
    
            function validateName() {
                if (nameInput.value.trim().length === 0) {
                    setError(nameInput, nameError, 'Name is required');
                } else if (nameInput.value.length < 3) {
                    setError(nameInput, nameError, 'Name must be 3 characters or more');
                } else {
                    setSuccess(nameInput, nameError);
                }
            }
    
            function validateUsername() {
            if (usernameInput.value !== originalName) {
                if (usernameInput.value.trim().length === 0) {
                    setError(usernameInput, nameError, 'Username is required');
                } else if (usernameInput.value.length < 3) {
                    setError(usernameInput, nameError, 'Username must be 3 characters or more');
                } else {
                    setSuccess(usernameInput, nameError);
                }
            } else {
                clearValidation(usernameInput, nameError);
            }
        }
    
            function validatePassword() {
                if (passwordInput.value.trim().length > 0) {
                    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;
                    if (passwordInput.value.length < 4 && passwordInput.value.length <=16) {
                        setError(passwordInput, passwordError, 'Password must be between 8 and 16 characters');
                    } else if (!passwordRegex.test(passwordInput.value)) {
                        setError(passwordInput, passwordError, 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
                    } else {
                        setSuccess(passwordInput, passwordError);
                    }
                }else if(passwordInput.value.trim().length === 0) {
                    setError(passwordInput, passwordError, 'Password is required');
                }
                 else {
                    clearValidation(passwordInput, passwordError);
                }
            }
    
            function setError(input, errorElement, errorMessage) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                errorElement.textContent = errorMessage;
            }
    
            function setSuccess(input, errorElement) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                errorElement.textContent = '';
            }
    
            function clearValidation(input, errorElement) {
                input.classList.remove('is-invalid', 'is-valid');
                errorElement.textContent = '';
            }
    
            function updateSubmitButton() {
                const isValid = 
                    !nameInput.classList.contains('is-invalid') &&
                    !usernameInput.classList.contains('is-invalid') &&
                    !passwordInput.classList.contains('is-invalid');
                
                const hasChanges = 
                    nameInput.value !== originalName ||
                    usernameInput.value !== originalUsername ||
                    passwordInput.value.trim().length > 0;
    
                submitButton.disabled = !(isValid && hasChanges);
            }
    
            nameInput.addEventListener('input', validateName);
            usernameInput.addEventListener('input', validateUsername);
            passwordInput.addEventListener('input', validatePassword);
    
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                validateForm();
    
                if (!form.querySelector('.is-invalid')) {
                    form.submit();  // Ensure the form submits if there are no errors
                }
            });
        }
        document.querySelectorAll('.update-admin-form').forEach(initializeValidation);
    });
</script>
