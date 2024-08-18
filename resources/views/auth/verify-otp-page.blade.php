@extends('layouts.master')
@section('content')

        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h2>Verify OTP Code</h2>
                    <div class="mb-3">
                        <label for="otp" class="form-label">OTP Code</label>
                        <input type="otp" name="otp" class="form-control" id="otp" autocomplete="off" />
                    </div>
                    <button onclick="verifyOTP()" class="btn btn-primary">Submit</button>
                    
                </div>
            </div>
        </div>

@endsection


@section('scripts')
<script>
    async function verifyOTP(){
        let otp = document.querySelector("#otp").value;

        if( otp.length !== 4 ){
            errorToast("Invalid OTP");
        }else{

            showLoader();
            const result = await axios.put("/verify-otp-code", {
                otp: otp,
                email: sessionStorage.getItem("email")
            });
            hideLoader();

            if(result.status === 200 &&  result.data.status === 'success'){
                successToast(result.data.message);
                sessionStorage.removeItem("email");
                setTimeout(() => {
                    window.location.href = '/reset-password';
                }, 1000);
            }
            

        }


        
    }
</script>
@endsection