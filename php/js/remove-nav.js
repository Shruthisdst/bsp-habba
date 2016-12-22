 $(document).ready(function() {

    var isWider = $( '.wider' );
    isWider.next( '.container' ).addClass( 'push-down' );

    if(isWider.length) {
		
        $( window ).scroll(function() {
		
            var tp = $(window).scrollTop();

            if(tp > 50) {
                $( '.navbar' ).hide();
                
            }
            else if(tp < 50) {
        
                $( '.navbar' ).show();
               
            }
        }); 
    }
 });
