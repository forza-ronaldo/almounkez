<div class="container">
    @if(session()->has('reSendEmailVerifiedSuccess'))
        <div> {{session()->get('reSendEmailVerifiedSuccess')}}</div>
    @endif()
    <div class="text-center alert alert-danger">
        <h1>The account has not been verified</h1>
        <h2>Please go to your email to verify the mail that we have sent to you to confirm your account</h2>
        <form action="{{route('reSendEmailVerified',auth()->id())}}" method="post">
            @csrf()
            <input type="submit" value="resend">
        </form>
    </div>
</div>
