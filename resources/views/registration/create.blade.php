@extends ('layout.default')

@section('content')
     <div class="Jumbotron text-center">
          <h1>Register</h1>

          <form class="form-signin" method="POST" action="/register">
               <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
               </div>
               <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
               </div>
               <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
               </div>
               <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
               </div>
               <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
               </div>
               {{ csrf_field() }}
               <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
               </div>
          </form>
     </div>
@endsection