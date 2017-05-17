$(document).ready(function(){
    $("form").submit(function(e){
        var first_name = document.getElementById("fn");
        var last_name = document.getElementById("ln");
        var phone = document.getElementById("phone");
        if(first_name.value === ""){
            e.preventDefault();
            document.getElementById("fn").style.backgroundColor = "red";
        }
        else{
        	document.getElementById("fn").style.backgroundColor = "white";
        }

        if(last_name.value === ""){
            e.preventDefault();
            document.getElementById("ln").style.backgroundColor = "red";
        }
        else{
            document.getElementById("ln").style.backgroundColor = "white";
        }

        if(phone.value === ""){
            e.preventDefault();
            document.getElementById("phone").style.backgroundColor = "red";
        }
        else{
            document.getElementById("phone").style.backgroundColor = "white";
        }


	});
})