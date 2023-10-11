<h4>Hello!</h4>
<p>You are receiving this email because we received a password reset request for your account.</p>

<button><a href="{{ route('show.reset.password.form', $token) }}">Reset Password</a></button>
<p>This password reset link will expire in 3 hour.</p>
<p>If you did not request a password reset, no further action is required.</p>
