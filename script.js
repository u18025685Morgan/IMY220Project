$(document).ready(()=>{

$('button#add').on('click', function() {
    $.ajax({
        url:'friendmanage.php',
        type: 'POST',
        date : {user_id: '$user_id'}
    })
    .done(data =>{
        $('div#dynamicList').append(
            $("<ul></ul>", {
                class : 'list-group list-group-flush',
                id : 'dynamicList'
            })
        );

        $('ul#dynamicList').append(data);
    })
});

});
/* <ul class='list-group list-group-flush'>
    <li class='list-group-item' id='when'>When: ". $r['date']."</li>
    <li class='list-group-item'id='where'>Where: ". $r['location']."</li>
    <li class='list-group-item'id='hash' >". $r['hashtags']."</li>
</ul> */