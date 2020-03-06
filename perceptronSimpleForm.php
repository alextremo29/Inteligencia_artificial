<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<title>Perceptron simple</title>
</head>
<body>
	<div class="container">
		<h1>Inserte los valores</h1>
		<div class="row">
			<div class="col-md-3">
				<label>w1</label>
				<br>
				<input type="number" name="txt_w1" id="txt_w1" class="form-control">
			</div>
			<div class="col-md-3">	
				<label>w2</label>
				<br>
				<input type="number" name="txt_w2" id="txt_w2" class="form-control">
			</div>
			<div class="col-md-3">
				<label>e</label>
				<br>
				<input type="number" name="txt_e" id="txt_e" class="form-control">
			</div>
			<div class="col-md-3">
				<label>theta</label>
				<br>
				<input type="number" name="txt_theta" id="txt_theta" class="form-control">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12">
				<button onclick="calcularPerceptron();" class="btn btn-success">Calcular</button>
			</div>
		</div>
		<hr>
		<div id="variables" style="display: none;">
			<h1>Probar neurona</h1>
			<div class="row">
				<div class="col-md-6">
					<label>X1</label>
					<br>
					<input type="number" name="txt_x1" id="txt_x1" class="form-control">
				</div>
				<div class="col-md-6">
					<label>X2</label>
					<br>
					<input type="number" name="txt_x2" id="txt_x2" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button onclick="probar_compuerta();" class="btn btn-success">Calcular</button>
				</div>
			</div>
		</div>
		<div id="respuesta"></div>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</html>
<script type="text/javascript">
	var valoresNeurona;
	function calcularPerceptron() {
		$("variables").hide();
		var data ={
			metodo:"calcular_w",
			w1:$("#txt_w1").val(),
			w2:$("#txt_w2").val(),
			e:$("#txt_e").val(),
			theta:$("#txt_theta").val(),
		};
		$.post('perceptronSimple.php', data).done(function(resp) {
			$("#respuesta").html(resp)
			resp = jQuery.parseJSON(resp);
			console.log(resp.code);
			if (resp.code == 1) {
				$("#variables").show();
				valoresNeurona = resp;
			} else{
				$("#respuesta").html("<h2>No fue posible calcular el valor<h2>")
			}
			
		}).fail(function(err) {
			console.log("error",err);
		});
	}
	function probar_compuerta() {
		var x1 = $("#txt_x1").val();
		var x2 = $("#txt_x2").val();

		var data ={
			metodo:"calcular_x",
			w1:valoresNeurona.w1,
			w2:valoresNeurona.w2,
			e:valoresNeurona.e,
			theta:valoresNeurona.theta,
			x1:$("#txt_x1").val(),
			x2:$("#txt_x2").val()
		};
		$.post('perceptronSimple.php', data).done(function(resp) {
			$("#respuesta").html("<p>"+resp+"</p>");
		}).fail(function(err) {
			console.log("error",err);
		});
	}
</script>