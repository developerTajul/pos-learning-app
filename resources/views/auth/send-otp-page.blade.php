@extends('layouts.master')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2>Send OTP to Email Address</h2>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" autocomplete="off" />
            </div>
            <button onclick="sendOTP()" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function sendOTP(){
        let email = document.querySelector("#email").value;
        if( email.length == 0 ){
            errorToast("Email Address is required");
        }else{
            showLoader();
            const result = await axios.post("/forget-password", {
                email : email
            });
            hideLoader();

            if(result.status == 200 && result.data.status == 'success'){
                successToast(result.data.message);
                sessionStorage.setItem('email', email);
                setTimeout(() => {
                    window.location.href = '/verify-otp-code';
                }, 1000);
            }else{
                errorToast(result.data.message);
            }
        }



    }
</script>
@endsection