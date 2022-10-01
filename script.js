$(document).ready(()=>{

let going = `<form action='home.php' method='POST' enctype='multipart/form-data'>
<div class='form-group'>
    <label for="eventAttendImage">Attach an image from the event!</label>
    <input type="file" class="form-control-file" id="eventAttendImage"><br>
    <label for="eventAttendReview">Comments</label>
    <textarea class="form-control" id="eventAttendReview" rows="3"></textarea><br>
    <div class="rate">
        <input type="radio" id="star5" name="rate" value="5" />
        <label for="star5" title="text">5 stars</label>
        <input type="radio" id="star4" name="rate" value="4" />
        <label for="star4" title="text">4 stars</label>
        <input type="radio" id="star3" name="rate" value="3" />
        <label for="star3" title="text">3 stars</label>
        <input type="radio" id="star2" name="rate" value="2" />
        <label for="star2" title="text">2 stars</label>
        <input type="radio" id="star1" name="rate" value="1" />
        <label for="star1" title="text">1 star</label>
    </div>
    
	<input type='submit' class='btn btn-dark' value='Attend' name='submit' />
</div>
</form>`;
$("input.form-check-inline").on("click", function(){
    $("div.card-body").append(going);
});

});