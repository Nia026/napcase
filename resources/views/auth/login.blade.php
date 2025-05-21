<form action="{{ route('login.action') }}" method="POST">
  @csrf
  <input type="email" name="email" placeholder="Email">
  <input type="password" name="password" placeholder="Password">
  <button type="submit">Login</button>
</form>