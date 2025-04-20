<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>vynxtravel</title>
       @stack('prepend-style')
       @include('includes.style')
       @stack('addon-style')
    </head>
    <body>
        @include('includes.navbar')
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @yield('content')
        @include('includes.footer')
        @stack('prepend-script')
        @include('includes.script')
        @stack('addon-script')

        <script>
            // Auto-dismiss alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const successAlert = document.getElementById('success-alert');
                const errorAlert = document.getElementById('error-alert');

                if (successAlert) {
                    setTimeout(function() {
                        successAlert.classList.remove('show');
                        setTimeout(function() {
                            successAlert.remove();
                        }, 150); // Wait for fade out animation
                    }, 5000);
                }

                if (errorAlert) {
                    setTimeout(function() {
                        errorAlert.classList.remove('show');
                        setTimeout(function() {
                            errorAlert.remove();
                        }, 150); // Wait for fade out animation
                    }, 5000);
                }
            });
        </script>          
    </body>
</html>
