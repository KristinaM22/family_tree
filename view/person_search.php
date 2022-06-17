<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/show' ?>">
    <table>
        <tr>
            <td>Find person: </td>
            <td>
                First name: <input type="text" name="inputFirst" id="inputFirst" /><br>
                Last name: <input type="text" name="inputLast" id="inputLast" /><br>
                <button type="button" id="search">Search</button>
            </td>
        </tr>
    </table><br>

    <div id="showResults"></div><br>
    
    <button type="submit" name="selected" id="show" disabled>Show</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script>
$(document).ready(function() {

    $(document).on("click", "input[name=radioOptions]:radio", function(){
        var id = $("input:radio[name=radioOptions]:checked").val();
        $( '#show' ).val(id);
    });

    $( "#search" ).click( search );
});

function search(){
    var firstName = $('#inputFirst').val().trim();
    var lastName = $('#inputLast').val().trim();

    if(firstName.length !== 0 || lastName.length !== 0){
        $.ajax(
        {
            url: window.location.origin + window.location.pathname + '?rt=person/searchResult',
            type: 'GET',
            contentType: 'application/json',
            data:
            {
                firstNameSearch: firstName,
                lastNameSearch: lastName
            },
            success: function( data )
		    {
                console.log(data);

			    if( typeof( data.error ) === "undefined" )
			    {
				    show( data );
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
    else $( '#showResults' ).text( 'Please input at least one name.' );
}

function show( data ){
var results = JSON.parse(data);
if( $.isArray(results) &&  results.length > 0 ) {
    var str = '<table>';
    str += '<tr><th>Osoba</th><th>Odaberi</th></tr>';
    $.each( results, function( index, value ) {
        str += '<tr><td>' + value.firstName + ' ' + value.lastName + ',<br>';
        str += value.gender + ', ' + value.birthDate + '</td>';
        str += '<td><input type="radio" name="radioOptions" value="' + value.personID + '"';
        if( index === 0 ){
            str += ' checked';
            $( '#show' ).val(value.personID);
        }
        str += ' /></td></tr>'
    });
    $( '#show' ).removeAttr( "disabled" );
    str += '</table>';
    $( '#showResults' ).html( str );
}
else $( '#showResults' ).html("No result." );
}
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>