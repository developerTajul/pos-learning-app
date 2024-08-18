@extends('layouts.master')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2>Login page</h2>
                
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" autocomplete="off" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" autocomplete="off" />
                    </div>
                    <button onclick="submitLogin()" class="btn btn-primary">Submit</button>
                
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    async function submitLogin(){
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if( email.length == 0  ){
            errorToast("Email is required");
        }else if(password.length == 0 ){   
            errorToast("Password is required");
        }else{
            try{
                showLoader();
                let result = await axios.post('/login', {
                    email: email,
                    password: password
                });
                hideLoader();
                
                if(result.status === 200 && result.data.status == 'success'){
                    window.location.href = '/dashboard';
                }
                alert("successful");
            }catch(error){
                alert("Fail inside");
                hideLoader();
                console.error("An error occurred:", error); // Log any errors
                errorToast("An error occurred, please try again.");
            }

        }
    }
</script>

@endsection