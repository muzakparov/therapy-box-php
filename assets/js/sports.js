$(document).ready(function () {
    console.log('ready')

    var inputStr;

    $(".team-name").keyup(function (e) {
        inputStr=e.target.value;
        if(e.which==13){
            console.log('change');

            ajaxTeams(inputStr)

        }
    });

    $(".list-teams").click(function () {
        if(inputStr!==''){
            ajaxTeams(inputStr)
        }
    })
});

function ajaxTeams(inputStr) {
    $.get( "ajax/sports.php?teamName="+inputStr, function( data ) {
        console.log('data', data);
        $('.loser-teams').html(data);
    });
}