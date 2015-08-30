/******************
Francisco Charrua

used by add-question-html.twig to configure multiple choice questions:
How many choice seach one will have, and if the choices are represented
by letters or numbers.
 ******************/

$(document).ready(
        function() {            
            $('#collapseSix input[name=alpha][value=numeric]').attr('checked', true);
            
            $('#collapseSix input[name=alpha]').change(
                    function(data) {
                        if(data.target.value === 'alpha') {
                            setChoicesToAlpha();
                       }
                    
                        if(data.target.value === 'numeric') {
                            setChoicesToNumeric();
                        }
                    }
                );
            
            $('#collapseSix select').change(
                    function() {                        
                        var choices = $('#collapseSix select').val();
                        
                        for(var i = 1; $('#collapseSix #inLineLabel' + i).length > 0; i++) {
                            if(i <= choices) {
                                $('#collapseSix #inLineLabel' + i).show();
                            } else {
                                $('#collapseSix #inLineLabel' + i).hide();
                            }
                        }
                    }
                );
        }
    );
    
function setChoicesToNumeric() {
    for(var i = 1; $('#collapseSix #inLineLabel' + i).length > 0; i++) {
        $('#collapseSix #inLineLabel' + i +' span').text(i);
    }
}

function setChoicesToAlpha() {
    var letters = ['a', 'b', 'c', 'd', 'e'];
    
    for(var i = 1; $('#collapseSix #inLineLabel' + i).length > 0; i++) {
        $('#collapseSix #inLineLabel' + i +' span').text(letters[i - 1]);
    }
}

