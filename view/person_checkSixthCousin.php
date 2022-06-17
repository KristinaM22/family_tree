<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/ancestorResponse' ?>">
    <table>
        <tr>
            <td>Find first person: </td>
            <td>
                First name: <input type="text" name="inputFirst" id="inputFirst1" /><br>
                Last name: <input type="text" name="inputLast" id="inputLast1" /><br>
                <button type="button" id="search1">Search</button>
            </td>
        </tr>
        <tr>
            <td>Find second person: </td>
            <td>
                First name: <input type="text" name="inputFirst" id="inputFirst2" /><br>
                Last name: <input type="text" name="inputLast" id="inputLast2" /><br>
                <button type="button" id="search2">Search</button>
            </td>
        </tr>
    </table><br>

    <div id="showResults1"></div><div id="showResults2"></div><br>
    
    <button type="submit" name="check" id="check">Check</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script>
$(document).ready(function() {
    $( "#search1" ).click( search );
    $( "#search2" ).click( search );
});

function search(){
    var id = $(this).attr('id');
    var n = id[id.length-1];
    console.log(n);
    var firstName = $('#inputFirst' + n).val().trim();
    var lastName = $('#inputLast' + n).val().trim();

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
				    show( data, n );
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
    else $( '#showResults' + n ).text( 'Please input at least one name.' );
}

function show( data, n ){
var results = JSON.parse(data);
if( $.isArray(results) &&  results.length > 0 ) {
    var str = '<table>';
    str += '<tr><th>Osoba</th><th>Odaberi</th></tr>';
    $.each( results, function( index, value ) {
        str += '<tr><td>' + value.firstName + ' ' + value.lastName + ',<br>';
        str += value.gender + ', ' + value.birthDate + '</td>';
        str += '<td><input type="radio" name="radioOptions' + n + '" value="' + value.personID + '"';
        if( index === 0 ) str += ' checked';
        str += ' /></td></tr>'
    });
    $( '#check' ).removeAttr( "disabled" );
    str += '</table>';
    $( '#showResults' + n ).html( str );
}
else $( '#showResults' + n ).html("No result." );
}
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>