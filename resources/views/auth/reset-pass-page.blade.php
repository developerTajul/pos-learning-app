@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2>Reset Login Page</h2>
                
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" autocomplete="off" />
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" id="cpassword" autocomplete="off" />
                    </div>
                    <button onclick="passwordChangeKorbo()" class="btn btn-primary">Submit</button>
                
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>
    async function passwordChangeKorbo(){
        let password = document.querySelector("#password").value;
        let cpassword = document.querySelector("#cpassword").value;
        if( password.length == 0 ){
            errorToast("Password is required");
        }else if(cpassword.length == 0 ){
            errorToast("Confirm password is required");
        }else if( password != cpassword ){
            errorToast("Password and confirm password does not match");
        }else{
            try{
                showLoader();
                let result = await axios.put('/reset-password', {
                    password: password
                });
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