<form method="POST" action="{{ route('register') }}">
  @csrf
  <!-- Name -->
  <input type="text" name="name" placeholder="name" required>

  <!-- Email -->
  <input type="email" name="email" placeholder="email" required>

  <!-- Password -->
  <input type="password" name="password" placeholder="password" required>

  <!-- Role -->
  <select name="role" required>
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select>

  <button type="submit">Register</button>
</form>