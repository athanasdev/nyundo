 @if ($errors->any())
     <div class="alert-error">
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif

 @if (session('error'))
     <div class="alert-error">
         {{ session('error') }}
     </div>
 @endif
 @if (session('success'))
     <div class="alert alert-success">
         {{ session('success') }}
     </div>
 @endif
