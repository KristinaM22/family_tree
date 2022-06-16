<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form>
    <table>
        <tr>
            <td>Find person: </td>
            <td>
                First name: <input type="text" name="inputFirst" id="inputFirst" /><br>
                Last name: <input type="text" name="inputLast" id="inputLast" /><br>
                <button id="search">Search</button>
            </td>
        </tr>
    </table><br>

    <div id="showResults"></div><br>
    
    <button type="submit" name="showPerson" id="show" disabled>Show</button>
</form>

<script>
$(document).ready(function() {
    $( "#search" ).click( search );
});

function search(){
    var firstName = $('#inputFirst').val().trim();
    var lastName = $('#inputLast').val().trim();

    if(firstName.length !== 0 || lastName.length !== 0){
        $.ajax(
        {
            url: "/person/search",
            type: 'GET',
            contentType: 'application/json',
            dataType: 'json',
            data:
            {
                firstName: firstName,
                lastName: lastName
            },
            success: function( data )
		    {
			    //console.log( JSON.stringify( data ) );
                console.log("ok");

			    if( typeof( data.error ) === "undefined" )
			    {
				    show( data );
                    $( '#show' ).removeAttr( "disabled" );
			    }
                else console.log( typeof( data.error ) );
		    },
		    error: function( xhr, status )
		    {
			    console.log( status, this.data );

			    if( status === "timeout" );
				    console.log('timeout');
		    }
        })
    }
    else $( '#showResults' )html( 'Please input at least one name.' );
}

function show( data ){
    var str = '<table>';
    $.each( data, function( index, value ) {
        str += '<tr><td>' + value.firstName + value.lastName + ',<br>';
        str += value.gender + ', ' + value.birthDate + '</td>';
        str += '<td><button type="radio" name="options" value=' + value.personID;
        if( index === 0 ) str += 'checked';
        str += ' >Odaberi</button></td></tr>'
    });
    str += '</table>';
    $( '#showResults' ).html( str );
}
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>