<!DOCTYPE html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<form method="get" action="results.php">
		<label>Keyword(s)<i class="req">*</i>: </label><input type="text" name="key" placeholder="Enter a keyword"><br>
		<label>Number of Results: </label><input type="text" name="num" placeholder="Enter a maximum number of results to show"><br>
		<label>Select a diet label: </label><br>
			<div class="diets">
				<input type="radio" name="diet" value="balanced">Balanced<br>
				<input type="radio" name="diet" value="high-protein">High-Protein<br>
				<input type="radio" name="diet" value="high-fiber">High-Fiber<br>
				<input type="radio" name="diet" value="low-fat">Low-Fat<br>
				<input type="radio" name="diet" value="low-carb">Low-Carb<br>
				<input type="radio" name="diet" value="low-sodium">Low-Sodium<br>
			</div>
		<label>Select a health label:</label><br>
			<div class="healths">
				<input type="radio" name="health" value="vegan">Vegan<br>
				<input type="radio" name="health" value="vegetarian">Vegetarian<br>
				<input type="radio" name="health" value="paleo">Paleo<br>
				<input type="radio" name="health" value="diary-free">Dairy-Free<br>
				<input type="radio" name="health" value="gluten-free">Gluten-Free<br>
				<input type="radio" name="health" value="wheat-free">Wheat-Free<br>
				<input type="radio" name="health" value="fat-free">Fat-Free<br>
				<input type="radio" name="health" value="low-sugar">Low-Sugar<br>
				<input type="radio" name="health" value="egg-free">Egg-Free<br>
				<input type="radio" name="health" value="peanut-free">Peanut-Free<br>
				<input type="radio" name="health" value="tree-nut-free">Tree-nut-free<br>
				<input type="radio" name="health" value="soy-free">Soy-Free<br>
				<input type="radio" name="health" value="fish-free">Fish-Free<br>
				<input type="radio" name="health" value="shellfish-free">Shellfish-Free<br>
			</div>
		<br>
		<label>Calorie Range: </label><br>
			<label>Low</label><input type="text" name="low" placeholder="0"><br>
			<label>High</label><input type="text" name="high" placeholder="10000"><br>
		<input type="submit" name="advsub" value="Search">
	</form>
</body>
</html>