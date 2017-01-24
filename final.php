<!DOCTYPE html>
<html>
    <link rel="stylesheet" type="text/css" href="final.css">
    <link rel="weatherstyles" type="text/css" href="https://raw.githubusercontent.com/patharanordev/weather-icon-animated/master/css/weather-icon-animated.css">
    <link rel="shortcut icon" href="http://www.cloud9assist.com/wp-content/uploads/2015/11/Favicon-Cloud-9-Assist.png">
    <!--<link ref="stylesheet" href="http://fast.fonts.net/cssapi/b5004cbc-0880-4343-aa8b-051ad7d423aa.css">-->
    <body>
    <title>aurora</title>
    <div id="time"></div><br><br>

	<greeting>
	<?php
		echo "Hello, " , $_POST[name], ".". "<br>";
		echo "</greeting>";
		//echo $_POST[zc]."<br>";
		//echo $_POST[ss]."<br>";
 	 ?>
	
	<br>
	<article id="weather">
		<div id="temp"></div>	
		<div id="advice"></div><br>
	</article>
	<article>
		<div id="horoscope"></div>
	</article>
	
	<br><br>
	<form action="db.php" method="post">
		<input type="hidden" id="t" name="t" value="" />
		<input type="hidden" id="n" name="n" value="" />
		<input type="hidden" id="w" name="w" value="" />
		<button type="submit">See Past Results</button>
	</form>
  
    </body>
    
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    var d, h, m, s, color; 
    function getTime(){
        d=new Date();
        h=d.getHours();
        m=d.getMinutes();
        s=d.getSeconds(); 
        
        if (h<=9) h='0'+h;
        if (m<=9) m='0'+m;
        if (s<=9) s='0'+s;
        
        color='#'+h+m+s; 
        document.body.style.background = color;
        document.getElementById("time").innerHTML=h+':'+m+':'+s;
        setTimeout(getTime, 1000);
        
    }
    getTime();
    
    function getT(){
    	document.getElementById('t').value = document.getElementById("time").innerHTML; 
    }
     function getN(){
    	var name="<?php echo $_POST[name] ?>";
    	document.getElementById('n').value = name;
    }
     function getW(){
    	document.getElementById('w').value = document.getElementById("weather").innerHTML; 
    }
    
    $(document).ready(function(){
		var zipcode="<?php echo $_POST[zc] ?>"
		var sign="<?php echo $_POST[ss] ?>"
		sign=sign.toLowerCase();
		$.ajax({
	    	url: "http://api.openweathermap.org/data/2.5/weather?zip="+zipcode+",us&appid=9ab6eedd554309aa0ed0dd7ebae0497d", 
	    	//data argument
	    	success: function(response){
			var curT = response.main.temp;
			curT = (curT-273)*(9/5)+32;
			curT = Math.round(curT);
			var loc=response.name;
			var desc=response.weather[0].main;
			$('#temp').html(desc+" in "+loc+" ("+curT+" °F)");
			var message = "";
			if(curT<40)
				message = "Bundle up! It's cold out!";
			if(curT>= 40 && curT<80)
				message = "Bring a light jacket out with you!";
			if(temp>=80)
				message = "Stay cool and hydrated!";
			if(response.main.humidity > 95)
				message = message + "\nIt might rain so grab your umbrella!"
			$('#advice').html(message);
			
			getW();
			
			$.ajax({
			url: "http://theastrologer-api.herokuapp.com/api/horoscope/"+sign+"/today", 
	    			//data argument
	    			success: function(response){
	    				console.log(response);
	    				var obj = response
	    				var horo = obj.horoscope;
	    				console.log(horo)
	    				$("#horoscope").html(horo)
    		}
			});
	    	}
		});
    })
	
	getT();
	getN();
	//getW();
	//getH();

</script>