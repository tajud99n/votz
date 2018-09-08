@extends ('layout.default')

@section('content')
     
          <div class="jumbotron text-center">

               <form class="form-signin" method="POST" action="/login">
                    <div class="form-group">
                         <label for="email">Email</label>
                         <input type="email" name="email" id="email" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                         <label for="password">Password</label>
                         <input type="password" name="password" id="password" class="form-control" required>
                    </div>
               
                    {{ csrf_field() }}
                    <div class="form-group">
                         
                         <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                    </div>
               </form>
          </div>
    
@endsection