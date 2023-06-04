    // $(document).ready(function () {  
        
        $('#reg-btn').click(function(){
        $('#reg').css('display','flex')
        $('#login').css('display', 'none')
    })

        $('form').on('submit', function(e){
            

            var username = $('#username').val();
            var password = $('#password').val();

            if(username === '' || password === ''){
                $('.error').text("fill out all fields!")
                e.preventDefault();
            }else{

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json', // Expecting JSON response
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log('Login success');
                            // Redirect or perform success action
                        } else {
                            $('.error').text(response.message); // Display error message
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('AJAX Error:', textStatus, errorThrown);
                        $('#error-message').text('An error occurred. Please try again later.');
                    }
                });
            }
        })

    // });

