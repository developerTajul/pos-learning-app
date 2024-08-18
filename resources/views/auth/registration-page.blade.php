@extends('layouts.master')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2>Register page</h2>
            
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name </label>
                    <input type="first_name" name="first_name" class="form-control" id="first_name" autocomplete="off" />
                </div>
            
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name </label>
                    <input type="last_name" name="last_name" class="form-control" id="last_name" autocomplete="off" />
                </div>
            
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="off" />
                </div>
            
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone </label>
                    <input type="phone" name="phone" class="form-control" id="phone" autocomplete="off" />
                    </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" autocomplete="off" />
                </div>
                <button onclick="registerLogin()" class="btn btn-primary">Submit</button>
            
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>

    async function registerLogin() {

        const first_name = document.querySelector('#first_name').value;
        const last_name = document.querySelector('#last_name').value;
        const email = document.querySelector('#email').value;
        const phone = document.querySelector('#phone').value;
        const password = document.querySelector('#password').value;

        if( first_name.length == 0  ){
            errorToast("First Name is required");
        }else if(last_name.length == 0 ){   
            errorToast("Last Name is required");
        }else if(email.length == 0 ){   
            errorToast("Email is required");
        }else if(phone.length == 0 ){   
            errorToast("Phone is required");
        }else if(password.length == 0 ){   
            errorToast("Password is required");
        }else{
            try{
                showLoader();
                const regInof = {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    phone: phone,
                    password: password
                }
                let result = await axios.post('/register', regInof);
                hideLoader();

                if(result.status === 200 && result.data.status == 'success'){
                    window.location.href = '/login';
                }

            }catch(error){
                hideLoader();
                console.error("An error occurred:", error); // Log any errors
                errorToast("An error occurred, please try again.");
            }
        }

    }    
</script>

@endsection
