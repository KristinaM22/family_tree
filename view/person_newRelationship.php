<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<form method="post" action="<?php echo __SITE_URL . '/familytree.php?rt=person/addNewRelationship' ?>">
    <table>
        <tr>
            <td>Type of relationship: </td>
            <td>
                <select id="relationshipType" name="relationshipType">
                    <option value="offspring" selected>Child</option>
                    <option value="partner">Partner</option>
                </select>
            </td>
        </tr>
        <tr>
            <td id="set"></td>
            <td><input type="checkbox" id="setValue" name="setValue" value="1" /><label for="setValue">Set</label></td>
        </tr>
        <tr>
            <td>Find person: </td>
            <td>
                First name: <input type="text" name="inputFirst" id="inputFirst" /><br>
                Last name: <input type="text" name="inputLast" id="inputLast" /><br>
                <button id="search" type="button">Search</button>
            </td>
        </tr>
    </table><br>

    <div id="showResults"></div><br>
    
    <button type="submit" name="add" id="add" value="<?php echo $id ?>" disabled>Add</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script>
$(document).ready(function() {
    $( "#relationshipType" ).change(function () {
        var str = "";
        $( "select option:selected" ).each(function() {
            if( $( this ).val() === "offspring" )
                str = "Adopted";
            else str = "Married";
        });
        $( "#set" ).text( str );
    }).change();

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
        if( index === 0 ) str += ' checked';
        str += ' /></td></tr>'
    });
    $( '#add' ).removeAttr( "disabled" );
    str += '</table>';
    $( '#showResults' ).html( str );
}
else $( '#showResults' ).html("No result." );
}
</script>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>